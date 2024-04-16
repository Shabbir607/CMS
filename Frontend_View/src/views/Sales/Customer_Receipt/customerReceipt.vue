<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Customer Payment</h3>
            </div>
            <div class="buttn">
                <router-link to="/transaction/new/receipt/create" type="button" class="btn1"><i class="fa-solid fa-plus"></i>Add
                    New</router-link>
            </div>
        </div>
    </div>

    <div class="card my-4">
        <form class="row">
            <div class="col-md-3">
                <label for="fdate" class="form-label">From Date</label>
                <input type="date" v-model="fromDate" class="form-control" id="fdate">
            </div>
            <div class="col-md-3">
                <label for="tdate" class="form-label">To Date</label>
                <input type="date" v-model="toDate" class="form-control" id="tdate">
            </div>
            <div class="col-md-4">
                <label for="ReceiptNo" class="form-label">Receipt No</label>
                <input type="text" id="ReceiptNo" placeholder="Receipt No" v-model="selectedReceiptNo" class="form-control">
            </div>
            <div class="col-md-1 filter-search" @click="applyFilter">
                <img class="search-icon" src="../../../assets/search_icons/3.png" alt="">
            </div>
        </form>
        <hr class="mt-5">
        <div class="searching">
            <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" class="search-bar"
                placeholder="search">
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="table-success">
                    <th scope="col">Received From</th>
                    <th scope="col">Receipt No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="this.loading">
                <tr>
                    <td colspan="7">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <strong class="mx-3">Loading...</strong>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr v-for="item in customerPayment.data" :key="item.id">
                    <td>{{ item.customer.name }}</td>
                    <td>{{ item.receipt_no }}</td>
                    <td>{{ formatTableDate(item.date) }}</td>
                    <td>{{ item.amount }}</td>
                    <td> <span style="background-color: rgb(3, 227, 3); padding: 3px 20px; border-radius: 4px;">{{item.pay_mode}} </span></td>
                    <td>
                        <router-link :to="{ path: '/paymentcustomerView/'+item.id }">
                                    <i class="fa-regular fa-eye"></i>
                                </router-link>
                        <i @click="deleteRecord(item.id)" class="fa-solid fa-trash mx-3"></i>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="form-group d-flex mx-3">
                <label for="itemsPerPage">Rows per page:</label>
                <select class="form-control mx-2" id="itemsPerPage" v-model="itemsPerPage" @change="updateItemsPerPage">
                    <option v-for="option in itemsPerPageOptions" :key="option" :value="option">{{ option }}</option>
                </select>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                        <a class="page-link" @click="dataFetch(currentPage - 1)" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                        <a class="page-link" @click="dataFetch(page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                        <a class="page-link" @click="dataFetch(currentPage + 1)" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
import { format } from 'date-fns';





export default {
    name: 'SalesInvoice',
    
    data() {
        return {
            customerPayment: '',
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],

            fromDate: this.calculateFourMonthsAgo(),
            toDate: this.getCurrentDate(),
            fd: '',
            td: '',
            selectedReceiptNo: '',

            loading: false,
        }
    },


    methods: {
        async dataFetch(page, filterParams = '') {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/customer_receipt/index?${filterParams}&page=${page}&per_page=${this.itemsPerPage}`);
                this.customerPayment = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;
                console.log(response)
                this.loading = ! true;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        applyFilter() {
            const receipt = this.selectedReceiptNo;
            const formattedDate = format(new Date(this.fromDate), 'dd/MM/yyyy');
            this.fd = formattedDate;
            const formattedDate2 = format(new Date(this.toDate), 'dd/MM/yyyy');
            this.td = formattedDate2;
            

            const filterParams = `receipt=${receipt}&start=${formattedDate}&end=${formattedDate2}`;

            this.dataFetch(this.currentPage, filterParams);
        },

        formatTableDate(date) {
            return format(new Date(date), 'dd-MMM-yyyy');
        },

        getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        calculateFourMonthsAgo() {
            const today = new Date();
            today.setMonth(today.getMonth() - 4);
            const formattedDate = today.toISOString().split('T')[0];

            return formattedDate;
        },
        updateItemsPerPage() {
            this.dataFetch(this.currentPage);
        },


        deleteRecord(Id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/customer_receipt/delete/${Id}`)
                    .then(res => {
                        this.dataFetch();
                        toast.error(res.data.message, {
                            autoClose: 1000,
                        });
                    }).catch((error) => {
                        console.error('Error Deleting data:', error);
                    })
            }
        },
    },


    mounted() {
        this.dataFetch(this.currentPage);
    }
}
</script>

<style scoped>
.dropdown-menu li {
    padding-left: 10px;
    margin: 10px;
    cursor: pointer;
}

.fa-ellipsis-vertical {
    padding: 0 10px;
    cursor: pointer;
}
</style>
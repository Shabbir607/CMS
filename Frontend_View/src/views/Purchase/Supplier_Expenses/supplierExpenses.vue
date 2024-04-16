<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Expenses</h3>
            </div>
            <div class="buttn">
                <router-link to="/expenses/create" type="button" class="btn1">
                    <i class="fa-solid fa-plus"></i>Add New
                </router-link>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="row">
            <div class="col-md-5">
                <label for="fdate" class="form-label">From Date</label>
                <input type="date" v-model="fromDate" class="form-control" id="fdate">
            </div>
            <div class="col-md-5">
                <label for="tdate" class="form-label">To Date</label>
                <input type="date" v-model="toDate" class="form-control" id="tdate">
            </div>
            <div class="col-md-1 filter-search" @click="applyFilter">
                <img class="search-icon" src="../../../assets/search_icons/3.png" alt="">
            </div>
        </div>
        <div class="mt-3">
            <!-- <div class="searching">
                <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" class="search-bar"
                    placeholder="search">
            </div> -->
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="table-success">
                        <th scope="col">Supplier</th>
                        <th scope="col">Voucher No</th>
                        <th scope="col">Narration</th>
                        <th scope="col">Date</th>
                        <th scope="col">Total</th>
                        <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody v-if="this.loading">
                <tr>
                    <td colspan="6">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <strong class="mx-3">Loading...</strong>
                        </div>
                    </td>
                </tr>
            </tbody>
                <tbody>
                    <tr v-for="item in supplierExpenses.data" :key="item.id">
                        <td>{{ item.supplier.name }}</td>
                        <td>{{ item.exp }}</td>
                        <td>{{ item.narration }}</td>
                        <td>{{ formatTableDate(item.date) }}</td>
                        <td>{{ item.total_amount }}</td>
                        <td style="text-align: center;">
                            <router-link :to="{ path: '/supplierexpensesView/'+item.id }">
                                <i class="fa-regular fa-eye"></i>
                            </router-link>
                            <i class="fa-solid fa-trash" @click="deleteRecord(item.id)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
    name: 'SupplierPage',
    data() {
        return {
            supplierExpenses: [],
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],

            fromDate: this.calculateFourMonthsAgo(),
            toDate: this.getCurrentDate(),
            fd: '',
            td: '',

            loading: false,
        }
    },
    methods: {
        async dataFetch(page, filterParams = '') {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/expenses/index?${filterParams}&page=${page}&per_page=${this.itemsPerPage}`);
                console.log(response)
                this.supplierExpenses = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;

                this.loading = ! true;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        applyFilter() {
            const formattedDate = format(new Date(this.fromDate), 'dd/MM/yyyy');
            this.fd = formattedDate;
            const formattedDate2 = format(new Date(this.toDate), 'dd/MM/yyyy');
            this.td = formattedDate2;
            
            const filterParams = `start=${formattedDate}&end=${formattedDate2}`;

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

        // Delete Method *********************************************************
        deleteRecord(id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/expenses/delete/${id}`)
                    .then(res => {
                        this.dataFetch();
                        toast.error(res.data.message, {
                            autoClose: 3000,
                        });
                    }).catch((error) => {
                        console.error('Error Deleting data:', error);
                    })
            }
        },

        updateItemsPerPage() {
            this.dataFetch(this.currentPage);
        },
    },
    mounted() {
        this.dataFetch(this.currentPage);
    }
}
</script>

<style scoped>
tr td i {
    margin: 0 10px;
    font-size: 20px;
}

@media (max-width: 691px) {
    .supplierinfo {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    h3 {
        font-size: 15px;
        font-weight: bold;
    }

    h5 {
        font-size: 13px;
    }
}
</style>
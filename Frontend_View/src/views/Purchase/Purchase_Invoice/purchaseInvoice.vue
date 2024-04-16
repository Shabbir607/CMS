<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Purchase Bill</h3>
            </div>
            <div class="buttn">
                <router-link to="/purchaseinvoice/create" type="button" class="btn1"><i class="fa-solid fa-plus"></i>Add
                    New</router-link>
            </div>
        </div>
    </div>

    <div class="card my-4">
        <div class="row">
            <div class="col-md-3">
                <label for="fdate" class="form-label">From Date</label>
                <input type="date" v-model="fromDate" class="form-control" id="fdate">
            </div>
            <div class="col-md-3">
                <label for="tdate" class="form-label">To Date</label>
                <input type="date" v-model="toDate" class="form-control" id="tdate">
            </div>
            <div class="col-md-3">
                <label for="location" class="form-label">Location</label>
                <select id="location" class="form-select" v-model="selectedlocation">
                    <option :value="0" selected>All</option>
                    <option v-for="item in locationDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="suppl" class="form-label">Supplier</label>
                <select id="suppl" class="form-select" v-model="selectedSupplier">
                    <option :value="0" selected>All</option>
                    <option v-for="item in supplierDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="col-md-1 filter-search" @click="applyFilter">
                <img class="search-icon" src="../../../assets/search_icons/3.png" alt="">
            </div>
        </div>
        <hr class="mt-5">
        <!-- <div class="searching">
            <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" class="search-bar"
                placeholder="search">
        </div> -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="table-success">
                    <th scope="col">Location</th>
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Bill No</th>
                    <th scope="col">Refrence</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="this.loading">
                <tr>
                    <td colspan="8">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <strong class="mx-3">Loading...</strong>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr v-for="item in purchaseOrderData.data" :key="item.id">
                    <td>{{ item.location.name }}</td>
                    <td>{{ item.supplier.name }}</td>
                    <td>{{ item.bill_no }}</td>
                    <td>{{ item.reference_no }}</td>
                    <td>{{ formatTableDate(item.invoice_date) }}</td>
                    <td>{{ item.total_value }}</td>
                    <td v-if="item.status === 0">
                        <span style="background-color: rgb(227, 115, 3); padding: 3px 20px; border-radius: 4px;">Unpaid</span>
                    </td>
                    <td v-else-if="item.status === 1">
                        <span
                            style="background-color: rgb(233, 214, 2); padding: 3px 20px; border-radius: 4px;">Partial</span>
                    </td>
                    <td v-else>
                        <span
                            style="background-color: rgb(3, 227, 3); padding: 3px 20px; border-radius: 4px;">paid</span>
                    </td>
                    <td>
                        <i class="fa-solid fa-ellipsis-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu">
                            <li>
                                <router-link :to="{ path: '/purchaseinvoiceView/'+item.id }">
                                    <i class="fa-regular fa-eye"><small class="mx-3">View</small></i>
                                </router-link>
                            </li>
                            <!-- <li>
                                    <i class="fa-solid fa-check-double" @click="markAsSent(item.id, item.status)">
                                        <small style="color: rgb(1, 127, 1);" class="mx-3" v-if="item.status === 0">Mark as Sent</small>
                                        <small style="color: rgb(172, 158, 3);" class="mx-3" v-else>Mark as Unsent</small>
                                    </i>
                            </li> -->
                            <li v-if="item.status == 0"><i @click="deleteRecord(item.id)" class="fa-solid fa-trash"><small
                                        class="mx-3">Delete</small></i></li>
                        </ul>
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
    name: 'PurchaseInvoice',
    
    data() {
        return {
            purchaseOrderData: '',
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],

            fromDate: this.calculateFourMonthsAgo(),
            toDate: this.getCurrentDate(),
            fd: '',
            td: '',
            supplierDropdown: [],
            selectedSupplier: 0,
            locationDropdown: [],
            selectedlocation: 0,

            loading: false,
        }
    },


    methods: {
        async dataFetch(page, filterParams = '') {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/purchase_invoice/index?${filterParams}&page=${page}&per_page=${this.itemsPerPage}`);
                this.purchaseOrderData = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;
                console.log(response)

                this.loading = ! true;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        applyFilter() {
            const location = this.selectedlocation;
            const supplier = this.selectedSupplier;
            const formattedDate = format(new Date(this.fromDate), 'dd/MM/yyyy');
            this.fd = formattedDate;
            const formattedDate2 = format(new Date(this.toDate), 'dd/MM/yyyy');
            this.td = formattedDate2;
            

            const filterParams = `location=${location}&supplier=${supplier}&start=${formattedDate}&end=${formattedDate2}`;

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

        async chooseSupplier() {
            try {
            const response = await axios.get('api/supplier_dropdown');
            this.supplierDropdown = response.data.data;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async chooseLoaction() {
            try{
            const response = await axios.get('api/location_dropdown');
            this.locationDropdown = response.data.data;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },


        updateItemsPerPage() {
            this.dataFetch(this.currentPage);
        },


        deleteRecord(Id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/purchase_invoice/delete/${Id}`)
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
        this.chooseSupplier();
        this.chooseLoaction();
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
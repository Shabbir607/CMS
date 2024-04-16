<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Supplier</h3>
                <h5>Manage Supplier</h5>
            </div>
            <div class="buttn">
                <!-- <a type="button" class="btn1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <i class="fa-solid fa-file-import"></i>Import Data
                </a> -->
                <router-link to="/createsupplier" type="button" class="btn1">
                    <i class="fa-solid fa-plus"></i>Add New Supplier
                </router-link>
            </div>
        </div>
    </div>
    <!-- Off Canvas -->
    <!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <label for="formFileSm" class="form-label">Choose File</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file">
            </div>
            <div class="col-sm-12 col-md-12 d-flex">
                <button type="button" class="btn btn2">
                    Save
                </button>
                <button type="button" class="btn btn2 mx-3">
                    Download Format
                </button>
            </div>
            <div class="row mt-3 m-blank" style="border: .3px solid gray; width: 95%; height: 300px; margin: auto; border-radius: 8px;">
            </div>
        </div>
    </div> -->
    <div class="card mt-3">
        <!-- <div class="searching">
            <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" class="search-bar" placeholder="search">
        </div> -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="table-success">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
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
                <tr v-for="item in suppliers.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone_no }}</td>
                    <td>{{ item.mobile_no }}</td>
                    <td>{{ item.balance }}</td>
                    <td v-if="item.active === 1">
                        <span style="background-color: rgb(0, 233, 0);padding: 1px 10px; font-size: 12px; border-radius: 2px;">Active</span>
                    </td>
                    <td v-else>
                        <span style="background-color: rgb(198, 220, 0);padding: 1px 10px; font-size: 12px; border-radius: 2px;">UnActive</span>
                    </td>
                    <td>
                        <router-link :to="{path: '/supplier/edit/'+item.id}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </router-link>
                        <i class="fa-solid fa-trash" @click="deleteRecord(item.id)"></i>
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


export default {
    name: 'SupplierPage',
    data(){
        return{
            suppliers: [],
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],

            loading: false,
        }
    },
    methods:{
        async dataFetch(page) {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/supplier?page=${page}&per_page=${this.itemsPerPage}`);
                console.log(response)
                this.suppliers = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;

                this.loading = ! true;
            } catch (error) {
                console.log('Error Occur:', error)
            }
        },

        // Delete Method *********************************************************
        deleteRecord(id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/supplier_delete/${id}`)
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
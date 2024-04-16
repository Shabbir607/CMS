<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Item Master</h3>
                <h5>Manage Item</h5>
            </div>
            <div class="buttn">
                <!-- <a type="button" class="btn1"><i class="fa-solid fa-file-arrow-up"></i>Export Item List</a> -->
                <!-- <a type="button" class="btn1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight"><i class="fa-solid fa-file-import"></i>Import Items</a> -->
                <router-link to="/productadd" type="button" class="btn1"><i class="fa-solid fa-plus"></i>Add New
                    Item</router-link>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="searching">
            <i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" class="search-bar"
                placeholder="search">
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="table-success">
                    <!-- <th scope="col">Category</th> -->
                    <!-- <th scope="col">Type</th> -->
                    <th scope="col">Image</th>
                    <th scope="col">Item Name</th>
                    <!-- <th scope="col">Unit Name</th> -->
                    <!-- <th scope="col">SKU</th> -->
                    <th scope="col">QTY</th>
                    <th scope="col">Purchase Rate</th>
                    <th scope="col">Sales Rate</th>
                    <!-- <th scope="col">Active Status</th> -->
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-if="this.loading">
                <tr>
                    <td colspan="10">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <strong class="mx-3">Loading...</strong>
                        </div>
                    </td>
                </tr>;
            </tbody>
            <tbody>
                <tr v-for="item in productData.data" :key="item.id">
                    <!-- <td>{{ item.category?.category_name || '' }}</td> -->
                    <!-- <td>{{item.type.item_type}}</td> -->
                    <td><img :src="item.image" alt=""></td>
                    <td>{{item.name}}</td>
                    <!-- <td>{{item.packing_unit.unit}}</td> -->
                    <!-- <td>{{item.sku}}</td> -->
                    <td>{{item.quantity}}</td>
                    <td>{{item.purchase_price}}</td>
                    <td>{{item.selling_price}}</td>
                    <!-- <td><span class="py-1 px-3 rounded" style="background-color: rgb(37, 187, 14); color: white; font-size: 12px;">Active</span></td> -->
                    <td>
                        <router-link :to="{path: '/product/edit/'+item.id}"><i class="fa-solid fa-pen-to-square"></i></router-link>
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
            <div class="row mt-3 m-blank"
                style="border: .3px solid gray; width: 95%; height: 300px; margin: auto; border-radius: 8px;">
            </div>
        </div>
    </div> -->
    <!-- <img :src="this.image" alt=""> -->

</template>

<script>
import axios from 'axios';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';

export default {
    name: 'ProductPage',
    data(){
        return{
            productData: [],
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],
            loading: false,

            image:'',
        }
    },
    methods: {
        async dataFetch(page) {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/item/product?page=${page}&per_page=${this.itemsPerPage}`);
                this.image = response.data.data.data[0].image;
                this.productData = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;
                console.log(response)

                this.loading = ! true;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        // Delete Method *********************************************************
        deleteRecord(id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.get(`api/item/product_delete/${id}`)
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
th {
    border-left: none;
    border-right: none;
}
th, td {
    vertical-align: middle;
}
tr td i {
    margin: 0 10px;
    font-size: 20px;
}
tbody tr td img {
    width: 50px;
    height: 50px;
    border-radius: 3px;
}

</style>
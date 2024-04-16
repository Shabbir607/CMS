<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Location</h3>
                <h5>Manage Location</h5>
            </div>
            <div class="buttn" @:click="addRecordBtn">
                <a type="button" class="btn1">
                    <i class="fa-solid fa-plus"></i>
                    <span class="fw-bold">Add New</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <table class="table table-striped table-hover">
            <thead>
                <th>Name</th>
                <th>Contact No</th>
                <th>Country</th>
                <th>City</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
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
                <tr v-for="item in locationData.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.contact_no }}</td>
                    <td>{{ item.country }}</td>
                    <td>{{ item.city }}</td>
                    <td>{{ item.email }}</td>
                    <td><span class="rounded py-1 px-2"
                            style="background-color: rgb(0, 174, 0); color: white; font-size: 12px;">Active</span></td>
                    <td>
                        <i class="fa-solid fa-pen-to-square" @click="openEditModal(item)"></i>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">+ Location Add</h1>
                    <button type="button" @click="recordCloseBtn" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" @submit.prevent="addRecord">
                        <div class="col-md-12">
                            <label for="InputName" class="form-label">Name</label>
                            <input type="text" v-model="addNew.name" class="form-control" id="InputName">
                        </div>
                        <div style="color: red;">{{ errorMessage.name }}</div>
                        <div class="col-md-6">
                            <label for="InputCountry" class="form-label">Country</label>
                            <input type="text" v-model="addNew.country" class="form-control" id="InputCountry">
                        </div>
                        <div class="col-md-6">
                            <label for="InputCity" class="form-label">City</label>
                            <input type="text" v-model="addNew.city" class="form-control" id="InputCity">
                        </div>
                        <div class="col-md-12">
                            <label for="InputContact" class="form-label">Contact No</label>
                            <input type="text" v-model="addNew.contact_no" class="form-control" id="InputContact">
                        </div>
                        <div style="color: red;">{{ errorMessage.contact_no }}</div>

                        <div class="col-md-12">
                            <label for="InputEmail" class="form-label">Email</label>
                            <input type="email" v-model="addNew.email" class="form-control" id="InputEmail">
                        </div>
                        <div style="color: red;">{{ errorMessage.email }}</div>

                        <!-- <div class="form-check my-2 mx-3">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
                            <label class="form-check-label" for="exampleCheck1">Active</label>
                        </div> -->

                        <div class="col-md-12 my-3">
                            <button type="submit" class="btn btn2">Submit</button>
                            <input type="reset" @click="recordCloseBtn" class="btn btn-primary mx-3" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="updateModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" @submit.prevent="updateRecord">
                        <div class="col-md-12">
                            <label  class="form-label">Name</label>
                            <input type="text" v-model="selectedItem.name" class="form-control" >
                        </div>
                        
                        <div class="col-md-6">
                            <label  class="form-label">Country</label>
                            <input type="text" v-model="selectedItem.country" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label  class="form-label">City</label>
                            <input type="text" v-model="selectedItem.city" class="form-control" >
                        </div>
                        <div class="col-md-12">
                            <label  class="form-label">Contact No</label>
                            <input type="text" v-model="selectedItem.contact_no" class="form-control" >
                        </div>
             

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" v-model="selectedItem.email" class="form-control" >
                        </div>
         


                        <div class="col-md-12 my-3">
                            <button type="submit" class="btn btn2">Update</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import $ from 'jquery';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';

export default {
    name: 'LocationComp',
    data() {
        return {
            addNew: {
                name: '',
                contact_no: '',
                country: '',
                city: '',
                email: '',
            },
            errorMessage: {
                name: '',
                contact_no: '',
                email: '',
            },
            locationData: [],
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],
            selectedItem: {
                name: '',
                country: '',
                city: '',
                contact_no: '',
                email: '',
            },
            loading: false,
        }
    },
    methods: {
        addRecordBtn() {
            $('#exampleModal').modal('show');
        },
        recordCloseBtn() {
            $("#exampleModal").modal('hide');
            this.addNew = {
                name: '',
                contact_no: '',
                country: '',
                city: '',
                email: '',
            };
            this.errorMessage.name = '';
            this.errorMessage.contact_no = '';
            this.errorMessage.email = '';
        },

        // Add Record **********************************************************************
        async addRecord() {
            try {
                const response = await axios.post('api/location_add', {
                    name: this.addNew.name,
                    contact_no: this.addNew.contact_no,
                    country: this.addNew.country,
                    city: this.addNew.city,
                    email: this.addNew.email,
                })

                if (response.data.status === 201) {
                    this.dataFetch();
                    this.recordCloseBtn();
                    toast.success('Location Added Successfully 🎉', {
                        autoClose: 3000,
                    });
                }
                else if (response.data.status === 422) {
                    this.errorMessage.name = response.data.message.name ? `*${response.data.message.name[0]}*` : '';
                    this.errorMessage.contact_no = response.data.message.contact_no ? `*${response.data.message.contact_no[0]}*` : '';
                    this.errorMessage.email = response.data.message.email ? `*${response.data.message.email[0]}*` : '';
                } 
                else if (response.data.message ===" this name already use" ) {
                    this.errorMessage.name = 'This name already exist.'
                    this.errorMessage.email = '';
                }
                else if (response.data.message ===" this email already use" ) {
                    this.errorMessage.email = 'This email already exist.'
                    this.errorMessage.name = '';
                }
                
                 else {
                    console.warn('Unexpected response status:', response.data.status);
                }

            } catch (error) {
                console.log('Error Occur:', error)
            }
        },

        // Data Fetch Method****************************************************************
        async dataFetch(page) {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/location?page=${page}&per_page=${this.itemsPerPage}`);
                this.locationData = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;

                this.loading = ! true;
            } catch (error) {
                console.log('Error Occur:', error)
            }
        },

        openEditModal(item) {
            this.selectedItem = { ...item }; // Copy the item to avoid modifying the original data
            $('#updateModel').modal('show');
        },

        async updateRecord() {
            try {
                const response = await axios.post(`api/location_update/${this.selectedItem.id}`, {
                    name: this.selectedItem.name,
                    contact_no: this.selectedItem.contact_no,
                    country: this.selectedItem.country,
                    city: this.selectedItem.city,
                    email: this.selectedItem.email,
                });

                if (response.data.status === 200) {
                    this.dataFetch();
                    $('#updateModel').modal('hide');
                    toast.success('Location Updated Successfully 🎉', {
                        autoClose: 3000,
                    });
                } else {
                    console.warn('Unexpected response status:', response.data.status);
                }
            } catch (error) {
                console.log('Error Occur:', error);
            }
        },


        // Delete Category Logic ****************************************************
        deleteRecord(Id) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/location_delete/${Id}`)
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


.error {
    color: red;
}
th {
    border-left: none;
    border-right: none;
}
tr td i {
    margin: 0 10px;
    font-size: 20px;
}
</style>
   

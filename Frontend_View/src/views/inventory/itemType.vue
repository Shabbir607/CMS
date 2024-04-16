<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Item Type</h3>

            </div>
            <div class="buttn">
                <a type="button" class="btn1" @click="addRecordBtn">
                    <i class="fa-solid fa-plus"></i>
                    <span class="fw-bold">Add New</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Add New Category Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addNewCategory" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel"> ItemType / Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="col-md-12">
                <label class="form-label">Item Type</label>
                <input type="text" v-model="itemType" @keyup.enter="addRecord" class="form-control" name="category_name">
                <div class="error">{{ addError }}</div>
            </div>
            <button type="submit" @click="addRecord" class="btn btn2 mt-3">Save</button>
            <button @click="recordCloseBtn" class="btn btn-primary mt-3 mx-3">Cancel</button>
        </div>
    </div>

    <div class="card mt-3">
        <table>
            <thead>
                <tr>
                    <th scope="col">Type Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-8">
                        <i class="fa-brands fa-searchengin"></i>
                        <input class="search-bar" type="search" name="tablesearch" placeholder="Search..." />
                    </td>
                    <td class="col-2"></td>
                    <td class="col-2"></td>
                </tr>
                <tr>
                    <td colspan="3" v-if="this.loading">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <strong class="mx-3">Loading...</strong>
                        </div>
                    </td>
                </tr>

                <tr v-for="item in itemTypefetch.data" :key="item.id">
                    <td class="col-8">
                        <span v-if="!item.editing">{{ item.item_type }}</span>
                        <input v-else type="text" class="editable" v-model="item.editedItemName"
                            @keyup.enter="updateRecord(item)" />

                    </td>
                    <td class="col-2">True</td>
                    <td class="col-2">
                        <i v-if="!item.editing" class="fa-solid fa-pen-to-square" @click="startEditing(item)"></i>
                        <button v-else class="btn btn2 btn-sm" @click="updateRecord(item)">Update</button>
                        <button v-if="item.editing" class="btn btn-danger btn-sm mx-2 fw-bold"
                            @click="cancelEditing(item)">Cancel</button>
                        <i v-if="!item.editing" class="fa-solid fa-trash" @click="deleteRecord(item.id)"></i>
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
import $ from 'jquery';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';

export default {
    name: 'CategoryPage',
    data() {
        return {
            addError: '',
            itemType: '',
            itemTypefetch: [],
            currentPage: 1,
            totalPages: 1,
            itemsPerPage: 10,
            itemsPerPageOptions: [10, 30, 50, 100],
            editedCategory: {
                id: null,
                category_name: '',
            },

            loading: false,
        }
    },
    methods: {

        addRecordBtn() {
            $('#addNewCategory').offcanvas('show');
        },
        recordCloseBtn() {
            $("#addNewCategory").offcanvas('hide');
            this.itemType = '';
            this.addError = '';
        },

        // Add Record Logic********************************************************
        async addRecord() {
            try {
                const response = await axios.post('api/item/type_add', {
                    item_type: this.itemType
                });

                if (response.data.status === 201) {
                    this.dataFetch();
                    this.recordCloseBtn();
                    toast.success('ItemType Added Successfully 🎉', {
                        autoClose: 3000,
                    });
                }
                else if (response.data.status === 422) {
                    this.addError = ('*' + response.data.message.item_type + '*');
                } else if (response.data.status === 409) {
                    this.addError = ('*' + response.data.message + '*');
                } else {
                    console.warn('Unexpected response status:', response.data.status);
                }

            } catch (error) {
                console.error("Error inserting data:", error);

                // Handle specific types of errors here
                // if (error.response) {
                //     console.error('Response Error:', error.response.data);
                // } else if (error.request) {
                //     console.error('Request Error:', error.request);
                // } else {
                //     console.error('Unexpected Error:', error.message);
                // }
            }
        },

        // Data Fetching Method
        async dataFetch(page) {
            this.loading = ! false;
            try {
                const response = await axios.get(`api/item/type?page=${page}&per_page=${this.itemsPerPage}`);
                this.itemTypefetch = response.data.data;
                this.currentPage = response.data.data.current_page;
                this.totalPages = response.data.data.last_page;

                this.loading = ! true;
            } catch (error) {
                console.error('Error occurred while fetching data:', error);
            }
        },


        // Edit Category Logic ****************************************************
        startEditing(item) {
            item.editing = true;
            item.editedItemName = item.item_type;
        },

        cancelEditing(item) {
            item.editing = false;
            item.editedCategoryName = '';
        },

        // Update Record ************************************************************
        updateRecord(item) {
            axios
                .post(`api/item/type_update/${item.id}`, {
                    item_type: item.editedItemName,
                })
                .then((response) => {
                    if (response.data.status === 200) {
                        toast.success('ItemType Updated!', {
                            autoClose: 3000,
                        });
                        
                        item.editing = false;
                        item.item_type = item.editedItemName;
                    } else {
                        console.warn('Unexpected response status:', response.data.status);
                    }
                })
                .catch((error) => {
                    console.error('Error updating data:', error);
                });
        },

        // Delete Category Logic*******************************************************
        deleteRecord(itemId) {
            if (confirm('Are You Sure You Want to Delete This Data')) {

                axios.delete(`api/item/type_delete/${itemId}`)
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

};
</script>

<style scoped>
.error {
    color: red;
}

td .search-bar {
    width: 90%;
    outline: none;
    border: none;
    padding: 5px;
    margin-left: 10px;
    border: .1px solid #9D568A;
}

.fa-searchengin {
    font-size: 25px;
    color: #9D568A;
}

tr td i {
    margin: 0 10px;
    font-size: 20px;
}
</style>
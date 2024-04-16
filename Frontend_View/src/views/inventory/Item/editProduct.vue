<template>
    <div class="back">
        <router-link to="/product" class="back-icon"> <i class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
        <h2>Update Item</h2>
        <!-- <h5>Create New Item</h5> -->
    </div>
    <div class="card mt-3">
        <div class="prod-buttons">
            <button type="button" style="cursor:auto;" class="btn btn2">Product</button>
        </div>

        <form @submit.prevent="updateRecord" class="row g-3 mt-3">
            <div class="col-md-6">
                <label class="form-label">Item Name </label>
                <input type="text" v-model="formData.name" class="form-control" name="itemname">
                <div style="color: red;">{{ errorMessage.name }}</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">SKU</label>
                <input type="text" v-model="formData.sku" class="form-control" name="sku">
                <div style="color: red;">{{ errorMessage.sku }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Barcode </label>
                <input type="text" v-model="formData.barcode" class="form-control" name="barcode">
                <div style="color: red;">{{ errorMessage.barcode }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Category</label>
                <div class="d-flex">
                    <select v-model="formData.category" class="form-select" name="category">
                        <!-- <option selected>Select Category</option> -->
                        <option v-for="item in categoryDropdown" :value="item.id" :key="item.id">{{ item.category_name }}
                        </option>
                    </select>
                    <!-- <i class="fa-solid fa-plus ml-2" data-bs-toggle="offcanvas" data-bs-target="#selectCategory"
                        aria-controls="offcanvasRight"></i> -->
                </div>
                <div style="color: red;">{{ errorMessage.category }}</div>
            </div>

            <div class="col-md-4">
                <label for="inputState" class="form-label">Item Type</label>
                <div class="d-flex">
                    <select v-model="formData.type" name="itemtype" class="form-select">
                        <!-- <option selected>Select Item Type</option> -->
                        <option v-for="item in itemTypeDropdown" :value="item.id" :key="item.id">{{ item.item_type }}
                        </option>
                    </select>
                    <!-- <i class="fa-solid fa-plus ml-2" data-bs-toggle="offcanvas" data-bs-target="#itemType"
                        aria-controls="offcanvasRight"></i> -->
                </div>
                <div style="color: red;">{{ errorMessage.type }}</div>
            </div>

            <div class="col-md-4">
                <label for="inputState" class="form-label">Brand</label>
                <div class="d-flex">
                    <select v-model="formData.brand" name="brand" class="form-select">
                        <!-- <option selected>Select Brand</option> -->
                        <option v-for="item in brandDropdown" :value="item.id" :key="item.id">{{ item.brand_name }}</option>
                    </select>
                    <!-- <i class="fa-solid fa-plus ml-2" data-bs-toggle="offcanvas" data-bs-target="#brandAdd"
                        aria-controls="offcanvasRight"></i> -->
                </div>
                <div style="color: red;">{{ errorMessage.brand }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Quantity Alert </label>
                <input type="number" v-model="formData.quantity" class="form-control" name="quantityalert">
                <div style="color: red;">{{ errorMessage.quantity }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Paking Unit</label>
                <div class="d-flex">
                    <select v-model="formData.packing_unit" name="pakingunit" class="form-select">
                        <!-- <option selected>Select Paking Unit</option> -->
                        <option v-for="item in unitDropdown" :value="item.id" :key="item.id">{{ item.unit }}</option>
                    </select>
                    <!-- <i class="fa-solid fa-plus ml-2" data-bs-toggle="offcanvas" data-bs-target="#pakingUnit"
                        aria-controls="offcanvasRight"></i> -->
                </div>
                <div style="color: red;">{{ errorMessage.packing_unit }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Inventory Unit ?</label>
                <div class="d-flex">
                    <select v-model="formData.inventory_unit" name="inventoryunit" class="form-select">
                        <!-- <option selected>Select Unit</option> -->
                        <option v-for="item in unitDropdown" :value="item.id" :key="item.id">{{ item.unit }}</option>
                    </select>
                    <!-- <i class="fa-solid fa-plus ml-2" data-bs-toggle="offcanvas" data-bs-target="#inventoryUnit"
                        aria-controls="offcanvasRight"></i> -->
                </div>
                <div style="color: red;">{{ errorMessage.inventory_unit }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Unit Conversion ? </label>
                <input type="number" v-model="formData.unit_conversion" class="form-control" name="unitconversion">
                <div style="color: red;">{{ errorMessage.unit_conversion }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Opening Stock</label>
                <input type="number" v-model="formData.opening_stock" class="form-control" name="openingstock">
                <div style="color: red;">{{ errorMessage.opening_stock }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Opening Date</label>
                <input type="date" v-model="formData.opening_date" class="form-control" name="openingdate">
                <div style="color: red;">{{ errorMessage.opening_date }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Location</label>
                <select v-model="formData.location" name="location" class="form-select">
                    <!-- <option selected>Choose...</option> -->
                    <option v-for="item in locationDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.location }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Color</label>
                <input type="text" v-model="formData.color" class="form-control" name="color">
                <div style="color: red;">{{ errorMessage.color }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Size</label>
                <input type="text" v-model="formData.size" class="form-control" name="size">
                <div style="color: red;">{{ errorMessage.size }}</div>
            </div>

            <div class="col-md-8">
                <label class="form-label">Preferred Supplier</label>
                <select v-model="formData.supplier" placeholder="Choose Supplier" name="preferedsupplier"
                    class="form-select">
                    <option v-for="item in supplierDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.supplier }}</div>
            </div>

            <div style="color: #603D56; font-weight: bold; font-size: 20px; border-bottom: .1px solid gray;">Price & Tax
            </div>

            <div class="col-md-4">
                <label class="form-label">Selling Price</label>
                <input type="text" v-model="formData.selling_price" class="form-control" name="sellingprice">
                <div style="color: red;">{{ errorMessage.selling_price }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Purchase Price</label>
                <input type="text" v-model="formData.purchase_price" class="form-control" name="Purchaseprice">
                <div style="color: red;">{{ errorMessage.purchase_price }}</div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Tax</label>
                <input type="number" value="0" v-model="formData.tax" class="form-control" name="tax">
                <div style="color: red;">{{ errorMessage.tax }}</div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea v-model="formData.description" class="form-control" name="description" rows="4"></textarea>
                <div style="color: red;">{{ errorMessage.description }}</div>
            </div>

            <div style="color: #603D56; font-weight: bold; font-size: 20px; border-bottom: .1px solid gray;">Item Image
            </div>

            <!-- <div class="mb-3">
                <div class="my-2 productImage"><img :src="imageUrl" alt=""></div>
                <input class="form-control" type="file" name="selectimage" @change="handleFileChange">
                <div style="color: red;">{{ errorMessage.image }}</div>
            </div> -->


            <div class="mb-3">
                <div class="my-2 productImage">
                    <img :src="formData.image" alt="">
                </div>
                <label for="">Attach File</label>
                <input class="form-control mt-2" type="file" name="selectimage" @change="handleFileChange">
                <div style="color: red;">{{ errorMessage.image }}</div>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn2">Update</button>
                <router-link to="/product">
                    <input type="reset" value="Go Back" class="btn btn-primary mx-3">
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
// import 'vue3-toastify/dist/index.css';
// import { toast } from 'vue3-toastify';

export default {
    name: 'editStudent',
    data() {
        return {
            categoryDropdown: [],
            itemTypeDropdown: [],
            brandDropdown: [],
            unitDropdown: [],
            locationDropdown: [],
            supplierDropdown: [],

            errorMessage: {
                name: '',
                sku: '',
                barcode: '',
                category: '',
                type: '',
                brand: '',
                quantity: '',
                packing_unit: '',
                inventory_unit: '',
                unit_conversion: '',
                opening_stock: '',
                opening_date: '',
                location: '',
                color: '',
                size: '',
                supplier: '',
                selling_price: '',
                purchase_price: '',
                tax: '',
                description: '',
                image: null,
            },
            // imageUrl:'',
            formData: {
                name: '',
                sku: '',
                barcode: '',
                category: '',
                type: '',
                brand: '',
                quantity: '',
                packing_unit: '',
                inventory_unit: '',
                unit_conversion: '',
                opening_stock: '',
                opening_date: '',
                location: '',
                color: '',
                size: '',
                supplier: '',
                selling_price: '',
                purchase_price: '',
                tax: '',
                description: '',
                image: null,
            },

        }
    },
    methods: {
        async categoryAdd() {
            try {
                const response = await axios.get('api/item/category_dropdown');
                this.categoryDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async itemTypeAdd() {
            try {
                const response = await axios.get('api/item/type_dropdown');
                this.itemTypeDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async brandAdd() {
            try {
                const response = await axios.get('api/item/brand_dropdown');
                this.brandDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async UnitAdd() {
            try {
                const response = await axios.get('api/item/unit_dropdown');
                this.unitDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async locationAdd() {
            try {
                const response = await axios.get('api/location_dropdown');
                this.locationDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async supplierAdd() {
            try {
                const response = await axios.get('api/supplier_dropdown');
                this.supplierDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                // this.imageUrl = URL.createObjectURL(file);
                this.formData.image = file;
            }
        },

        async getRecord(itemId) {
            const response = await axios.get(`api/item/product_edit/${itemId}`)
            try {
                this.formData = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        formatDateForApi(date) {
            const apiDate = new Date(date);
            const year = apiDate.getFullYear();
            const month = (apiDate.getMonth() + 1).toString().padStart(2, '0');
            const day = apiDate.getDate().toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        },

        async updateRecord() {
            try {
                const formData = new FormData();

                // Append form data to FormData object
                Object.keys(this.formData).forEach(key => {
                    let value = this.formData[key];

                    // Handle special cases, e.g., formatting date
                    if (key === 'opening_date') {
                        value = this.formatDateForApi(value);
                    }

                    // Ensure that values are empty strings if they are null
                    if (value === null) {
                        value = '';
                    }

                    formData.append(key, value);
                });
                const response = await axios.post(`api/item/product_update/${this.$route.params.id}`, formData);

                console.log("helo gg", this.formData)
                if (response.data.status == 200) {
                    this.errorMessage = '',
                        this.$router.push('/product');
                }
                else if (response.data.status == 422) {
                    this.errorMessage.name = response.data.message.name ? `*${response.data.message.name[0]}*` : '';
                    this.errorMessage.sku = response.data.message.sku ? `*${response.data.message.sku[0]}*` : '';
                    this.errorMessage.barcode = response.data.message.barcode ? `*${response.data.message.barcode[0]}*` : '';
                    this.errorMessage.category = response.data.message.category ? `*${response.data.message.category[0]}*` : '';
                    this.errorMessage.type = response.data.message.type ? `*${response.data.message.type[0]}*` : '';
                    this.errorMessage.brand = response.data.message.brand ? `*${response.data.message.brand[0]}*` : '';
                    this.errorMessage.quantity = response.data.message.quantity ? `*${response.data.message.quantity[0]}*` : '';
                    this.errorMessage.packing_unit = response.data.message.packing_unit ? `*${response.data.message.packing_unit[0]}*` : '';
                    this.errorMessage.inventory_unit = response.data.message.inventory_unit ? `*${response.data.message.inventory_unit[0]}*` : '';
                    this.errorMessage.unit_conversion = response.data.message.unit_conversion ? `*${response.data.message.unit_conversion[0]}*` : '';
                    this.errorMessage.opening_stock = response.data.message.opening_stock ? `*${response.data.message.opening_stock[0]}*` : '';
                    this.errorMessage.opening_date = response.data.message.opening_date ? `*${response.data.message.opening_date[0]}*` : '';
                    this.errorMessage.location = response.data.message.location ? `*${response.data.message.location[0]}*` : '';
                    this.errorMessage.color = response.data.message.color ? `*${response.data.message.color[0]}*` : '';
                    this.errorMessage.size = response.data.message.size ? `*${response.data.message.size[0]}*` : '';
                    this.errorMessage.supplier = response.data.message.supplier ? `*${response.data.message.supplier[0]}*` : '';
                    this.errorMessage.selling_price = response.data.message.selling_price ? `*${response.data.message.selling_price[0]}*` : '';
                    this.errorMessage.purchase_price = response.data.message.purchase_price ? `*${response.data.message.purchase_price[0]}*` : '';
                    this.errorMessage.tax = response.data.message.tax ? `*${response.data.message.tax[0]}*` : '';
                    this.errorMessage.description = response.data.message.description ? `*${response.data.message.description[0]}*` : '';
                    this.errorMessage.image = response.data.message.image ? `*${response.data.message.image[0]}*` : '';


                }
                else {
                    console.log('Error occur server not responding');
                }

            } catch (error) {
                console.error('Error Occur:', error);
            }
        },


    },
    mounted() {

        this.getRecord(this.$route.params.id);
        this.categoryAdd();
        this.itemTypeAdd();
        this.brandAdd();
        this.UnitAdd();
        this.locationAdd();
        this.supplierAdd();
    }
}

</script>

<style scoped>
h5 {
    color: #9D568A;
    margin-top: -5px;
    font-size: 15px;
}

.productImage img {
    width: 70px;
    border-radius: 5px;
}
</style>
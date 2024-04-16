<template>
    <div class="back">
        <router-link to="/purchaseorder" class="back-icon"> <i
                class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
        <h2>Purchase Order Create</h2>
    </div>
    <!-- Form Start -->
    <div class="card">
        <form class="row" @submit.prevent="sendRecord">
            <div class="col-md-4">
                <label class="form-label">Location</label>
                <select class="form-select" v-model="selectedLocation" @change="onLocationChange">
                    <option v-for="item in location" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.location }}</div>
            </div>
            <div class="col-md-7">
                <label class="form-label">Supplier</label>
                <select class="form-select" v-model="supplier">
                    <option v-for="item in supplierDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.supplier }}</div>
            </div>
            <!-- <div class="col-md-1 btt"> -->
            <!-- <button class="col-md-1 canvas-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight"><i class="fa-solid fa-plus"></i></button> -->
            <!-- </div> -->

            <!-- Off Canvas -->
            <!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Create New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="card">
                        <form class="row">
                            <div class="col-md-6">
                                <label for="text3" class="form-label">Name*</label>
                                <input type="text" class="form-control" id="text3">
                            </div>
                            <div class="col-md-6">
                                <label for="text4" class="form-label">Display Name*</label>
                                <input type="text" class="form-control" id="text4">
                            </div>
                            <div class="col-md-8">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-4">
                                <label for="input4" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="input4">
                            </div>
                            <div class="col-4">
                                <label for="inputAddress" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="inputAddress">
                            </div>
                            <div class="col-4">
                                <label for="inputAddress2" class="form-label">Country</label>
                                <input type="text" class="form-control" id="inputAddress2">
                            </div>
                            <div class="col-md-4">
                                <label for="inputCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="exampleFormControlTextarea2" class="form-label">Shipping Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea2" rows="5"></textarea>
                            </div>
                            <div class="mt-5 ml-4 col-md-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Active
                                </label>
                            </div>
                            <div class="mt-5 ml-4 col-md-2">
                                <input class="form-check-input border border-warning" type="checkbox" value=""
                                    v-model="isTaxRegistered" id="flexCheckChecked2">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    Tax Registered?
                                </label>
                            </div>
                            <div class="col-md-7 mt-4" v-if="isTaxRegistered">
                                <label for="tex" class="form-label">Tax No</label>
                                <input type="text" class="form-control" id="tex">
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="inputState" class="form-label">Currency</label>
                                <select id="inputState" class="form-select">
                                    <option selected>PKR</option>
                                    <option>USD</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="date" class="form-label">Date of Balance</label>
                                <input type="date" id="date" class="form-control" name="date">
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="inputZip" class="form-label">Opening Balance</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>

                            <hr class="mt-4">

                            <div class="additional-info d-flex">
                                <h4 class="mt-3 active">Additional Info</h4>
                            </div>
                            <div class="bg-body-tertiary p-3 rounded-2">
                                <div id="additional-info">
                                    <div class="col-md-6">
                                        <label for="payment" class="form-label">Payement Terms</label>
                                        <select id="payment" class="form-select">
                                            <option selected>Due on Receipt</option>
                                            <option>Net 15</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="num" class="form-label">Credit Limit</label>
                                        <input type="number" id="num" class="form-control" name="number">
                                    </div>
                                </div>
                            </div>


                            <div class="additional-info d-flex">
                                <h4 class="mt-3 ml-4">Contact Person Info</h4>
                            </div>
                            <div class="bg-body-tertiary p-3 rounded-2">
                                <div id="additional-info">
                                    <div class="col-md-6">
                                        <label for="cpname" class="form-label">Contact Person Name</label>
                                        <input type="text" id="cpname" class="form-control" name="cpname">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cpn" class="form-label">Contact Person Number</label>
                                        <input type="text" id="cpn" class="form-control" name="cpnumber">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cpe" class="form-label">Contact Person Email</label>
                                        <input type="text" id="cpe" class="form-control" name="cpemail">
                                    </div>
                                </div>
                            </div>

                            <div class="additional-info d-flex">
                                <h4 class="mt-3 ml-4">Other Info</h4>
                            </div>
                            <div class="bg-body-tertiary p-3 rounded-2">
                                <div class="col-md-12">
                                    <label for="exampleFormControlTextarea4" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea4" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn2">Submit</button>
                                <input type="reset" value="Cancel" data-bs-dismiss="offcanvas" class="btn mx-3 btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->

            <!-- Form Continues -->
            <div class="col-md-4">
                <label for="text5" class="form-label">Order Date</label>
                <input type="date" v-model="orderDate" class="form-control" id="text5">
                <div style="color: red;">{{ errorMessage.order_date }}</div>
            </div>
            <div class="col-md-4">
                <label for="inputEmail6" class="form-label">Expected Date</label>
                <input type="date" v-model="expectedDate" class="form-control" id="inputEmail6">
                <div style="color: red;">{{ errorMessage.expected_date }}</div>
            </div>
            <div class="col-md-4">
                <label for="input5" class="form-label">Refrence Number</label>
                <input type="text" v-model="refNo" class="form-control" id="input5">
                <div style="color: red;">{{ errorMessage.reference_no }}</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Product</label>
                <select class="form-select" v-model="selectedProduct" @change="onProductChange">
                    <option v-for="item in productData" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
            </div>

            <!-- Tables Content Start Here -->
            <div class="row mt-3">
                <div>
                    <div style="color: red; font-size: 14px; float: right;">{{ qtymsg }}</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="3">Product / service</th>
                                <th colspan="2">Unit</th>
                                <th colspan="1">Qty</th>
                                <th colspan="2">Rate</th>
                                <th colspan="2">Amount</th>
                                <th colspan="1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in selectedProducts" :key="index">
                                <td colspan="3">{{ product.name }}</td>
                                <td colspan="1">{{ product.unit }}</td>
                                <td colspan="2">
                                    <input type="number" min="0" v-model="product.qty" @input="updateAmount(index)"
                                        @change="onQtyChange(product)">
                                </td>
                                
                                <td colspan="2">
                                    <input type="number" min="0" v-model="product.rate" @input="updateAmount(index)"
                                        @change="onQtyChange(product)">
                                </td>
                                <td colspan="2">{{ product.amount }}</td>
                                <td colspan="1"><i @click="deleteProduct(index)" class="fa-solid fa-trash"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- form contnue -->

            <!-- <hr class="mt-3"> -->
            <div class="col-md-6 mt-4"></div>
            <div class="col-md-6 mt-4 taxes">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Total</label>
                    <div class="col-sm-6">
                        <input type="text" v-model="totalAmount" class="form-control" placeholder="0" readonly>
                        <div style="color: red;">{{ errorMessage.total_value }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <label class="form-label">Description</label>
                <textarea v-model="description" class="form-control" id="exampleTextarea" rows="3"></textarea>
                <div style="color: red;">{{ errorMessage.description }}</div>
            </div>
            <div class="col-md-6 mt-4">
                <label class="form-label">Terms and Conditions</label>
                <textarea v-model="termsCond" class="form-control" id="exampleTextarea" rows="3"></textarea>
            </div>


            <div class="col-12 mt-4">
                <button type="submit" class="btn btn2">Submit</button>
                <router-link to="/purchaseorder" class="cancel"><input type="reset" value="Cancel"
                        class="btn mx-3 btn-primary"></router-link>
            </div>
        </form>
    </div>
</template>


<script>
import axios from 'axios';




export default {
    name: 'PurchaseOrderadd',
    data() {
        return {
            location: [],
            supplierDropdown: [],
            productData: [],
            selectedProducts: [],
            selectedLocation: null,
            selectedProduct: null,

            changedItems: [],
            supplier: '',
            orderDate: '',
            expectedDate: '',
            refNo: '',
            description: '',
            termsCond: '',

            errorMessage: {
                order_date: '',
                expected_date: '',
                description: '',
                supplier: '',
                location: '',
                reference_no: '',
                total_value: '',
            },

            qtymsg:'',

        }
    },
    methods: {
        async locationAdd() {
            try{
            const response = await axios.get('api/location_dropdown');
            this.location = response.data.data;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async chooseSupplier() {
            try{
            const response = await axios.get('api/supplier_dropdown');
            this.supplierDropdown = response.data.data;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async locationProduct(locationId) {
            const response = await axios.get(`api/item/location_product/${locationId}`);
            this.productData = response.data.data;
        },
        onLocationChange() {
            if (this.selectedLocation) {
                this.locationProduct(this.selectedLocation);
            }
            this.selectedProducts = [];
            this.selectedProducts = [];
            this.changedItems = [];
            this.qtymsg='';
            this.selectedProduct = null;
        },
        onProductChange() {
            if (this.selectedProduct) {
                this.getTableRecord(this.selectedProduct);
            }
            this.qtymsg='';
        },

        async getTableRecord(productId) {
            try {
                // Check if the product with the same ID already exists
                const existingProductIndex = this.selectedProducts.findIndex(product => product.id === productId);

                if (existingProductIndex === -1) {
                    // If not exists, add a new entry
                    const response = await axios.get(`api/item/product_transfer/${productId}`);
                    const productDetails = response.data.data;
                    console.log(response)

                    this.selectedProducts.push({
                        id: productId, // Assuming you have an ID property in your product details
                        name: productDetails.name,
                        quantity: productDetails.quantity,
                        qty: 0,
                        unit: productDetails.packing_unit.unit,
                        rate: productDetails.purchase_price,
                        amount: 0,
                    });
                }
            } catch (error) {
                console.error('Error fetching product details:', error);
            }
        },

        updateAmount(index) {
            const product = this.selectedProducts[index];
            const maxQuantity = product.quantity;

            // Ensure the entered quantity is not greater than the available quantity
            if (product.qty > maxQuantity) {
                product.qty = maxQuantity;
                this.qtymsg = 'Cannot Enter Quantity greater than Actual Quantity'
            }
            else {
                this.qtymsg = ''
            }

            // Calculate the amount based on the updated quantity and cost
            product.amount = product.qty * product.rate;
            this.updateChangedItems(product);
        },


        deleteProduct(index) {
        const deletedProduct = this.selectedProducts[index];

        // Remove the corresponding item from the changedItems array if it exists
        const changedItemIndex = this.changedItems.findIndex(item => item.id === deletedProduct.id);
        if (changedItemIndex !== -1) {
            this.changedItems.splice(changedItemIndex, 1);
        }

        // Remove the product from the selectedProducts array
        this.selectedProducts.splice(index, 1);
    },


        updateChangedItems(product) {
            const existingItem = this.changedItems.find((changedItem) => changedItem.id === product.id);

            if (existingItem) {
                // Update existing item in the array
                existingItem.quantity = product.qty;
                existingItem.rate = product.rate;
                existingItem.amount = product.amount;
            } else {
                // Add new item to the array
                this.changedItems.push({
                    id: product.id,
                    quantity: product.qty,
                    rate: product.rate,
                    amount: product.amount,
                });
            }
        },
        onQtyChange(product) {
            this.updateChangedItems(product);
        },

        formatDate() {
            const apiDate = this.orderDate;
            if (apiDate) {
                const [year, month, day] = apiDate.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.orderDate = formattedDate;
            }
            const apiDate2 = this.expectedDate;
            if (apiDate2) {
                const [year, month, day] = apiDate2.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.expectedDate = formattedDate;
            }
        },

        async sendRecord() {
            this.formatDate();
            try {
                const formData = new FormData();
                formData.append('location', this.selectedLocation);
                formData.append('supplier', this.supplier);
                formData.append('order_date', this.orderDate);
                formData.append('expected_date', this.expectedDate);
                formData.append('reference_no', this.refNo);  // Assuming this.imageUrl is a File object
                formData.append('description', this.description);
                formData.append('total_value', this.totalAmount);
                formData.append('terms_and_conditions', this.termsCond);
                formData.append('product', JSON.stringify(this.changedItems));


                const response = await axios.post('api/purchase_order/add', formData)
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/purchaseorder')
                }
                else if(response.data.status == 422){
                    this.errorMessage.description = response.data.message.description ? `${response.data.message.description[0]}` : '';
                    this.errorMessage.expected_date = response.data.message.expected_date ? `${response.data.message.expected_date[0]}` : '';
                    this.errorMessage.order_date = response.data.message.order_date ? `${response.data.message.order_date[0]}` : '';
                    this.errorMessage.reference_no = response.data.message.reference_no ? `${response.data.message.reference_no[0]}` : '';
                    this.errorMessage.location = response.data.message.location ? `${response.data.message.location[0]}` : '';
                    this.errorMessage.total_value = response.data.message.total_value ? `${response.data.message.total_value[0]}` : '';
                    this.errorMessage.supplier = response.data.message.supplier ? `${response.data.message.supplier[0]}` : '';
                    
                }else{
                    this.errorMessage = '';
                }
            } catch (error) {
                console.error(error)
            }
        },
    },

    computed: {
        totalAmount() {
            return this.selectedProducts.reduce((total, product) => total + product.amount, 0);
        },
    },


    mounted() {
        this.locationAdd();
        this.chooseSupplier();
    }
}
</script>

<style scoped> /* .offcanvas {
     width: 70%;
     overflow-x: hidden;
 }

.canvas-btn {
    margin-top: 30px;
    border-radius: 7px;
    padding: 7px 10px;
    width: auto;
    height: fit-content;
    outline: none;
    border: none;
    color: white;
    background-color: #9D568A;
    font-weight: bold;
} */
 thead td {
     background-color: #FAFBFE;
     font-size: 14px;
     font-weight: bold;

 }

 td,
 th {
     border-left: none;
     border-right: none;
 }

 hr {
     width: 97%;
 }

 tr td i {
    margin: 0 10px;
    font-size: 20px;
}

 .taxes {
     background-color: #FAFBFE;
     padding: 5px 15px;
     border-radius: 10px;
 }

 .taxes .row {
     display: flex;
     justify-content: space-between;
 }
</style>
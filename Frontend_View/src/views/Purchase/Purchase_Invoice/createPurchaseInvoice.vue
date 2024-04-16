<template>
    <div class="back">
        <router-link to="/purchaseinvoice" class="back-icon"> <i
                class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
        <h2>Purchase Add</h2>
    </div>
    <!-- Form Start -->
    <div class="card my-4">
        <form class="row" @submit.prevent="sendRecord">
            <div class="col-md-4">
                <label class="form-label">Location</label>
                <select class="form-select" v-model="selectedLocation" @change="onLocationChange">
                    <option v-for="item in location" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.location }}</div>
            </div>
            <div class="col-md-8">
                <label class="form-label">Supplier Name</label>
                <select class="form-select" v-model="supplier">
                    <option v-for="item in supplierDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.supplier }}</div>
            </div>

            <!-- Form Continues -->
            <div class="col-md-4">
                <label for="text5" class="form-label">Invoice Date</label>
                <input type="date" v-model="invoiceDate" class="form-control" id="text5">
                <div style="color: red;">{{ errorMessage.invoice_date }}</div>
            </div>
            <div class="col-md-4">
                <label for="inputEmail6" class="form-label">Due Date</label>
                <input type="date" v-model="dueDate" class="form-control" id="inputEmail6">
                <div style="color: red;">{{ errorMessage.due_date }}</div>
            </div>
            <div class="col-md-4">
                <label for="input5" class="form-label">Invoice No:</label>
                <input type="text" v-model="invoiceNo" class="form-control" id="input5">
                <div style="color: red;">{{ errorMessage.invoice_no }}</div>
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
            <div class="col-md-6 mt-4">
                <label class="form-label">Description</label>
                <textarea v-model="description" class="form-control" id="exampleTextarea" rows="3"></textarea>
                <div style="color: red;">{{ errorMessage.description }}</div>
            </div>
            <div class="col-md-6 mt-4 taxes">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Total</label>
                    <div class="col-sm-6">
                        <input type="text" v-model="totalAmount" class="form-control" placeholder="0" readonly>
                    </div>
                </div>
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
            invoiceDate: '',
            dueDate: '',
            invoiceNo: '',
            refNo: '',
            description: '',
            termsCond: '',

            errorMessage: {
                invoice_date: '',
                due_date: '',
                description: '',
                supplier: '',
                location: '',
                reference_no: '',
                invoice_no: '',
            },

            qtymsg:'',

        }
    },
    methods: {
        async locationAdd() {
            try {
            const response = await axios.get('api/location_dropdown');
            this.location = response.data.data;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async chooseSupplier() {
            try{
            const response = await axios.get('api/supplier_dropdown');
            this.supplierDropdown = response.data.data;
            }catch (error) {
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
            const apiDate = this.invoiceDate;
            if (apiDate) {
                const [year, month, day] = apiDate.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.invoiceDate = formattedDate;
            }
            const apiDate2 = this.dueDate;
            if (apiDate2) {
                const [year, month, day] = apiDate2.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.dueDate = formattedDate;
            }
        },

        async sendRecord() {
            this.formatDate();
            try {
                const formData = new FormData();
                formData.append('location', this.selectedLocation);
                formData.append('supplier', this.supplier);
                formData.append('invoice_date', this.invoiceDate);
                formData.append('due_date', this.dueDate);
                formData.append('invoice_no', this.invoiceNo);
                formData.append('reference_no', this.refNo);  
                formData.append('description', this.description);
                formData.append('total_value', this.totalAmount);
                formData.append('product', JSON.stringify(this.changedItems));


                const response = await axios.post('api/purchase_invoice/add', formData)
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/purchaseinvoice')
                }
                else if(response.data.status == 422){
                    this.errorMessage.description = response.data.message.description ? `${response.data.message.description[0]}` : '';
                    this.errorMessage.invoice_date = response.data.message.invoice_date ? `${response.data.message.invoice_date[0]}` : '';
                    this.errorMessage.due_date = response.data.message.due_date ? `${response.data.message.due_date[0]}` : '';
                    this.errorMessage.reference_no = response.data.message.reference_no ? `${response.data.message.reference_no[0]}` : '';
                    this.errorMessage.location = response.data.message.location ? `${response.data.message.location[0]}` : '';
                    this.errorMessage.invoice_no = response.data.message.invoice_no ? `${response.data.message.invoice_no[0]}` : '';
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

<style scoped>
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
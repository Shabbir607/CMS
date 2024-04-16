<template>
    <div class="back">
        <router-link to="/stocktransfer" class="back-icon"> <i
                class="fa-solid fa-arrow-left-long"></i><Span>Back</Span></router-link>
        <h2>New Stock Transfer</h2>
    </div>
    <div class="card my-3">
        <div class="row">
            <div class="col-md-6">
                <label for="slocation" class="form-label">Source Location</label>
                <select id="slocation" class="form-select" v-model="selectedLocation" @change="onLocationChange">
                    <option v-for="item in sourceLocation" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.source }}</div>
            </div>
            <div class="col-md-6">
                <label for="slocation" class="form-label">Destination Location</label>
                <select id="slocation" class="form-select" v-model="destination">
                    <option v-for="item in destiLocation" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.destination }}</div>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Date</label>
                <input type="date" v-model="date" class="form-control" id="tdate">
                <div style="color: red;">{{ errorMessage.date }}</div>
            </div>
            <div class="col-md-6">
                <label for="project" class="form-label">Product</label>
                <select id="project" class="form-select" v-model="selectedProduct" @change="onProductChange">

                    <option v-for="item in productData" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
            </div>



            <div class="mt-5">
                <div style="color: red; font-size: 14px; float: right;">{{ qtymsg }}</div>
                <table class="table ">
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>SKU</td>
                            <td>Unit</td>
                            <td>QTY</td>
                            <td>Cost</td>
                            <td>Amount</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in selectedProducts" :key="index">
                            <td class="col-4">{{ product.name }}</td>
                            <td class="col-2">{{ product.sku }}</td>
                            <td class="col-2">{{ product.unit }}</td>
                            <td class="col-1"><input type="number" min="0" v-model="product.qty"
                                    @input="updateAmount(index)" @change="onQtyChange(product)"></td>
                            <td class="col-1"><input type="number" min="0" v-model="product.cost"
                                    @input="updateAmount(index)" @change="onQtyChange(product)"></td>
                            <td class="col-2">{{ product.amount }}</td>
                            <td class="col-2"><i class="fa-solid fa-trash" @click="deleteProduct(index)"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="row rounded-2">
                <div class="col-md-6">
                    <label for="exampleFormControlTextarea5" class="form-label">Narration</label>
                    <textarea class="form-control" v-model="narration" id="exampleFormControlTextarea5" rows="3"></textarea>
                    <div style="color: red;">{{ errorMessage.narration }}</div>
                </div>
                <div class="col-md-6 total">
                    <div class="row mt-3 ">
                        <label class="col-sm-3 col-form-label">Total</label>
                        <div class="col-sm-6">
                            <input type="text" v-model="totalAmount" class="form-control" placeholder="0" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-3 attach-file">
                <div class="my-2 productImage"><img :src="image" alt=""></div>
                <label for="">Attach File</label>
                <input type="file" @change="handleFileChange" class="form-control" id="inputGroupFile02">
                <div style="color: red;">{{ errorMessage.file }}</div>
            </div>
            <div>
                <button type="submit" @click="sendRecord" class="btn btn2">Submit</button>
                <input type="reset" class="btn btn-primary mx-3" value="cancel">
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';



export default {
    name: 'createStocktransfer',
    data() {
        return {
            sourceLocation: [],
            destiLocation: [],
            productData: [],
            selectedLocation: null,
            selectedProduct: null,
            selectedProducts: [],
            image: '',

            changedItems: [],
            destination: null,
            date: '',
            narration: '',
            imageUrl: '',

            qtymsg: '',
            errorMessage: {
                date: '',
                destination: '',
                file: '',
                narration: '',
                source: '',
            },
        }
    },

    methods: {
        async sourceLocationAdd() {
            try {
                const response = await axios.get('api/location_dropdown');
                this.sourceLocation = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async destiLocationAdd() {
            try {
                const response = await axios.get('api/location_dropdown');
                this.destiLocation = response.data.data;
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
            this.changedItems = [];
            this.qtymsg = '';
            this.selectedProduct = null;
        },

        onProductChange() {
            if (this.selectedProduct) {
                this.getTableRecord(this.selectedProduct);
            }
            this.qtymsg = '';
        },

        async getTableRecord(productId) {
            try {
                // Check if the product with the same ID already exists
                const existingProductIndex = this.selectedProducts.findIndex(product => product.id === productId);

                if (existingProductIndex === -1) {
                    // If not exists, add a new entry
                    const response = await axios.get(`api/item/product_transfer/${productId}`);
                    const productDetails = response.data.data;

                    this.selectedProducts.push({
                        id: productId, // Assuming you have an ID property in your product details
                        name: productDetails.name,
                        sku: productDetails.sku,
                        unit: productDetails.packing_unit.unit,
                        quantity: productDetails.quantity,
                        qty: 0,
                        cost: productDetails.selling_price,
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
            product.amount = product.qty * product.cost;
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
                existingItem.rate = product.cost;
                existingItem.amount = product.amount;
            } else {
                // Add new item to the array
                this.changedItems.push({
                    id: product.id,
                    quantity: product.qty,
                    rate: product.cost,
                    amount: product.amount,
                });
            }
        },

        onQtyChange(product) {
            this.updateChangedItems(product);
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.image = URL.createObjectURL(file);
                this.imageUrl = file;
            }
        },

        formatDate() {
            const apiDate = this.date;
            if (apiDate) {
                const [year, month, day] = apiDate.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.date = formattedDate;
            }
        },

        async sendRecord() {
            this.formatDate();
            try {
                const formData = new FormData();
                formData.append('source', this.selectedLocation);
                formData.append('destination', this.destination);
                formData.append('date', this.date);
                formData.append('narration', this.narration);
                formData.append('file', this.imageUrl);  // Assuming this.imageUrl is a File object
                formData.append('total', this.totalAmount);
                formData.append('product', JSON.stringify(this.changedItems));


                const response = await axios.post('api/stock_transfer/add', formData)
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/stocktransfer')
                }
                else if (response.data.status == 422) {
                    this.errorMessage.destination = response.data.message.destination ? `${response.data.message.destination[0]}` : '';
                    this.errorMessage.source = response.data.message.source ? `${response.data.message.source[0]}` : '';
                    this.errorMessage.date = response.data.message.date ? `${response.data.message.date[0]}` : '';
                    this.errorMessage.file = response.data.message.file ? `${response.data.message.file[0]}` : '';
                    this.errorMessage.narration = response.data.message.narration ? `${response.data.message.narration[0]}` : '';
                } else {
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
        this.sourceLocationAdd();
        this.destiLocationAdd();


    }
}
</script>

<style scoped>
tr td i {
    margin: 0 10px;
    font-size: 20px;
}

thead td {
    background-color: #FAFBFE;
    font-size: 14px;
    font-weight: bold;

}

td {

    border-left: none;
    border-right: none;
}

.dropdown-center {
    width: 100%;
    background-color: none;
}

.total .row {
    display: flex;
    justify-content: space-between;
    background-color: #FAFBFE;
}

.attach-file {
    background-color: #FAFBFE;
    padding: 20px 0;
}

.productImage img {
    width: 70px;
    border-radius: 5px;
}
</style>
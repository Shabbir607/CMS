<template>
    <div class="back">
        <router-link to="/StockAdjustment" class="back-icon">
            <i class="fa-solid fa-arrow-left-long"></i>
            <Span>Back</Span>
        </router-link>
        <h2>Create New Adjustment</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" v-model="type" class="form-select">
                        <option>Adjustment</option>
                        <option>Opening Stock</option>
                    </select>
                    <div style="color: red;">{{ errorMessage.type }}</div>
                </div>

                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <select id="location" class="form-select" placeholder="hello" v-model="selectedLocation"
                        @change="onLocationChange">
                        <option v-for="item in locationDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                    </select>
                    <div style="color: red;">{{ errorMessage.location }}</div>
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label">To Date</label>
                    <input type="date" v-model="date" class="form-control" id="date">
                    <div style="color: red;">{{ errorMessage.date }}</div>
                </div>
            </div>

            <table v-if="showTable" class="table table-bordered table-striped table-hover my-3">
                <thead>
                    <tr class="table-success">
                        <th>ProductName</th>
                        <th>BARCODE</th>
                        <th>SKU</th>
                        <th>RATE</th>
                        <th>PHYSICAL QTY</th>
                        <th>ADJUST QTY</th>
                        <th>VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in tableData" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>{{ item.barcode }}</td>
                        <td>{{ item.sku }}</td>
                        <td>{{ item.purchase_price }}</td>
                        <td><input type="number" min="0" step="0.000" v-model="item.quantity"
                                @change="onPhysicalQtyChange(item)">
                        </td>
                        <td>{{ adjustQty(item) }}</td>
                        <td><span>{{ (item.purchase_price * adjustQty(item)).toFixed(3) }}</span></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <!-- <strong>Grand Total: {{ calculateGrandTotal.toFixed(3) }}</strong> -->
                <strong> Grand Total: {{ calculateGrandTotal.toFixed(3) }}</strong>
            </div>
            <div class="col-md-6 bg-body-tertiary mt-4 p-2 rounded-2">
                <div class="col-md-12">
                    <label for="Textarea4" class="form-label">Remarks</label>
                    <textarea class="form-control" v-model="remarks" id="Textarea4" rows="5"></textarea>
                    <div style="color: red;">{{ errorMessage.remarks }}</div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" @click="sendRecord" class="btn btn2">Submit</button>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';


export default {
    name: 'createStockAdjustment',
    data() {
        return {
            locationDropdown: [],
            tableData: [],
            selectedLocation: null,
            showTable: false,
            changedItems: [],
            date: '',
            remarks: '',
            type: '',

            errorMessage: {
                type: '',
                location: '',
                remarks: '',
                date: '',
            },
        }
    },

    computed: {
        calculateGrandTotal() {
            // Use reduce to sum up the values in the "VALUE" column
            return this.tableData.reduce((total, item) => {
                return total + item.purchase_price * this.adjustQty(item);
            }, 0);
        }
    },

    methods: {
        async locationAdd() {
            try {
                const response = await axios.get('api/location_dropdown');
                this.locationDropdown = response.data.data;
            } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async getTableRecord(locationId) {
            try {
                const response = await axios.get(`api/item/location_product/${locationId}`)
                this.tableData = response.data.data.map(item => ({
                    ...item,
                    originalQuantity: item.quantity, // Initialize originalQuantity with the value from API
                }));
            } catch (error) {
                console.error(error)
            }
        },
        adjustQty(item) {
            // Calculate the difference between the original physical quantity and the adjusted quantity
            return (item.quantity - (item.originalQuantity || 0)).toFixed(3);
        },
        onLocationChange() {
            // Fetch table data when the location is changed
            if (this.selectedLocation) {
                this.showTable = true;
                this.getTableRecord(this.selectedLocation);
            }
            this.changedItems = [];
        },

        updateChangedItems(item) {
            const existingItem = this.changedItems.find((changedItem) => changedItem.id === item.id);

            if (existingItem) {
                // Update existing item in the array
                existingItem.phy_qty = item.quantity;
                existingItem.adj_qty = this.adjustQty(item);
                existingItem.value = (item.purchase_price * this.adjustQty(item)).toFixed(3);
            } else {
                // Add new item to the array
                this.changedItems.push({
                    id: item.id,
                    phy_qty: item.quantity,
                    adj_qty: this.adjustQty(item),
                    value: (item.purchase_price * this.adjustQty(item)).toFixed(3),
                });
            }
        },

        onPhysicalQtyChange(item) {
            this.updateChangedItems(item);
            console.log(this.changedItems)
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
                const response = await axios.post('api/stock_adjustment/add', {
                    type: this.type,
                    date: this.date,
                    location: this.selectedLocation,
                    remarks: this.remarks,
                    total_value: this.calculateGrandTotal.toFixed(3),
                    product: JSON.stringify(this.changedItems)
                })
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/StockAdjustment')
                    console.log(this.changedItems)
                } else if (response.data.status == 422) {
                    this.errorMessage.type = response.data.message.type ? `${response.data.message.type[0]}` : '';
                    this.errorMessage.date = response.data.message.date ? `${response.data.message.date[0]}` : '';
                    this.errorMessage.location = response.data.message.location ? `${response.data.message.location[0]}` : '';
                    this.errorMessage.remarks = response.data.message.remarks ? `${response.data.message.remarks[0]}` : '';
                } else {
                    this.errorMessage = '';
                }
            } catch (error) {
                console.error(error)
            }
        }


    },
    mounted() {
        this.locationAdd();

    }
}
</script>


<style>
td input {
    height: 100%;
    padding: 7px;
    width: 100px;
    border: none;
    outline: none;
    border: 1px solid #9D568A;
}

.adjustQty {
    border: none;
    box-shadow: none;
    background-color: transparent;
}

strong {
    float: right;
}
</style>
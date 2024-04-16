
import loginVue from '@/views/login.vue';

<template>
    <div class="back">
        <router-link to="/paymentcustomer" class="back-icon"> <i
                class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
        <h2>New Customer Receipt</h2>
    </div>
    <!-- Form Start -->
    <div class="card my-4">
        <form class="row" @submit.prevent="sendRecord">

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Choose Customer</label>
                    <select class="form-select" v-model="selectedCustomer" @change="onSupplierChange">
                        <option v-for="item in customerDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                    </select>
                    <div style="color: red;">{{ errorMessage.customer }}</div>
                </div>
            </div>

            <!-- Form Continues -->
            <!-- <div class="col-md-3">
                <label for="inputEmail6" class="form-label">Amount:</label>
                <input type="number" v-model="amount" class="form-control" id="inputEmail6">
                <div style="color: red;">{{ errorMessage.amount }}</div>
            </div> -->

            <div class="col-md-3">
                <label for="text5" class="form-label"> Date</label>
                <input type="date" v-model="date" class="form-control" id="text5">
                <div style="color: red;">{{ errorMessage.date }}</div>
            </div>

            <div class="col-md-3">
                <label for="custom-dropdown" class="form-label">Pay Mode</label>
                <select class="form-select" Id="custom-dropdown" v-model="pay_mode">
                    <option>Cash</option>
                    <option>Bank Transfer</option>
                    <option>Check</option>
                    <option>Credit Card</option>
                </select>
                <div style="color: red;">{{ errorMessage.pay_mode }}</div>
            </div>
            <div class="col-md-3">
                <label for="input5" class="form-label">Reference No</label>
                <input type="text" v-model="reference_no" class="form-control" id="input5">
                <div style="color: red;">{{ errorMessage.reference_no }}</div>
            </div>

            <div class="col-md-12 mt-4">
                <label class="form-label">Narration</label>
                <textarea class="form-control" v-model="narration" id="exampleTextarea" rows="3"></textarea>
                <div style="color: red;">{{ errorMessage.narration }}</div>
            </div>

            <div class="row mt-3">
                <div>
                    <table v-if="showTable" class="table mt-3">
                        <thead>
                            <tr>
                                <!-- <th colspan="1"></th> -->
                                <th colspan="3">Invoice No</th>
                                <th colspan="1">Ref No</th>
                                <th colspan="1">Location</th>
                                <th colspan="2">Date</th>
                                <th colspan="2">Amount</th>
                                <th colspan="1">Balance</th>
                                <th colspan="1">Paying</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in tableData" :key="item.id">
                                <!-- <td colspan="1"><input type="checkbox"
                                        style="box-shadow: none; height: 20px; width: 20px"></td> -->
                                <td colspan="3">{{ item.inv_no }}</td>
                                <td colspan="1">{{ item.reference_no }}</td>
                                <td colspan="1">{{ item.location.name }}</td>
                                <td colspan="2">{{ formatTableDate(item.invoice_date) }}</td>
                                <td colspan="2">{{ item.total_value }}</td>
                                <td colspan="1">{{ item.balance }}</td>
                                <td colspan="1"><input type="number"  placeholder="0" v-model="item.pay" @input="updateChangedItems(item)"
                                        :id="'payingInput_' + item.id" min="0"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12"></div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <div class="d-flex"
                        style="justify-content: space-between; align-items: center; background-color:#FAFBFE; padding: 10px;">
                        <label for="inputEmail6" class="form-label">Amount:</label>
                        <input type="number" v-model="amount" class="form-control" id="inputEmail6" style="width: 250px;"
                            readonly>
                    </div>
                    <div style="color: red;">{{ errorMessage.amount }}</div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-lg-6 col-sm-12 col-12"></div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <div class="rz-card" style="background-color:#FAFBFE; padding: 10px;">
                        <div class="my-2 productImage"><img :src="image" alt=""></div>
                        <label style="font-size: 15px; font-weight: 600; color: #212B36; margin: 0 0 10px;">Attach
                            File</label>
                        <input @change="handleFileChange" class="form-control form-control-sm" type="file">
                        <div style="color: red;">{{ errorMessage.file }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn2">Submit</button>
                <router-link to="/paymentcustomer" class="cancel"><input type="reset" value="Cancel"
                        class="btn mx-3 btn-primary"></router-link>
            </div>
        </form>
    </div>
</template>


<script>
import axios from 'axios';
import { format } from 'date-fns';




export default {
    name: 'AddSupplierPayment',
    data() {
        return {

            customerDropdown: [],
            selectedCustomer: null,
            showTable: false,
            tableData: {},

            changedItems: [],
            customer: '',
            date: '',
            amount: 0,
            pay_mode: '',
            reference_no: '',
            narration: '',
            imageUrl: '',

            image: '',

            errorMessage: {
                pay_mode: '',
                narration: '',
                customer: '',
                date: '',
                reference_no: '',
                file: '',
            },

        }
    },
    methods: {
        async chooseCustomer() {
            try{
            const response = await axios.get('api/customer_dropdown');
            this.customerDropdown = response.data.data;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        onSupplierChange() {
            if (this.selectedCustomer) {
                this.showTable = true;
                this.getTableRecord(this.selectedCustomer);
            }
            this.changedItems = [];
            this.amount = 0;
        },

        async getTableRecord(supplierId) {
            try {
                const response = await axios.get(`api/saleinvoice/cutsomer/${supplierId}`);
                this.tableData = response.data.data
                console.log(response);
            } catch (error) {
                console.error('Error fetching product details:', error);
            }
        },

        formatTableDate(date) {
            return format(new Date(date), 'dd-MMM-yyyy');
        },

        updateChangedItems(item) {
            // Ensure that paying does not exceed balance
            item.pay = Math.min(item.pay, item.balance);

            // Check if item.pay is greater than zero before adding to changedItems
            if (item.pay > 0) {
                // Update the changedItems array
                const existingItem = this.changedItems.find((changedItem) => changedItem.id === item.id);

                if (existingItem) {
                    // Update existing item if found
                    existingItem.pay = item.pay;
                } else {
                    // Add new item to the array
                    this.changedItems.push({ id: item.id, pay: item.pay });
                }
            } else {
                // Remove the item from changedItems if it becomes zero
                this.changedItems = this.changedItems.filter((changedItem) => changedItem.id !== item.id);
            }

            this.calculateTotal();
        },

        calculateTotal() {
      // Calculate the total based on item.pay values in the changedItems array
      this.amount = this.changedItems.reduce((sum, item) => sum + item.pay, 0);
    },


        //         updateAmount() {
        //   const checkedItems = this.tableData.filter((item) => item.isChecked);
        //   const totalCheckedBalance = checkedItems.reduce((total, item) => total + item.balance, 0);

        //   checkedItems.forEach((item) => {
        //     const proportionalAmount = totalCheckedBalance > 0 ? (item.balance / totalCheckedBalance) * this.amount : 0;
        //     item.amount = Math.min(proportionalAmount, item.balance);
        //   });

        //   // Set amount to zero for unchecked items
        //   this.tableData.forEach((item) => {
        //     if (!item.isChecked) {
        //       item.amount = 0;
        //     }
        //   });
        // },

        // updateAmount() {
        //       const checkedItems = this.tableData.filter((item) => item.isChecked);
        //       const amountPerItem = checkedItems.length > 0 ? this.amount / checkedItems.length : 0;


        //       this.tableData.forEach((item) => {
        //         item.amount = item.isChecked ? amountPerItem : 0;
        //       });
        //     },

        formatDate() {
            const apiDate = this.date;
            if (apiDate) {
                const [year, month, day] = apiDate.split('-');
                const formattedDate = `${day}/${month}/${year}`;
                this.date = formattedDate;
            }
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.image = URL.createObjectURL(file);
                this.imageUrl = file;
            }
        },

        async sendRecord() {
            this.formatDate();
            try {
                const formData = new FormData();
                formData.append('date', this.date);
                formData.append('customer', this.selectedCustomer);
                formData.append('pay_mode', this.pay_mode);
                formData.append('file', this.imageUrl);
                formData.append('amount', this.amount);
                formData.append('reference_no', this.reference_no);
                formData.append('narration', this.narration);
                formData.append('invoice', JSON.stringify(this.changedItems));


                const response = await axios.post('api/customer_receipt/add', formData)
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/paymentcustomer')
                }
                else if (response.data.status == 422) {
                    this.errorMessage.narration = response.data.message.narration ? `${response.data.message.narration[0]}` : '';
                    this.errorMessage.pay_mode = response.data.message.pay_mode ? `${response.data.message.pay_mode[0]}` : '';
                    this.errorMessage.date = response.data.message.date ? `${response.data.message.date[0]}` : '';
                    this.errorMessage.file = response.data.message.file ? `${response.data.message.file[0]}` : '';
                    this.errorMessage.customer = response.data.message.customer ? `${response.data.message.customer[0]}` : '';
                    // this.errorMessage.amount = response.data.message.amount ? `${response.data.message.amount[0]}` : '';

                } else {
                    this.errorMessage = '';
                }
            } catch (error) {
                console.error(error)
            }
        },
    },


    mounted() {
        this.chooseCustomer();
    }
}
</script>

<style scoped>
thead th {
    background-color: #FAFBFE;
    border-top: none;
    font-size: 14px;
    font-weight: bold;

}

td,
th {
    border-left: none;
    border-right: none;
}

.productImage img {
    width: 70px;
    border-radius: 5px;
}
</style>
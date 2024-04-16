<template>
    <div class="back">
        <router-link to="/expenses" class="back-icon"> <i class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
        <h2>New Expenses</h2>
    </div>

    <div class="card my-3">
        <form class="row" @submit.prevent="sendRecord">
            <div class="col-md-8">
                <label class="form-label">Supplier</label>
                <select class="form-select" v-model="selectedSupplier">
                    <option v-for="item in supplierDropdown" :value="item.id" :key="item.id">{{ item.name }}</option>
                </select>
                <div style="color: red;">{{ errorMessage.supplier }}</div>
            </div>
            <div class="col-md-2">
                <label for="input5" class="form-label">Pay Mode</label>
                <select class="form-select" v-model="pay_mode">
                    <option>Cash</option>
                    <option>Bank Transfer</option>
                    <option>Check</option>
                    <option>Credit Card</option>
                </select>
                <div style="color: red;">{{ errorMessage.pay_mode }}</div>
            </div>
            <div class="col-md-2">
                <label for="input5" class="form-label">Reference No</label>
                <input type="text" v-model="reference_no" class="form-control" id="input5">
                <div style="color: red;">{{ errorMessage.reference_no }}</div>
            </div>
            <div class="col-md-3">
                <label for="text5" class="form-label"> Date</label>
                <input type="date" v-model="date" class="form-control" id="text5">
                <div style="color: red;">{{ errorMessage.date }}</div>
            </div>
            <div class="col-md-12 mt-4">
                <label class="form-label">Narration</label>
                <textarea class="form-control" v-model="narration" id="exampleTextarea" rows="3"></textarea>
                <div style="color: red;">{{ errorMessage.narration }}</div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="check" class="form-label"> Location</label><br>
                    <input type="checkbox" v-model="locationShow" style="height: 20px; width: 20px;">
                </div>
                <div class="col-md-2">
                    <label for="input" class="form-label">Amount*</label>
                    <input type="number" v-model="amount" class="form-control" id="input" readonly>
                    <div style="color: red;">{{ errorMessage.total_amount }}</div>
                </div>

                <div class="row mt-3">
                    <div>
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Expense Accounts</th>
                                    <th style="width: 35%;">Description</th>
                                    <th style="width: 20%;" v-show="locationShow">Location</th>
                                    <th style="width: 10%%;">Amount</th>
                                    <th style="width: 10%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in expenseRows" :key="index">
                                    <td>
                                        <select class="form-select" v-model="row.selectedExpenses">
                                            <option v-for="item in expenses" :value="item.id" :key="item.id">{{ item.name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td><input type="text" v-model="row.description" style="width: 100%;"></td>
                                    <td v-show="locationShow">
                                        <select class="form-select" v-model="row.location">
                                            <option v-for="item in locationDropdown" :value="item.id" :key="item.id">{{
                                                item.name }}</option>
                                        </select>
                                    </td>
                                    <td><input type="number" min="0" v-model="row.amount" @input="calculateTotal"
                                            style="width: 100%;"></td>

                                    <td style="text-align: center;">
                                        <i class="fa-solid fa-circle-plus" @click="addRow(index)"></i><br>
                                        <i class="fa-solid fa-trash mt-2" @click="deleteRow(index)"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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
                    <router-link to="/expenses" class="cancel"><input type="reset" value="Cancel"
                            class="btn mx-3 btn-primary"></router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';



export default {
    name: 'CreateExpenses',
    data() {
        return {
            locationShow: false,
            supplierDropdown: [],
            locationDropdown: [],
            expenses: [],
            image: '',

            expenseRows: [
                {
                    selectedExpenses: '',
                    description: '',
                    location: '',
                    amount: 0
                }
            ],

            changedItems: [],
            selectedSupplier: null,
            date: '',
            amount: 0,
            pay_mode: '',
            reference_no: '',
            narration: '',
            imageUrl: '',

            errorMessage: {
                pay_mode: '',
                narration: '',
                supplier: '',
                date: '',
                total_amount: '',
                file: '',
            },
        }
    },
    methods: {

        addRow(index) {
            this.expenseRows.splice(index + 1, 0, {
                selectedExpenses: '',
                description: '',
                location: '',
                amount: 0
            });
            this.calculateTotal();
        },

        deleteRow(index) {
            if (this.expenseRows.length > 1) {
                this.expenseRows.splice(index, 1);
            }
            this.calculateTotal();
        },

        calculateTotal() {
            // Calculate the total based on item.paying values in the changedItems array
            this.amount = this.expenseRows.reduce((sum, item) => sum + item.amount, 0);

            // Update changedItems array with modified rows
            this.changedItems = this.expenseRows.map((row) => ({
                account_id: row.selectedExpenses,
                description: row.description,
                location: row.location,
                amount: row.amount
            }));
            console.log(this.changedItems)
        },

        async chooseSupplier() {
            try{
            const response = await axios.get('api/supplier_dropdown');
            this.supplierDropdown = response.data.data;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async chooseLocation() {
            try{
            const response = await axios.get('api/location_dropdown');
            this.locationDropdown = response.data.data;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },
        async expensesDropdown() {
            try{
            const response = await axios.get('api/expenses_account/dropdown');
            this.expenses = response.data.data;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
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
                formData.append('supplier', this.selectedSupplier);
                formData.append('pay_mode', this.pay_mode);
                formData.append('file', this.imageUrl);
                formData.append('total_amount', this.amount);
                formData.append('reference_no', this.reference_no);
                formData.append('narration', this.narration);
                formData.append('expenses', JSON.stringify(this.changedItems));


                const response = await axios.post('api/expenses/add', formData)
                console.log(response)
                if (response.data.status == 201) {
                    this.$router.push('/expenses')
                }
                else if (response.data.status == 422) {
                    this.errorMessage.narration = response.data.message.narration ? `${response.data.message.narration[0]}` : '';
                    this.errorMessage.pay_mode = response.data.message.pay_mode ? `${response.data.message.pay_mode[0]}` : '';
                    this.errorMessage.date = response.data.message.date ? `${response.data.message.date[0]}` : '';
                    this.errorMessage.file = response.data.message.file ? `${response.data.message.file[0]}` : '';
                    this.errorMessage.supplier = response.data.message.supplier ? `${response.data.message.supplier[0]}` : '';
                    this.errorMessage.total_amount = response.data.message.total_amount ? `${response.data.message.total_amount[0]}` : '';

                } else {
                    this.errorMessage = '';
                }
            } catch (error) {
                console.error(error)
            }
        },
    },

    mounted() {
        this.chooseSupplier();
        this.chooseLocation();
        this.expensesDropdown();
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
    align-items: center;
}

td i {
    font-size: 18px;
    cursor: pointer;
}

td input,
td select {
    box-shadow: none;
}

.productImage img {
    width: 70px;
    border-radius: 5px;
}
</style>
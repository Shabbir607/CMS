<template>
  <div class="back">
    <router-link to="/customer" class="back-icon"> <i class="fa-solid fa-arrow-left"></i><Span>Back</Span></router-link>
    <h2>Create New</h2>
  </div>

  <div class="card mt-3">
    <form class="row" @submit.prevent="addRecord">

      <div class="col-md-6">
        <label for="text3" class="form-label">Name*</label>
        <input type="text" class="form-control" v-model="formData.name" id="text3">
        <div style="color: red;">{{ errorMessage.name }}</div>
      </div>

      <div class="col-md-6">
        <label for="text4" class="form-label">Display Name*</label>
        <input type="text" class="form-control" v-model="formData.display_name" id="text4">
        <div style="color: red;">{{ errorMessage.display_name }}</div>
      </div>

      <div class="col-md-8">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" class="form-control" v-model="formData.email" id="inputEmail4">
        <div style="color: red;">{{ errorMessage.email }}</div>
      </div>

      <div class="col-md-4">
        <label for="input4" class="form-label">Mobile Number</label>
        <input type="number" class="form-control" v-model="formData.mobile_no" id="input4">
      </div>

      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Phone Number</label>
        <input type="number" class="form-control" v-model="formData.phone_no" id="inputAddress">
      </div>

      <div class="col-md-4">
        <label for="inputAddress2" class="form-label">Country</label>
        <input type="text" class="form-control" v-model="formData.country" id="inputAddress2">
      </div>

      <div class="col-md-4">
        <label for="inputCity" class="form-label">City</label>
        <input type="text" class="form-control" v-model="formData.city" id="inputCity">
      </div>

      <div class="col-md-6 mt-3">
        <label for="exampleFormControlTextarea1" class="form-label">Address</label>
        <textarea class="form-control" v-model="formData.address" id="exampleFormControlTextarea1" rows="5"></textarea>
      </div>

      <div class="col-md-6 mt-3">
        <label for="exampleFormControlTextarea2" class="form-label">Shipping Address</label>
        <textarea class="form-control" v-model="formData.shipping_address" id="exampleFormControlTextarea2" rows="5"></textarea>
      </div>

      <div class="mt-5 ml-4 col-md-2">
        <input class="form-check-input" type="checkbox" value="" @change="activeCheckbox" v-model="isActive" id="flexCheckChecked" checked>
        <label class="form-check-label mx-2" for="flexCheckChecked">
          Active
        </label>
      </div>

      <div class="mt-5 ml-4 col-md-2">
        <input class="form-check-input border border-warning" type="checkbox" @change="taxCheckbox" v-model="isTaxRegistered"
          id="flexCheckChecked2">
        <label class="form-check-label mx-2" for="flexCheckChecked2">
          Tax Registered?
        </label>
      </div>

      <div class="col-md-7 mt-4" v-if="isTaxRegistered">
        <label for="tex" class="form-label">Tax No</label>
        <input type="text" v-model="formData.tax_no" class="form-control" id="tex">
      </div>

      <div class="col-md-4 mt-4">
        <label for="inputState" class="form-label">Currency</label>
        <select id="inputState" v-model="formData.currency" class="form-select">
          <option selected>PKR</option>
          <option>USD</option>
        </select>
      </div>

      <div class="col-md-4 mt-4">
        <label for="date" class="form-label">Date of Balance</label>
        <input type="date" id="date" v-model="formData.date_of_balance" class="form-control">
      </div>

      <div class="col-md-4 mt-4">
        <label for="inputZip" class="form-label">Opening Balance</label>
        <input type="text" v-model="formData.balance" class="form-control" id="inputZip">
      </div>

      <hr class="mt-4">

      <div class="additional-info d-flex">
        <h4 class="mt-3 active">Additional Info</h4>
      </div>

      <div class="bg-body-tertiary p-3 rounded-2">
        <div id="additional-info">
          <div class="col-md-6">
            <label for="payment" class="form-label">Payement Terms</label>
            <select id="payment" v-model="formData.payment_terms" class="form-select">
              <option selected>Due on Receipt</option>
              <option>Net 15</option>
              <option>Net 30</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="num" class="form-label">Credit Limit</label>
            <input type="number" id="num" v-model="formData.credit_limit" class="form-control">
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
            <input type="text" id="cpname" v-model="formData.contact_person_name" class="form-control" >
          </div>
          <div class="col-md-6">
            <label for="cpn" class="form-label">Contact Person Number</label>
            <input type="text" id="cpn" v-model="formData.contact_person_phone" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="cpe" class="form-label">Contact Person Email</label>
            <input type="text" id="cpe" v-model="formData.contact_person_email" class="form-control">
          </div>
        </div>
      </div>

      <div class="additional-info d-flex">
        <h4 class="mt-3 ml-4">Other Info</h4>
      </div>
      <div class="bg-body-tertiary p-3 rounded-2">
        <div class="col-md-12">
          <label for="exampleFormControlTextarea4" class="form-label">Remarks</label>
          <textarea class="form-control" v-model="formData.remarks" id="exampleFormControlTextarea4" rows="5"></textarea>
        </div>
      </div>

      <div class="col-12 mt-4">
        <button type="submit" class="btn btn2">Submit</button>
        <router-link to="/customer" class="cancel mx-3">
          <input type="reset" value="Cancel" class="btn btn-primary">
        </router-link>
      </div>
    </form>
  </div>
</template> 

<script>
import axios from 'axios';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';

export default {
  name: "createSupplier",
  data() {
    return {
      isTaxRegistered: false,
      isActive: true,

      errorMessage: {
                name: '',
                display_name: '',
                email: '',
            },

      formData: {
                name: '',
                display_name: '',
                email: '',
                mobile_no: '',
                phone_no: '',
                country: '',
                city: '',
                address: '',
                shipping_address: '',
                active: '1',
                tax_registered:'0',
                tax_no: '',
                currency: '',
                date_of_balance: '',
                balance: 0,
                payment_terms:'',
                credit_limit: 0,
                contact_person_name: '',
                contact_person_phone: '',
                contact_person_email: '',
                remarks: '',
            },
    }
  },
  methods: {
    taxCheckbox(){
      this.formData.tax_registered = this.isTaxRegistered ? 1 : 0;
    },
    activeCheckbox(){
      this.formData.active = this.isActive ? 1 : 0;
    },
    async addRecord() {
            try {
                const formData = new FormData();

                // Append form data to FormData object
                Object.keys(this.formData).forEach(key => {
                    if (key === 'date_of_balance') {
                        formData.append(key, this.formatDateForApi(this.formData[key]));
                    } else {
                        formData.append(key, this.formData[key]);
                    }
                });

                const response = await axios.post('api/customer_add', formData);
                
                if (response.data.status === 201) {
                  this.errorMessage = '';
                    this.$router.push('/customer');
                    toast.success('Customer Added Successfully 🎉', {
                        autoClose: 3000,
                    });
                }
                 else if (response.data.status == 422) {
                    this.errorMessage.name = response.data.message.name ? `*${response.data.message.name[0]}*` : '';
                    this.errorMessage.display_name = response.data.message.display_name ? `*${response.data.message.display_name[0]}*` : '';
                    this.errorMessage.email = response.data.message.email ? `*${response.data.message.email[0]}*` : '';
                    
                }
                else if (response.data.status == 409){
                  this.errorMessage.email = response.data.message ? `*${response.data.message}*` : '';
                }
                 else {
                    console.log('Error occur server not responding');
                }

            } catch (error) {
                // Handle error
                console.log(error);
            }
        },
        formatDateForApi(date) {
            const apiDate = new Date(date);
            const year = apiDate.getFullYear();
            const month = (apiDate.getMonth() + 1).toString().padStart(2, '0');
            const day = apiDate.getDate().toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        },

  }
}
</script>
<style scoped>

</style>
<template>
  <div class="profile">
    <i class="fa-solid fa-user"></i><Span class="fw-bold">Profile</Span>
  </div>
  <div class="card my-4">
    <div class="row">
      <div class="col-md-4">
        <label for="text3" class="form-label">User Name</label>
        <input type="text" v-model="username" class="form-control" id="text3">
        <div style="color: red;">{{ errorMessage.name }}</div>
      </div>
      <div class="col-md-4">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" v-model="email" class="form-control" id="inputEmail4">
        <div style="color: red;">{{ errorMessage.email }}</div>
      </div>

      <div class="col-4">
        <label for="pnumber" class="form-label">Phone Number</label>
        <input type="text" v-model="phone" class="form-control" id="pnumber">
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-lg-6 col-sm-12 col-12">
        <div class="rz-card" style="background-color:#FAFBFE; padding: 10px;">
          <div class="my-2 productImage" v-if="this.image"><img :src="image" alt=""></div>
          <div class="my-2 productImage" v-else><img src="../../assets/user/profile_image.png" alt=""></div>
          <label style="font-size: 15px; font-weight: 600; color: #212B36; margin: 0 0 10px;">Upload New Image</label>
          <input @change="handleFileChange" class="form-control form-control-sm" type="file">
          <div style="color: red;">{{ errorMessage.image }}</div>
        </div>
      </div>
    </div>

    <div class="col-12 mt-4">
      <button type="submit" @click="UpdateProfile" class="btn btn2">Update</button>
      <input type="reset" value="Cancel" class="mx-4 btn btn-primary">
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
// import { useProfileStore } from '../../store/profile';

export default {
  name: 'UserProfile',
  // setup() {
  //   const profileStore = useProfileStore();

  //   const dataFetch = async () => {
  //     await profileStore.fetchData();
  //   };

  //   return {
  //     profileStore,
  //     dataFetch,
  //   };
  // },
  data() {
    return {
      username: '',
      email: '',
      phone: '',
      image: '',


      imageUrl: '',
      errorMessage: {
        name: '',
        email: '',
        image: '',
      },
    }
  },

  methods: {
    async dataFetch() {
      try{
      const response = await axios.get('api/admin_profile/get');
      this.username = response.data.profile.name
      this.email = response.data.profile.email
      this.image = response.data.profile.image
      this.phone = response.data.profile.phone
      }catch(error){
        console.error('Error Fetching Profilr Data', error)
      }
    },

    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.image = URL.createObjectURL(file);
        this.imageUrl = file;
      }
    },

    async UpdateProfile() {
      try {
        const formData = new FormData();
        formData.append('name', this.username);
        formData.append('phone', this.phone);
        formData.append('email', this.email);
        formData.append('image', this.imageUrl);
        const response = await axios.post('api/admin_profile/update', formData)
        if (response.data.status == 200) {
          toast.success('Profile Updated!', {
            autoClose: 2000,
          });
          this.logout();
          this.errorMessage = '';
        }
        else if (response.data.status == 422) {
          this.errorMessage.name = response.data.message.name ? `${response.data.message.name[0]}` : '';
          this.errorMessage.image = response.data.message.image ? `${response.data.message.image[0]}` : '';
          this.errorMessage.email = response.data.message.email ? `${response.data.message.email[0]}` : '';
        } else {
          this.errorMessage = '';
        }
      }
      catch (error) {
        alert('Error Occur on Updating Data.')
      }
    },
    logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/login');
        },
  },

  mounted() {
    this.dataFetch();
    
  }
}
</script>

<style scoped>
.profile span,
.profile i {
  color: #9D568A;
  padding-left: 12px;
  text-decoration: none;
  font-size: 18px;
}


.productImage img {
  width: 70px;
  border-radius: 5px;
}
</style>
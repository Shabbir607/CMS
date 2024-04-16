<template>
    <div class="card my-4">
        <div class="row">

            <div class="col-md-4">
                <label for="newpassword" class="form-label">Old Password</label>
                <div class="item col-md-4">
                    <i class="fa-solid fa-unlock"></i>
                    <input :type="showOldPassword ? 'text' : 'password'" name="password" v-model="oldpassword"
                        placeholder="Old Password" />
                    <img v-if="!showOldPassword" @click="toggleOldPassword" src="../../assets/img/login/eye-close.png"
                        alt="Hide Password" />
                    <img v-if="showOldPassword" @click="toggleOldPassword" src="../../assets/img/login/eye-open.png"
                        alt="Show Password" />
                </div>
            </div>
            
            <div style="color: red; text-align: center;">{{ errorMessage.old_password }}</div>
            <div class="col-md-4">
                <label for="newpassword" class="form-label">New Password</label>
                <div class="item col-md-4">
                    <i class="fa-solid fa-lock"></i>
                    <input :type="showNewPassword ? 'text' : 'password'" name="password" v-model="newpassword"
                        placeholder="New Password" />
                    <img v-if="!showNewPassword" @click="toggleNewPassword" src="../../assets/img/login/eye-close.png"
                        alt="Hide Password" />
                    <img v-if="showNewPassword" @click="toggleNewPassword" src="../../assets/img/login/eye-open.png"
                        alt="Show Password" />
                </div>
            </div>
            <div style="color: red; text-align: center;">{{ errorMessage.new_password }}</div>
            
        </div>
        <div class="row mt-4">
            <div class="bt">
                <button type="submit" @click="ChangePassword" class="btn btn2">Change</button>
                <router-link to="/"><input type="reset" value="Cancel" class="mx-4 btn btn-primary"></router-link>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PasswordChange',
    data() {
        return {
            oldpassword: '',
            newpassword: '',

            errorMessage: {
                new_password: '',
                old_password: '',
            },
            showOldPassword: false,
            showNewPassword: false,
        }
    },

    methods: {
        async ChangePassword() {
            try {
                const formData = new FormData();
                formData.append('old_password', this.oldpassword);
                formData.append('new_password', this.newpassword);
                const response = await axios.post('api/admin/change_password', formData)
                if (response.data.status == 200) {
                    this.errorMessage = '';
                    this.logout();
                }
                else if (response.data.status == 422) {
                    this.errorMessage.old_password = response.data.message.old_password ? `${response.data.message.old_password[0]}` : '';
                    this.errorMessage.new_password = response.data.message.new_password ? `${response.data.message.new_password[0]}` : '';
                }
                else if (response.data.status == 404) {
                    this.errorMessage.old_password = response.data.message;
                }
                else {
                    this.errorMessage = '';
                }
            }
            catch (error) {
                alert('Error Occur on Updating Password. Please try again later.')
            }
        },
        toggleOldPassword() {
            this.showOldPassword = !this.showOldPassword;
        },
        toggleNewPassword() {
            this.showNewPassword = !this.showNewPassword;
        },

        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/login');
        },
    },
}
</script>
<style scoped>
.row {
    align-items: center;
    justify-content: center;
}

.bt {
    width: max-content;
}

.item {
    display: flex;
    justify-content: space-between;
    padding: 0 10px;
    align-items: center;
    border-radius: 5px;
    border: 1px solid rgb(182, 181, 181);
    cursor: pointer;
    width: 100%;
}

.item img {
    width: 20px;
}

.item input {
    width: 100%;
    height: 100%;
    padding: 10px 20px;
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
}
</style>
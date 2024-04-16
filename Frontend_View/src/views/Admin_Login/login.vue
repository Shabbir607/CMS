<template>
    <div class="main">
        
        <div class="container">
            <div class="form-container">
                <form @submit.prevent="login">
                    <h2>Login</h2>

                    <div v-if="error" class="alert alert-danger" role="alert"> {{ error }}</div>

                    <div class="item">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" v-model="email" placeholder="Email" autocomplete="off">
                    </div>
                    <p class="inputRequired" v-if="validationErrors.email && validationErrors.email.length > 0">
                        {{ validationErrors.email[0] }}
                    </p>

                    <div class="item">
                        <i class="fa-solid fa-lock"></i>
                        <input :type="showPassword ? 'text' : 'password'" name="password" v-model="password"
                            placeholder="Password" autocomplete="off" />
                        <img v-if="!showPassword" @click="togglePasswordVisibility"
                            src="../../assets/img/login/eye-close.png" alt="Hide Password" />
                        <img v-if="showPassword" @click="togglePasswordVisibility" src="../../assets/img/login/eye-open.png"
                            alt="Show Password" />
                    </div>
                    <p class="inputRequired" v-if="validationErrors.password && validationErrors.password.length > 0">
                        {{ validationErrors.password[0] }}
                    </p>


                    <div class="my-4"><router-link class="forgot" to="/forgot/password">Forgot Password?</router-link></div>
                    <button class="btn btn2">
                        <span v-if="loading" class="spinner-border spinner-border-sm mx-3" aria-hidden="true"></span>
                        <span>Login</span>
                    </button>

                </form>
            </div>

            <div class="image-container">
                <img src="../../assets/img/login/2.png" alt="Registration Image">
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LoginPage',
    data() {
        return {
            email: '',
            password: '',
            error: '',
            validationErrors: {
                email: [],
                password: [],
            },

            showPassword: false,
            loading: false,
        }
    },
    methods: {
        async login() {
            this.loading = !  false;
            try {
                let response = await axios.post('api/admin_login', {
                    email: this.email,
                    password: this.password,
                });
                this.loading = !  true;

                if (response.data.status === 200) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    window.location.href = '/';
                }

                else if (response.data.status === 422) {
                    this.validationErrors = response.data.message;
                    this.error = '';
                } else if (response.data.status === 401) {
                    this.error = response.data.message;
                } else {
                    console.log('Error occurs while login')
                }


            } catch (error) {
                console.error('error')
            }
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
    }

};
</script>

<style scoped>
/* .alert {
    background-color: #b8075a;
    color: #fff;
} */

.inputRequired {
    color: red;
}

h2 {
    font-weight: 800;
    text-align: center;
    color: #b8075a;
}

.main {
    margin: auto;
    margin-top: -40px;
    width: 70%;
    padding: 20px 30px;
    border-radius: 7px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.form-container {
    padding: 20px;
    width: 40%;
}

.item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 10px;
    margin: 40px 0 0 0;
    border-bottom: 1px solid rgb(19, 31, 2);
    width: 100%;
    cursor: pointer;
}

.item img {
    width: 20px;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

label span {
    color: red;
}

input {
    width: 100%;
    height: 100%;
    padding: 0 20px;
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
}

.image-container {
    width: 50%;
}
.image-container img{
    width: 100%;
}

.forgot {
    color: #A6568A;
}

.btn2 {
    margin-top: 12px;
    cursor: pointer;
    padding: 8px;
    border-radius: 5px;
    width: 100%;
    font-weight: bold;
    font-size: 17px;

}

.button:focus {
    color: black;
}

.button:hover {
    background-color: #bb045a;
}

div {
    font-size: 14px;
    margin-top: 15px;
}

a {
    font-weight: bold;
}

@media (max-width: 992px) {
    .container {
        flex-direction: column;
    }

    .main {
        width: 95%;
    }

    .form-container form {
        /* margin-top: 20px; */
        margin: auto;
    }

    .form-container {
        width: 100%;
    }
}

@media (max-width: 410px) {
    .image-container img {
        width: 250px;
    }

}
</style>
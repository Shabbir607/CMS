<template>
    <nav class="navbar fixed-top px-3">
        <div class="nav-left d-flex">
            <button class="btn mini-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#layout-offcanvass"
                aria-controls="offcanvasExample">
                <i class="fa-solid fa-bars "></i>
            </button>
            <div class="sidebar-toggler mx-3"><i class="fa-solid fa-bars " onclick="toggleSidebar()"></i></div>
            <div class="logo"><img src="../../assets/logo/logo.jpg" alt=""></div>
        </div>
        <div class="dropdown nav-right">
            <div class="profile_image" data-bs-toggle="dropdown" aria-expanded="false">
                <img :src="profileImage" alt="" v-if="this.profileImage">
                <img src="../../assets/user/profile_image.png" alt="" v-else>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <img :src="profileImage" alt="" v-if="this.profileImage">
                    <img src="../../assets/user/profile_image.png" alt="" v-else>
                    <span class="mx-3">{{ userName }}</span>
                </li>
                <li>
                    <hr class="my-0">
                </li>
                <li>
                    <router-link to="/userprofile" class="user-links">
                        <i class="fa-regular fa-user"></i>
                        <span class="mx-3">My Profile</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/change/password" class="user-links">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <span class="mx-3">Change Password</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/" class="user-links">
                        <i class="fa-solid fa-gear"></i>
                        <span class="mx-3">Setting</span>
                    </router-link>
                </li>
                <li>
                    <hr class="my-0">
                </li>
                <li @click="logout">
                    <a class="user-links text-danger">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="mx-3">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar accordion" id="sidebar">

        <div class="dropdown-section">
            <router-link to="/" class=" dropdown-btn dashboard" type="button">
                <i class="fa-solid fa-home"></i>
                <span class="mx-3">Dashboard</span>
            </router-link>
        </div>
        <div class="dropdown-section accordion-item">
            <a class=" dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Sales" aria-expanded="false"
                aria-controls="Sales" @click="handleButtonClick(1)"
                :class="{ 'dropdown-btn': true, 'active': activeButton === 1 }">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span class="mx-3">Sales</span>
                <span class="plus-minus">
                    <img class="img1" v-if="activeButton !== 1" src="../../assets/layout-icons/right-arrow.png" alt="">
                    <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                </span>
            </a>
            <ul class="collapse accordion-collapse dropdown-btn-menu" id="Sales" data-bs-parent="#sidebar">
                <router-link class="drop-links" to="/customer">
                    <li>Customers</li>
                </router-link>
                <router-link class="drop-links" to="/salesquotation">
                    <li>Sales Quotation</li>
                </router-link>
                <router-link class="drop-links" to="/sales">
                    <li>Sales Invoice</li>
                </router-link>
                <router-link class="drop-links" to="/paymentcustomer">
                    <li>Customer Reciept</li>
                </router-link>

            </ul>
        </div>

        <div class="dropdown-section accordion-item">
            <a class="dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Purchase" aria-expanded="false"
                aria-controls="Purchase" @click="handleButtonClick(2)"
                :class="{ 'dropdown-btn': true, 'active': activeButton === 2 }">
                <i class="fa-solid fa-cart-arrow-down"></i>
                <span class="mx-3">Purchase</span>
                <span class="plus-minus">
                    <img class="img1" v-if="activeButton !== 2" src="../../assets/layout-icons/right-arrow.png" alt="">
                    <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                </span>
            </a>
            <ul class="collapse accordion-collapse dropdown-btn-menu" id="Purchase" data-bs-parent="#sidebar">
                <router-link class="drop-links" to="/supplier">
                    <li>Supplier</li>
                </router-link>
                <router-link class="drop-links" to="/purchaseorder">
                    <li>Purchase Order</li>
                </router-link>
                <router-link class="drop-links" to="/purchaseinvoice">
                    <li>Purchase Invoice</li>
                </router-link>
                <router-link class="drop-links" to="/supplierpayment">
                    <li>Supplier Payment</li>
                </router-link>
                <router-link class="drop-links" to="/accountexpenses">
                    <li>Account Expenses</li>
                </router-link>
                <router-link class="drop-links" to="/expenses">
                    <li>Supplier Expenses</li>
                </router-link>

            </ul>
        </div>
        <div class="dropdown-section accordion-item">
            <a class="dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Inventory"
                aria-expanded="false" aria-controls="Inventory" @click="handleButtonClick(3)"
                :class="{ 'dropdown-btn': true, 'active': activeButton === 3 }">
                <i class="fa-solid fa-cubes"></i>
                <span class="mx-3">Inventory</span>
                <span class="plus-minus">
                    <img class="img1" v-if="activeButton !== 3" src="../../assets/layout-icons/right-arrow.png" alt="">
                    <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                </span>
            </a>
            <ul class="collapse accordion-collapse dropdown-btn-menu" id="Inventory" data-bs-parent="#sidebar">
                <router-link class="drop-links" to="/product">
                    <li>Item</li>
                </router-link>
                <router-link class="drop-links" to="/category">
                    <li>Item Category</li>
                </router-link>
                <router-link class="drop-links" to="/itemtype">
                    <li>Item Type</li>
                </router-link>
                <router-link class="drop-links" to="/brand">
                    <li>Item Brand</li>
                </router-link>
                <router-link class="drop-links" to="/unit">
                    <li>Units Of Measurement</li>
                </router-link>
                <router-link class="drop-links" to="/location">
                    <li>Location</li>
                </router-link>
                <router-link class="drop-links" to="/StockAdjustment">
                    <li>Stock Adjustment</li>
                </router-link>
                <router-link class="drop-links" to="/stocktransfer">
                    <li>Stock Transfer</li>
                </router-link>

            </ul>
        </div>
    </div>




    <div class="offcanvas mini-sidebar accordion offcanvas-start" tabindex="-1" id="layout-offcanvass"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <img src="../../assets/logo/logo.jpg" alt="" style="width: 120px;">
            <!-- <button type="button" class="btn-close text-light" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
            <i class="fa-solid fa-xmark close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></i>
        </div>
        
            <div class="dropdown-section">
                <router-link to="/" class=" dropdown-btn dashboard" type="button">
                    <i class="fa-solid fa-home"></i>
                    <span class="mx-3">Dashboard</span>
                </router-link>
            </div>
            <div class="dropdown-section accordion-item">
                <a class=" dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Sales"
                    aria-expanded="false" aria-controls="Sales" @click="handleButtonClick(1)"
                    :class="{ 'dropdown-btn': true, 'active': activeButton === 1 }">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    <span class="mx-3">Sales</span>
                    <span class="plus-minus">
                        <img class="img1" v-if="activeButton !== 1" src="../../assets/layout-icons/right-arrow.png" alt="">
                        <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                    </span>
                </a>
                <ul class="collapse accordion-collapse dropdown-btn-menu" id="Sales" data-bs-parent="#layout-offcanvass">
                    <router-link class="drop-links" to="/customer">
                        <li>Customers</li>
                    </router-link>
                    <router-link class="drop-links" to="/salesquotation">
                        <li>Sales Quotation</li>
                    </router-link>
                    <router-link class="drop-links" to="/sales">
                        <li>Sales Invoice</li>
                    </router-link>
                    <router-link class="drop-links" to="/paymentcustomer">
                        <li>Customer Reciept</li>
                    </router-link>
                    <!-- <router-link class="drop-links" to="/">
                    <li>Credit Notes</li>
                </router-link> -->

                </ul>
            </div>

            <div class="dropdown-section accordion-item">
                <a class="dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Purchase"
                    aria-expanded="false" aria-controls="Purchase" @click="handleButtonClick(2)"
                    :class="{ 'dropdown-btn': true, 'active': activeButton === 2 }">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    <span class="mx-3">Purchase</span>
                    <span class="plus-minus">
                        <img class="img1" v-if="activeButton !== 2" src="../../assets/layout-icons/right-arrow.png" alt="">
                        <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                    </span>
                </a>
                <ul class="collapse accordion-collapse dropdown-btn-menu" id="Purchase" data-bs-parent="#layout-offcanvass">
                    <router-link class="drop-links" to="/supplier">
                        <li>Supplier</li>
                    </router-link>
                    <router-link class="drop-links" to="/purchaseorder">
                        <li>Purchase Order</li>
                    </router-link>
                    <router-link class="drop-links" to="/purchaseinvoice">
                        <li>Purchase Invoice</li>
                    </router-link>
                    <router-link class="drop-links" to="/supplierpayment">
                        <li>Supplier Payment</li>
                    </router-link>
                    <router-link class="drop-links" to="/accountexpenses">
                        <li>Account Expenses</li>
                    </router-link>
                    <router-link class="drop-links" to="/expenses">
                        <li>Supplier Expenses</li>
                    </router-link>

                </ul>
            </div>
            <div class="dropdown-section accordion-item">
                <a class="dropdown-btn" type="button" data-bs-toggle="collapse" data-bs-target="#Inventory"
                    aria-expanded="false" aria-controls="Inventory" @click="handleButtonClick(3)"
                    :class="{ 'dropdown-btn': true, 'active': activeButton === 3 }">
                    <i class="fa-solid fa-cubes"></i>
                    <span class="mx-3">Inventory</span>
                    <span class="plus-minus">
                        <img class="img1" v-if="activeButton !== 3" src="../../assets/layout-icons/right-arrow.png" alt="">
                        <img class="img2" v-else src="../../assets/layout-icons/down-arrow.png" alt="">
                    </span>
                </a>
                <ul class="collapse accordion-collapse dropdown-btn-menu" id="Inventory" data-bs-parent="#layout-offcanvass">
                    <router-link class="drop-links" to="/product">
                        <li>Item</li>
                    </router-link>
                    <router-link class="drop-links" to="/category">
                        <li>Item Category</li>
                    </router-link>
                    <router-link class="drop-links" to="/itemtype">
                        <li>Item Type</li>
                    </router-link>
                    <router-link class="drop-links" to="/brand">
                        <li>Item Brand</li>
                    </router-link>
                    <router-link class="drop-links" to="/unit">
                        <li>Units Of Measurement</li>
                    </router-link>
                    <router-link class="drop-links" to="/location">
                        <li>Location</li>
                    </router-link>
                    <router-link class="drop-links" to="/StockAdjustment">
                        <li>Stock Adjustment</li>
                    </router-link>
                    <router-link class="drop-links" to="/stocktransfer">
                        <li>Stock Transfer</li>
                    </router-link>

                </ul>
            </div>
    </div>
</template>

<script>
export default {
    name: 'WebLayout',
    data() {
        return {
            // isPlus: [true, true, true],
            activeButton: null,

            userName: '',
            profileImage: '',
        };
    },
    methods: {
        // toggleIcon(index) {
        //     this.isPlus[index] = !this.isPlus[index];
        // },
        handleButtonClick(buttonIndex) {
            // this.activeButton = buttonIndex;
            this.activeButton = this.activeButton === buttonIndex ? null : buttonIndex;
        },
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/login');
        },
    },
    mounted() {
        const storedUser = localStorage.getItem('user');

        if (storedUser) {
            // Parse the stored user information
            const user = JSON.parse(storedUser);
            this.userName = user.name;
            this.profileImage = user.image;
        }
    }

}
</script>

<style scoped>
.active {
    background-color: #9D568A;
    border-radius: 7px;
}

/* Prifile */
ul.dropdown-menu {
    width: max-content;
    margin-top: 10px;
}

ul.dropdown-menu li {
    margin: 3px 0;
    padding: 2px 7px;
    cursor: pointer;
}

.user-links {
    color: #000;
    text-decoration: none;
    font-weight: bold;
}

.user-links:hover {
    color: #9D568A;
    text-decoration: underline;
}

/********************** NAVBAR CSS ********************/
.navbar {
    height: 60px;
    background-color: #FFFFFF;
    box-shadow: 0 0 10px rgba(0, 0, 0, .3);
}

.mini-toggle {
    display: none;
}

.sidebar-toggler i {
    font-size: 20px;
}

.sidebar-toggler {
    cursor: pointer;
}

.nav-left {
    justify-content: center;
    align-items: center;
}

.logo img {
    width: 150px;
}

.nav-right {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    cursor: pointer;
}

.nav-right img,
.user-dropdown li img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    overflow: hidden;
}


/****************************** Sidebar CSS *******************************/
.sidebar {
    width: 210px;
    position: fixed;
    height: 100%;
    top: 60px;
    left: 0;
    background-color: #603D56;
    transition: left 0.3s;
    overflow-y: auto;
}

.mini-sidebar {
    width: 210px !important;
    background-color: #603D56;
}

.close-btn {
    color: #FFFFFF;
    font-size: 20px;
}

/********************** Sidebar Dropdowns **********************/
.dashboard {
    background-color: #9D568A;
    border-radius: 7px;
}

.dropdown-section {
    margin: 5px 0;
}

.accordion-item {
    background-color: transparent;
    border: none;
}

.dropdown-btn {
    padding: 10px 15px;
    font-size: 15px;
    width: 100%;
    color: #fff;
    text-decoration: none;
    user-select: none;
    font-weight: 500;
}

.dropdown-btn:hover {
    background-color: #9D568A;
    border-radius: 7px;

}

.dropdown-btn .plus-minus {
    float: right;
}

.dropdown-btn .plus-minus .img1 {
    width: 9px;
    height: 14px;
}

.dropdown-btn .plus-minus .img2 {
    width: 14px;
    height: 9px;
}

.dropdown-btn-menu {
    background-color: #fff;
    border-radius: 4px;
    list-style-type: circle;
    /* padding: 10px 0 10px 35px; */
}

.dropdown-btn-menu li {
    color: #000;
    font-size: 14px;
    margin-left: 15px;
    padding-top: 5px;
}

.dropdown-btn-menu .drop-links {
    text-decoration: none;
}

li::marker {
    font-size: 20px;
}

.dropdown-btn-menu li:hover {
    text-decoration: underline;
    list-style-type: disc;
    color: #9D568A;
}

@media (max-width: 992px) {
    .sidebar-toggler {
        display: none;
    }

    .mini-toggle {
        display: block;
    }
}

.sidebar::-webkit-scrollbar {
    width: 8px;
}

/* Track */
.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

/* Handle */
.sidebar::-webkit-scrollbar-thumb {
    background: #9D568A;
    opacity: .5;
    border-radius: 7px;
}</style>
<template>
    <div class="content-wrapper">

        <WebLayout />

        <div class="content" id="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import WebLayout from './views/Layout/layout.vue';

export default {
    name: 'App',
    components: {
        WebLayout,
    },
    created() {
        // Assuming you have access to the router instance
        this.$router.beforeEach((to, from, next) => {
            if (to.path === '/login') {
                // Add the router-root class if the route is '/'
                document.body.classList.add('router-root');
            } else {
                // Remove the router-root class for other routes
                document.body.classList.remove('router-root');
            }
            next();
        });
    },

};
</script>

<style>
.router-root {

    /* Add your styling properties here */
    .content {
        margin-left: 0;
    }

    .sidebar {
        left: -210px !important;
    }

    .navbar {
        display: none;
    }
}

.card {
    padding: 20px;
}

input,
select,
textarea {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    border-radius: 7px;
}

label {
    font-size: 14px;
    font-weight: bold;
}

/* Add or Import Buttons */
.btn1,
.buttn a,
.btn1:hover {
    border-radius: 7px;
    padding: 10px 8px;
    margin: 0 20px;
    background-color: #9D568A;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
}

.buttn .btn1 i {
    padding: 0 10px;
}

.btn2,
.btn2:hover {
    background-color: #9D568A;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    border-radius: 7px;


}



.submit-btn,
.submit-btn:hover {
    background-color: #9D568A;
    padding: 8px 10px;
    border-radius: 7px;
    color: #fff;
    border: none;
    outline: none;
}

/* Back Buttons */
.back {
    width: 500px;
    display: block;
}

.back-icon {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: black;
    width: 100px;
}

.back-icon:hover {
    text-decoration: none;
}

.back .back-icon i {
    font-size: 22px;
}

.back .back-icon span {
    padding-left: 10px;
    font-size: 16px;
}

.back h2 {
    margin-top: 5px;
    font-weight: bold;
    font-size: 18px;
    color: #9D568A;
}

.fa-pen-to-square {
    cursor: pointer;
    color: blue;
}

.fa-trash {
    cursor: pointer;
    color: red;
}

/*  CArd  Search  bar  */
.searching {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    margin-bottom: 20px;
    width: 100%;
    height: 48px;
    border-bottom: 1px solid rgb(22, 21, 21);
}

.searching input {
    width: 100%;
    box-shadow: none;
    outline: none;
    border: none;
    margin-left: 15px;
}

/* Modal */
.modal-dialog {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 90vh;
}

/* In Table EditAble input Field */
td .editable {
    width: 100%;
    outline: none;
    border: none;
    padding: 5px;
    border: .1px solid #9D568A;
}


/* Pagination CSS */
.pagination-container {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    height: 38px;

}

.pagination-container .form-group {
    align-items: center;
    width: 200px;
}

.pagination-container .form-group select {
    width: 70px;
}

/* Every Page Header */

.header {
    width: 100%;
    margin-top: 10px;
}

.headerinfo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

/* .headertype {
    display: flex;
    justify-content: space-between;
    align-items: center;
} */
.headertype h3 {
    font-size: 18px;
    font-weight: bold;
}

.headertype h5 {
    color: #9D568A;
    margin-top: -5px;
    font-size: 15px;
}

/* Filter Search CSS */
.search-icon {
    background-color: #9D568A;
    padding: 7px;
    border-radius: 4px;
}

.filter-search {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    cursor: pointer;
}

/* Table CSS********************************************************** */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th,
td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

th {
    background-color: #9D568A;
    color: #ffffff;
}

tbody tr:nth-child(even) {
    background-color: #dff0f2;
}

tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

/* @media (max-width: 850px) {
    .table {
        overflow-x: auto;
        width: 100%;
    }
} */
</style>
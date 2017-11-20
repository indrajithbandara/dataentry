<template>
    <div>
        <!-- User Table -->
        <div id="users-table" v-if="list.length > 1" class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Permissions</th>
                        <th>Edit</th>
                        <th v-if="user == 1">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="users in list">
                        <td v-if="users.id != 1">{{ users.name }}</td>
                        <td v-if="users.id != 1">{{ users.email }}</td>
                        <td v-if="users.id != 1">{{ users.permission }}</td>
                        <td v-if="users.id != 1"><button @click="showUser(users.id)" class="btn btn-warning">Edit</button></td>
                        <td v-if="users.id != 1"><button @click="deleteUser(users.id)" class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p class="alert alert-info text-center">You currently have no users to show.</p>
        </div>
        <!-- end of users table -->
        <hr>
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- Add User Form -->
        <div>
            <h2 class="text-center">Add User</h2>
            <form action="#" @submit.prevent="edit ? updateUser(users.id) : createUser()">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="users.name" type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input v-model="users.email" type="email" name="email" class="form-control" required>
                </div>
                <div v-show="!edit" class="form-group">
                    <label for="password">Password</label>
                    <input v-model="users.password" type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Permissions</label>
                    <select v-model="users.permission" class="form-control" required>
                        <option>Choose an option</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div>
                <submitBtns :editMode="edit" :name="name='User'"></submitBtns>
            </form>
        </div>
        <!-- End of add user form -->
    </div>
</template>

<script>
    // Imports
    import SubmitBtns from '../components/partials/submit-btn.vue';
    import ErrorMessage from '../components/partials/error-message.vue';
    import SuccessMessage from '../components/partials/success-message.vue';
    export default {
        data() {
            return {
                edit: false,
                users: {
                    id: '',
                    name: '',
                    email: '',
                    permission: ''
                },
                errorMessage: '',
                successMessage: ''
            }
        },
        mounted() {
            this.getUser();
            this.getUsers();
        },
        components: {
            SubmitBtns,
            ErrorMessage,
            SuccessMessage
        },
        computed: {
            user() { 
                return this.$store.getters.getUser; 
            },
            list() { 
                return this.$store.getters.getUsers; 
            }
        },
        methods: {
            getUser(){ 
                this.$store.dispatch('commitPermission'); 
            },
            getUsers(){ 
                this.$store.dispatch('commitUsers'); 
            },
            createUser(){
                axios({
                    method: 'post',
                    url: 'api/users/store',
                    data: this.users,
                    validateStatus(status){
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.reset();
                    this.successMessage = "User has successfully been created!";
                    setTimeout(()=>{
                        this.successMessage = '';
                    }, 5000);
                }).catch( error => {
                    this.errorMessage = "Sorry! Something went wrong when adding your user!";
                    setTimeout(()=>{
                        this.errorMessage = '';
                    }, 10000);
                    throw new Error("Create User Failed! " + error.message);
                });
            },
            updateUser(id){
                axios({
                    method: 'patch',
                    url: 'api/users/' + id,
                    data: this.users,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.reset();
                    this.successMessage = "User has successfully been updated!";
                    setTimeout(()=>{
                        this.successMessage = '';
                    }, 5000);
                }).catch( error => {
                    this.errorMessage = "Sorry! Something went wrong when updating you user!";
                    setTimeout(()=>{
                        this.errorMessage = '';
                    }, 10000);
                    throw new Error("Update User Failed! " + error.message);
                });
            },
            showUser(id){
                axios({
                    method: 'get',
                    url: 'api/users/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then( response => {
                    for (var key in this.users){
                        this.users[key] = response.data[key];
                    }
                }).catch( error => {
                    this.errorMessage = "Sorry! Something went wrong when retrieving your user!";
                    setTimeout(()=>{
                        this.errorMessage = '';
                    }, 10000);
                    throw new Error("Show User Failed! " + error.message);
                });
                this.edit = true;
            },
            deleteUser(id){
                if(id == 1){
                    alert('Sorry!! You are not allowed to delete the admin user.');
                }else{
                    if(confirm('Are you sure you want to delete this user?')){
                        axios.delete('api/users/' + id)
                        .then((response) => {
                            this.getUsers();
                            this.successMessage = "User has successfully been deleted!";
                            setTimeout(()=>{
                                this.successMessage = '';
                            }, 5000);
                        }).catch( error => {
                            this.errorMessage = "Sorry! Something went wrong when updating you user!";
                            setTimeout(()=>{
                                this.errorMessage = '';
                            }, 10000);
                            throw new Error("Delete User Failed! " + error.message);
                        });
                    }else{
                        return;
                    }
                }
            },
            reset(){
                for(var key in this.users){
                    this.users[key] = '';
                }
                this.edit = false;
                this.getUsers();
            }
        }
    }
</script>
<style scoped>
    #users-table { 
        max-height: 565px; 
        overflow: scroll; 
    }
</style>
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
                        <th v-if="user.permission == 1">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="user.id == 1" v-for="users in list">
                        <td>{{ users.name }}</td>
                        <td>{{ users.email }}</td>
                        <td>{{ users.permission }}</td>
                        <td><button @click="showUser(users.id)" class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                        <td v-if="users.id != 1"><button @click="deleteUser(users.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
                    </tr>
                    <tr v-else>
                        <td v-if="users.id != 1">{{ users.name }}</td>
                        <td v-if="users.id != 1">{{ users.email }}</td>
                        <td v-if="users.id != 1">{{ users.permission }}</td>
                        <td v-if="users.id != 1"><button @click="showUser(users.id)" class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                        <td v-if="users.id != 1"><button @click="deleteUser(users.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
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
                <div v-show="users.id != 1" class="form-group">
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
        <!-- Instruction Area -->
        <i @click="instruction = true" class="fa fa-question-circle fa-2x pointer" aria-hidden="true"></i>
        <div v-show="instruction" class="well">
            <i @click="instruction = false" class="fa fa-times-circle pull-right fa-2x pointer"></i>
            <h3 class="text-center">Users Instructions</h3>
            <p>Welcome to the users area of the dataentry system. This area is used for adding users that are able to log into the system under their own 
            login. The dataentry system is a permissions based system which allows up to four different levels of user permission.</p>
            <hr>
            <h4>How to fill out the form</h4>
            <p>Filling out the form is simple. Add the name of the user in the <strong>Name</strong> field, the email address the user will be logging in under in the <strong>Email</strong> field, a secure password of your 
            choice in the <strong>Password</strong> field and the permission level you want the user to have in the <strong>Permissions</strong> drop down menu.</p>
            <hr>
            <h4>Level One: Admins and The Super Admin</h4>
            <p>If you are able to see this page, it is because you are logged in as the <em>Super Admin User</em>. The super admin user not only has level one
            user permissions (which will be explained in a minute), you are also the first user to be entered into the users table in the database which means
            a few things.</p>
            <ol>
                <li>The user registration area is now cut off.</li>
                <li>You are able to delete anything in the system.</li>
                <li>You are able to see everything in the system.</li>
            </ol>
            <p>Literally nothing is cut off from you. You have no restrictions unlike all other levels of permission. You can even add other level one (Admin) users to the system.
            However, what serparates you from other level one users is that your user account can not be deleted whereas other level one users can. In the users table above,
            you'll notice that your account is not present. This is done on purpose so that other level one users are not able to see your login information.</p>
            <hr>
            <h4>Level Two: Assistants</h4>
            <p>An assistant, level two user is able to see all areas of the system aside from the following:</p>
            <ol>
                <li>Settings</li>
                <li>Users</li>
            </ol>
            <p>The assistant role is meant to aid in the invoicing, system as well as manage customer and product information. Assistants are able to edit just about anything they have
            access to; however, they are not able to delete anything from the system.</p>
            <hr>
            <h4>Level Three: Managers</h4>
            <p>A manager, level three user is able to see all areas related to production which means the following areas are restricted:</p>
            <ol>
                <li>Settings</li>
                <li>Users</li>
                <li>Customers</li>
                <li>Invoices</li>
            </ol>
            <p>The managerial role is meant to run the production side of the system.</p>
            <hr>
            <h4>Level Four: Employees</h4>
            <p>The employee role in this system is only meant to serve one purpose: to update which department a given router is in. All employee users will be directed to one page where
            they will fill out a form to submit that their router is moving from one department to another. Employees are restricted from all other areas of the system.</p>
        </div>
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
                instruction: false,
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
                    this.message("User has successfully been created!", 'success', 5000);
                }).catch( error => {
                    this.message("Sorry! Something went wrong when adding your user!", 'error', 10000);
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
                    this.message("User has successfully been updated!", "success", 5000);
                }).catch( error => {
                    this.message("Sorry! Something went wrong when updating your user!", 'error', 10000)
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
                    this.message("Sorry! Something went wrong when retrieving your user!", "error", 10000);
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
                            this.message("User has successfully been deleted!", 'success', 5000);
                        }).catch( error => {
                            this.message("Sorry! Something went wrong when updating you user!", 'error', 10000);
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
            },
            message(message, setting="success", timing){
                if(setting == 'success'){
                    this.successMessage = message;
                    setTimeout(()=>{
                        this.successMessage = '';
                    }, timing);
                } else if (setting == 'error'){
                    this.errorMessage = message;
                    setTimeout(()=>{
                        this.errorMessage = '';
                    }, timing);
                }
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
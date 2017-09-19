<template>
    <div>
        <!-- User Table -->
        <div id="product-table" v-if="list.length > 1" class="table-responsive">
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
                <button v-show="!edit" type="submit" class="btn btn-primary pull-right" name="button">Add User</button>
                <button v-show="edit" type="submit" class="btn btn-primary pull-right" name="button">Update User</button>
            </form>
        </div>
        <!-- End of add user form -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                edit: false,
                list: [],
                users: {
                    id: '',
                    name: '',
                    email: '',
                    permission: ''
                },
                user: ''
            }
        },
        mounted() {
            this.getUsers();
            this.getUser();
            console.log(this.list);
        },
        methods: {
            getUser(){
                axios.get('api/user')
                .then((response) => {
                    this.user = response.data.permission;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getUsers(){
                axios.get('api/users')
                .then((response) => {
                    this.list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            createUser(){
                let self = this;
                let params = Object.assign({}, self.users);
                axios({
                    method: 'post',
                    url: 'api/users/store',
                    data: params,
                    validateStatus(status){
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.users.name = '';
                    self.users.email = '';
                    self.users.password = '';
                    self.users.permission = '';
                    self.edit = false;
                    self.getUsers();
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            updateUser(id){
                let self = this;
                let params = Object.assign({}, self.users);
                axios({
                    method: 'patch',
                    url: 'api/users/' + id,
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.users.name = '',
                    self.users.email = '',
                    self.users.permission = '',
                    self.edit = false;
                    self.getUsers();
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            showUser(id){
                let self = this;
                axios({
                    method: 'get',
                    url: 'api/users/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    self.users.id = response.data.id;
                    self.users.name = response.data.name;
                    self.users.email = response.data.email;
                    self.users.permission = response.data.permission;
                }).catch((error) => {
                    console.log(error.message);
                });
                self.edit = true;
            },
            deleteUser(id){
                if(id == 1){
                    alert('Sorry!! You are not allowed to delete the admin user.');
                }else{
                    if(confirm('Are you sure you want to delete this user?')){
                        let self = this;
                        axios.delete('api/users/' + id)
                        .then((response) => {
                            self.getUsers();
                        }).catch((error) => {
                            console.log(error.message);
                        });
                    }else{
                        return;
                    }
                }
            }
        }
    }
</script>
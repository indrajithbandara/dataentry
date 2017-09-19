<template>
    <div>
        <div class="row">
            <div class="col-sm-12 col-md-6"><button @click="table = true" class="btn btn-primary btn-lg full-width">View Customers</button></div>
            <div class="col-sm-12 col-md-6"><button @click="table = false" class="btn btn-success btn-lg full-width">Add A Customer</button></div>
        </div>
        <hr>
        <div v-show="table">
            <!-- Customers Table -->
            <div id="product-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Buyer</th>
                            <th>ShipTo</th>
                            <th>BillTo</th>
                            <th>Country</th>
                            <th>Disclaimer</th>
                            <th>Comments</th>
                            <th>Edit</th>
                            <th v-if="user == 1">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in list">
                            <td>{{ customer.name }}</td>
                            <td>{{ customer.email }}</td>
                            <td>{{ customer.phone }}</td>
                            <td>{{ customer.buyer }}</td>
                            <td v-if="customer.shipto.length > 10" v-bind:title="customer.shipto">{{ customer.shipto.substring(0, 10) + '...' }}</td>
                            <td v-else>{{ customer.shipto }}</td>
                            <td v-if="customer.billto.length > 10" v-bind:title="customer.billto">{{ customer.billto.substring(0, 10) + '...' }}</td>
                            <td v-else>{{ customer.billto }}</td>
                            <td>{{ customer.country }}</td>
                            <td v-if="customer.disclaimer.length > 10" v-bind:title="customer.disclaimer">{{ customer.disclaimer.substring(0, 10) + '...' }}</td>
                            <td v-else>{{ customer.disclaimer }}</td>
                            <td v-if="customer.comments.length > 10" v-bind:title="customer.comments">{{ customer.comments.substring(0, 10) + '...' }}</td>
                            <td v-else>{{ customer.comments }}</td>
                            <td><button @click="showCustomer(customer.id)" class="btn btn-warning">Edit</button></td>
                            <td v-if="user == 1"><button @click="deleteCustomer(customer.id)" class="btn btn-danger">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no customers to show.</p>
            </div>
            <!-- end of customer table -->
        </div>
        <hr>
        <!-- Add customer Form -->
        <div v-show="!table">
            <h2 class="text-center">Add Customer</h2>
            <form action="#" @submit.prevent="edit ? updateCustomer(customer.id) : createCustomer()">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input v-model="customer.name" type="text" name="name" class="form-control" required maxlength="50">
                            <p class="alert alert-warning" v-if="customer.name.length == 50">50 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexAlphaWarning">{{ regexAlphaWarning }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input v-model="customer.email" type="email" name="email" class="form-control" required maxlength="50">
                            <p class="alert alert-warning" v-if="customer.email.length == 50">50 character limit reached!</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input v-model="customer.phone" type="text" name="phone" class="form-control" required maxlength="25">
                            <p class="alert alert-warning" v-if="customer.phone.length == 25">25 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexPhoneWarning">{{ regexPhoneWarning }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="buyer">Buyer</label>
                            <input v-model="customer.buyer" type="text" name="buyer" class="form-control" required maxlength="50">
                            <p class="alert alert-warning" v-if="customer.buyer.length == 50">50 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexAlphaWarning">{{ regexAlphaWarning }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <input v-model="customer.country" type="text" name="country" class="form-control" maxlength="15">
                    <p class="alert alert-warning" v-if="customer.country.length == 15">15 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexBlobWarning">{{ regexBlobWarning }}</p>
                </div>

                <div class="form-group">
                    <label for="shipto">Ship To Address</label>
                    <textarea v-model="customer.shipto" type="text" name="shipto" class="form-control" rows="3" required maxlength="255"></textarea>
                    <p class="alert alert-warning" v-if="customer.shipto.length == 255">255 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexAddressWarning">{{ regexAddressWarning }}</p>
                </div>

                <div class="form-group">
                    <label for="billto">Bill To Address</label>
                    <textarea v-model="customer.billto" type="text" name="billto" class="form-control" rows="3" required maxlength="255"></textarea>
                    <p class="alert alert-warning" v-if="customer.billto.length == 255">255 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexAddressWarning">{{ regexAddressWarning }}</p>
                </div>

                <div class="form-group">
                    <label for="disclaimer">Disclaimer</label>
                    <textarea v-model="customer.disclaimer" type="text" name="disclaimer" class="form-control" rows="3" maxlength="255"></textarea>
                    <p class="alert alert-warning" v-if="customer.disclaimer.length == 255">255 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexBlobWarning">{{ regexBlobWarning }}</p>
                </div>

                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea v-model="customer.comments" type="text" name="comments" class="form-control" rows="3" maxlength="255"></textarea>
                    <p class="alert alert-warning" v-if="customer.comments.length == 255">255 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexBlobWarning">{{ regexBlobWarning }}</p>
                </div>

                <div class="form-group">
                    <button v-show="!edit" type="submit" class="btn btn-primary full-width" name="button">Add Customer</button>
                    <button v-show="edit" type="submit" class="btn btn-primary full-width" name="button">Update Customer</button>
                </div>
            </form>
        </div>
        <br />
        <br />
        <!-- End of add customer form -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                edit: false,
                table: true,
                list: [],
                customer: {
                    name: '',
                    email: '',
                    phone: '',
                    buyer: '',
                    shipto: '',
                    billto: '',
                    country: '',
                    disclaimer: '',
                    comments: ''
                },
                regexAlphaWarning: '',
                regexAddressWarning: '',
                regexBlobWarning: '',
                regexPhoneWarning: '',
                user: ''
            }
        },
        mounted() {
            this.getCustomers();
            this.getUser();
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
            getCustomers(){
                axios.get('api/customers')
                .then((response) => {
                    this.list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            createCustomer(){
                let self = this;
                self.regexAlpha(self.customer.name);
                self.regexAddress(self.customer.shipto);
                self.regexAddress(self.customer.billto);
                self.regexAlpha(self.customer.buyer);
                self.regexPhone(self.customer.phone);
                self.regexBlob(self.customer.country);
                self.regexBlob(self.customer.disclaimer);
                self.regexBlob(self.customer.comments);
                if(!self.customer.country){self.customer.country = 'NA';}
                if(!self.customer.disclaimer){self.customer.disclaimer = 'NA';}
                if(!self.customer.comments){self.customer.comments = 'NA';}
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'post',
                    url: 'api/customers/store',
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.customer.name = '';
                    self.customer.email = '';
                    self.customer.phone = '';
                    self.customer.buyer = '';
                    self.customer.shipto = '';
                    self.customer.billto = '';
                    self.customer.country = '';
                    self.customer.disclaimer = '';
                    self.customer.comments = '';
                    self.edit = false;
                    self.getCustomers();
                    self.table = true;
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            updateCustomer(id){
                let self = this;
                self.regexAlpha(self.customer.name);
                self.regexAddress(self.customer.shipto);
                self.regexAddress(self.customer.billto);
                self.regexAlpha(self.customer.buyer);
                self.regexPhone(self.customer.phone);
                self.regexBlob(self.customer.country);
                self.regexBlob(self.customer.disclaimer);
                self.regexBlob(self.customer.comments);
                if(!self.customer.country){self.customer.country = 'NA';}
                if(!self.customer.disclaimer){self.customer.disclaimer = 'NA';}
                if(!self.customer.comments){self.customer.comments = 'NA';}
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'patch',
                    url: 'api/customers/' + id,
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.customer.name = '';
                    self.customer.email = '';
                    self.customer.phone = '';
                    self.customer.buyer = '';
                    self.customer.shipto = '';
                    self.customer.billto = '';
                    self.customer.country = '';
                    self.customer.disclaimer = '';
                    self.customer.comments = '';
                    self.edit = false;
                    self.getCustomers();
                    self.table = true;
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            showCustomer(id){
                let self = this;
                axios({
                    method: 'get',
                    url: 'api/customers/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    self.table = false;
                    self.customer.id = response.data.id;
                    self.customer.name = response.data.name;
                    self.customer.email = response.data.email;
                    self.customer.phone = response.data.phone;
                    self.customer.buyer = response.data.buyer;
                    self.customer.shipto = response.data.shipto;
                    self.customer.billto = response.data.billto;
                    self.customer.country = response.data.country;
                    self.customer.disclaimer = response.data.disclaimer;
                    self.customer.comments = response.data.comments;
                }).catch((error) => {
                    console.log(error.message);
                });
                self.edit = true;
            },
            deleteCustomer(id){
                if(confirm('Are you sure you want to delete this customer?')){
                    let self = this;
                    axios.delete('api/customers/' + id)
                    .then((response) => {
                        self.getCustomers();
                    }).catch((error) => {
                        console.log(error.message);
                    });
                }else{
                    return;
                }
            },
            regexAlpha(string){
                if(string){
                    var pattern = /^(?!-)(?!.*--)[A-Za-z\,\.\s]+$/;
                    if(pattern.test(string) != true){
                        this.regexAlphaWarning = "Unapproved characters detected! Only alphabetical characters, commas and periods are approved for this field.";
                        return;
                    } else {
                        this.regexAlphaWarning = '';
                    }
                }
            },
            regexAddress(string){
                if(string){
                    var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+$/;
                    if(pattern.test(string) != true){
                        this.regexAddressWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, highens, commas and periods. However, '--' is not allowed.";
                        return;
                    } else {
                        this.regexAddressWarning = '';
                    } 
                }
            },
            regexBlob(string){
                if(string){
                    var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+$/;
                    if(pattern.test(string) != true){
                        this.regexBlobWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, &, -, (), /, *, #, commas and periods. However, '--' is not allowed.";
                        return;
                    } else {
                        this.regexBlobWarning = '';
                    } 
                }
            },
            regexPhone(string){
                if(string){
                    var pattern = /^(?!-)(?!.*--)[0-9\(\)\-\s]+$/;
                    if(pattern.test(string) != true){
                        this.regexPhoneWarning = "Unapproved characters detected! Only numerica characters, parenthesis and dashes. However, '--' is not allowed.";
                        return;
                    } else {
                        this.regexPhoneWarning = '';
                    } 
                }
            }
        }
    }
</script>
<template>
    <div>
        <div class="row"> 
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = true" class="btn btn-primary btn-lg full-width">View Customers</button></div>
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = false" class="btn btn-success btn-lg full-width">Add A Customer</button></div>
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

                <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="customer.name" @keyup="regexNameCheck(customer.name)" type="text" name="name" class="form-control" required maxlength="50">
                    <p class="alert alert-warning" v-if="customer.name.length == 50">50 character limit reached!</p>
                    <p class="alert alert-danger" v-if="regexNameWarning">{{ regexNameWarning }}</p>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input v-model="customer.email" type="email" name="email" class="form-control" required maxlength="50">
                            <p class="alert alert-warning" v-if="customer.email.length == 50">50 character limit reached!</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input v-model="customer.phone" @keyup="regexPhoneCheck(customer.phone)" type="text" name="phone" class="form-control" required maxlength="25">
                            <p class="alert alert-warning" v-if="customer.phone.length == 25">25 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexPhoneWarning">{{ regexPhoneWarning }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="buyer">Buyer</label>
                            <input v-model="customer.buyer" @keyup="regexBuyerCheck(customer.buyer)" type="text" name="buyer" class="form-control" required maxlength="50">
                            <p class="alert alert-warning" v-if="customer.buyer.length == 50">50 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexBuyerWarning">{{ regexBuyerWarning }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input v-model="customer.country" @keyup="regexCountryCheck(customer.country)" type="text" name="country" class="form-control" maxlength="15">
                            <p class="alert alert-warning" v-if="customer.country.length == 15">15 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexCountryWarning">{{ regexCountryWarning }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="shipto">Ship To Address</label>
                            <textarea v-model="customer.shipto" @keyup="regexShiptoCheck(customer.shipto)" type="text" name="shipto" class="form-control" rows="3" required maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.shipto.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexShiptoWarning">{{ regexShiptoWarning }}</p>
                        </div>
                    </div>                
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="billto">Bill To Address</label>
                            <textarea v-model="customer.billto" @keyup="regexBilltoCheck(customer.billto)" type="text" name="billto" class="form-control" rows="3" required maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.billto.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexBilltoWarning">{{ regexBilltoWarning }}</p>
                        </div>
                    </div>                
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="disclaimer">Disclaimer</label>
                            <textarea v-model="customer.disclaimer" @keyup="regexDiscCheck(customer.disclaimer)" type="text" name="disclaimer" class="form-control" rows="3" maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.disclaimer.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexDiscWarning">{{ regexDiscWarning }}</p>
                        </div>
                    </div>                
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea v-model="customer.comments" @keyup="regexComCheck(customer.comments)" type="text" name="comments" class="form-control" rows="3" maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.comments.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexComWarning">{{ regexComWarning }}</p>
                        </div>
                    </div>                
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
                edit: false, // Hides or shows edit mode which changes the text and functionality of the submit button.
                table: true, // If true, the customers table is showing. If false, the customers form is showing.
                list: [], // Array for listting out the results of the ajax calls
                customer: { // Customer model and it's values
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
                // List of warning properties that have value added by there corrisponding regex[name]Check methods below.
                regexNameWarning: '', 
                regexBuyerWarning: '',
                regexPhoneWarning: '',
                regexCountryWarning: '',
                regexShiptoWarning: '',
                regexBilltoWarning: '',
                regexDiscWarning: '',
                regexComWarning: '',
                // Property for know who the user is and knowing what to hide form other users. 
                user: ''
            }
        },
        mounted() { 
            // when vue instance is mounted, get the customers and the authenticated user.
            this.getCustomers();
            this.getUser();
        },
        methods: {
            getUser(){ // ajax call to get the authenticated user
                axios.get('api/user')
                .then((response) => {
                    this.user = response.data.permission;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getCustomers(){ // ajax call to get all the customers
                axios.get('api/customers')
                .then((response) => {
                    this.list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            createCustomer(){ // post request to add a customer
                this.valueCheck();
                let self = this;
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'post',
                    url: 'api/customers/store',
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.resetValues();
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            updateCustomer(id){ // patch request to update a customer
                this.valueCheck();
                let self = this;
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'patch',
                    url: 'api/customers/' + id,
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    self.resetValues();
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            showCustomer(id){ // grad a specific customer to be edited.
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
            deleteCustomer(id){ // deletes a specific customer, only the Super Admin can make this request as the button is only visable for that user.
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
            /*
            * Regex methods for each of the feilds. Tried to tie all of this up into one function but
            * it was buggy and didn't work everytime. It worked a lot better when each field had
            * it's own regex check. 
            *
            * Each regex method has a empty string check because it would throw the error even if the
            * field was empty, so I added a check for emptiness and it would set the waring to an empty
            * string as well. 
            *
            * In the conditional statment for the pattern test as well, it needed an else statment to get ride
            * of the error for when the user got ride of the unapproved character but the field wasn't empty. 
            */
            regexNameCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z\,\.\s]+$/;
                if(string == ''){
                    this.regexNameWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexNameWarning = "Unapproved characters detected! Only alphabetical characters, commas and periods are approved for this field.";
                    return;
                } else {
                    this.regexNameWarning = '';
                }
            },
            regexBuyerCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z\,\.\s]+$/;
                if(string == ''){
                    this.regexBuyerWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexBuyerWarning = "Unapproved characters detected! Only alphabetical characters, commas and periods are approved for this field.";
                    return;
                } else {
                    this.regexBuyerWarning = '';
                }
            },
            regexCountryCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z\,\.\s]+$/;
                if(string == ''){
                    this.regexCountryWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexCountryWarning = "Unapproved characters detected! Only alphabetical characters, commas and periods are approved for this field.";
                    return;
                } else {
                    this.regexCountryWarning = '';
                }
            },
            regexShiptoCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+$/;
                if(string == ''){
                    this.regexShiptoWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexShiptoWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, highens, commas and periods. However, '--' is not allowed.";
                    return;
                } else {
                    this.regexShiptoWarning = '';
                } 
            },
            regexBilltoCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+$/;
                if(string == ''){
                    this.regexBilltoWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexBilltoWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, highens, commas and periods. However, '--' is not allowed.";
                    return;
                } else {
                    this.regexBilltoWarning = '';
                } 
            },
            regexDiscCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+$/;
                if(string == ''){
                    this.regexDiscWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexDiscWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, &, -, (), /, *, #, commas and periods. However, '--' is not allowed.";
                    return;
                } else {
                    this.regexDiscWarning = '';
                }
            },
            regexComCheck(string){
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+$/;
                if(string == ''){
                    this.regexComWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexComWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, &, -, (), /, *, #, commas and periods. However, '--' is not allowed.";
                    return;
                } else {
                    this.regexComWarning = '';
                } 
            },
            regexPhoneCheck(string){
                var pattern = /^(?!-)(?!.*--)[0-9\(\)\-\s]+$/;
                if(string == ''){
                    this.regexPhoneWarning = '';
                    return;
                }
                if(pattern.test(string) != true){
                    this.regexPhoneWarning = "Unapproved characters detected! Only numerica characters, parenthesis and dashes. However, '--' is not allowed.";
                    return;
                } else {
                    this.regexPhoneWarning = '';
                }
            },
            valueCheck(){
                if(!this.customer.country){this.customer.country = 'NA';}
                if(!this.customer.disclaimer){this.customer.disclaimer = 'NA';}
                if(!this.customer.comments){this.customer.comments = 'NA';}
            },
            resetValues(){
                this.customer.name = '';
                this.customer.email = '';
                this.customer.phone = '';
                this.customer.buyer = '';
                this.customer.shipto = '';
                this.customer.billto = '';
                this.customer.country = '';
                this.customer.disclaimer = '';
                this.customer.comments = '';
                this.edit = false;
                this.getCustomers();
                this.table = true;
            }
        }
    }
</script>
<template>
    <div>
        <div class="row"> 
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = true" class="btn btn-primary btn-lg full-width">View Invoices</button></div>
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = false" class="btn btn-success btn-lg full-width">Add An Invoice</button></div>
        </div>
        <hr>
        <div v-show="table">
            <!-- Customers Table -->
            <div id="product-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Ship Date</th>
                            <th>Customer</th>
                            <th>Extended Price</th>
                            <th>Print Shipper</th>
                            <th>Print Invoice</th>
                            <th>Edit</th>
                            <th v-if="user == 1">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="invoice in list">
                            <td>{{ invoice.inv_num }}</td>
                            <td>{{ invoice.date }}</td>
                            <td>{{ invoice.customer }}</td>
                            <td>{{ invoice.total }}</td>
                            <td><button @click="showInvoice(invoice.id)" class="btn btn-warning">Edit</button></td>
                            <td v-if="user == 1"><button @click="deleteInvoice(invoice.id)" class="btn btn-danger">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no invoices to show.</p>
            </div>
            <!-- end of customer table -->
        </div>
        <hr>
        <!-- Add customer Form -->
        <div v-show="!table">
            <h2 class="text-center">Add Invoice</h2>
            <form action="#" @submit.prevent="edit ? updateInvoice(invoice.id) : createInvoice()">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="inv_num">Invoice #</label>
                            <input v-model="invoice.inv_num" type="number" name="inv_num" class="form-control" required maxlength="11">
                            <p class="alert alert-warning" v-if="invoice.inv_num.length == 11">11 character limit reached!</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input v-model="invoice.date" type="date" name="date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Customer</label>
                    <select v-model="invoice.customer" class="form-control" required>
                        <option>Choose an option</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="po_num">P.O #</label>
                    <input v-model="invoice.po_num" type="text" name="po_num" class="form-control" required maxlength="30">
                    <p class="alert alert-warning" v-if="invoice.po_num.length == 30">30 character limit reached!</p>
                </div>

                <hr>
                    <!-- Line item forms -->
                <hr>

                <div class="form-group">
                    <label for="ship_fee">Shipping Fee</label>
                    <input v-model="invoice.ship_fee" type="number" name="ship_fee" class="form-control">
                </div>

                <div class="pull-right">
                    <h3>Total: ${{ invoice.total }}</h3>
                </div>
                
                <div class="clearfix"></div>
              
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <textarea v-model="invoice.memo" type="text" name="memo" class="form-control" rows="3" maxlength="255"></textarea>
                    <p class="alert alert-warning" v-if="invoice.memo.length == 255">255 character limit reached!</p>
                </div>

                <div class="form-group">
                    <button v-show="!edit" type="submit" class="btn btn-primary full-width" name="button">Add Invoice</button>
                    <button v-show="edit" type="submit" class="btn btn-primary full-width" name="button">Update Invoice</button>
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
                table: true, // If true, the invoices table is showing. If false, the invoices form is showing.
                list: [], // Array for listting out the results of the ajax calls
                invoice: { // Invoices model and it's values
                    inv_num: '',
                    date: '',
                    // Copy of the customer in the customers table
                    customer: '',
                    name: '',
                    shipto: '',
                    billto: '',
                    buyer: '',
                    email: '',
                    phone: '',
                    country: '',
                    disclaimer: '',
                    comments: '',
                    // End of customer copy
                    po_num: '',
                    // Start of line item enries x 7
                    // ========================== One
                    li_one: '',
                    product_one: '',
                    qty_one: 0,
                    unit_one: 0,
                    extended_one: 0,
                    // ========================== Two
                    li_two: '',
                    product_tw: '',
                    qty_two: 0,
                    unit_two: 0,
                    extended_two: 0,
                    //=========================== Three
                    li_three: '',
                    product_three: '',
                    qty_three: 0,
                    unit_three: 0,
                    extended_three: 0,
                    // ========================= Four
                    li_four: '',
                    product_four: '',
                    qty_four: 0,
                    unit_four: 0,
                    extended_four: 0,
                    // ========================= Five
                    li_five: '',
                    product_five: '',
                    qty_five: 0,
                    unit_five: 0,
                    extended_five: 0,
                    // ========================= Six
                    li_six: '',
                    product_six: '',
                    qty_six: 0,
                    unit_six: 0,
                    extended_six: 0,
                    // ========================= Seven
                    li_seven: '',
                    product_seven: '',
                    qty_seven: 0,
                    unit_seven: 0,
                    extended_seven: 0,
                    // End of line item entries
                    ship_fee: 0,
                    total: 0,
                    memo: ''
                },
                // Property for know who the user is and knowing what to hide form other users. 
                user: ''
            }
        },
        mounted() { 
            // when vue instance is mounted, get the customers and the authenticated user.
            this.getInvoices();
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
            getInvoices(){ // ajax call to get all the customers
                axios.get('api/invoices')
                .then((response) => {
                    this.list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            createInvoice(){ // post request to add an invoice
                // this.valueCheck();
                let self = this;
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'post',
                    url: 'api/invoices/store',
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
            updateInvoice(id){ // patch request to update an invoice
                this.valueCheck();
                let self = this;
                let params = Object.assign({}, self.customer);
                axios({
                    method: 'patch',
                    url: 'api/invoices/' + id,
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
            showInvoice(id){ // grad a specific invoice to be edited.
                let self = this;
                axios({
                    method: 'get',
                    url: 'api/invoices/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    self.table = false;
                    // self.customer.id = response.data.id;
                    // self.customer.name = response.data.name;
                    // self.customer.email = response.data.email;
                    // self.customer.phone = response.data.phone;
                    // self.customer.buyer = response.data.buyer;
                    // self.customer.shipto = response.data.shipto;
                    // self.customer.billto = response.data.billto;
                    // self.customer.country = response.data.country;
                    // self.customer.disclaimer = response.data.disclaimer;
                    // self.customer.comments = response.data.comments;
                }).catch((error) => {
                    console.log(error.message);
                });
                self.edit = true;
            },
            deleteInvoice(id){ // deletes a specific invoice, only the Super Admin can make this request as the button is only visable for that user.
                if(confirm('Are you sure you want to delete this invoice?')){
                    let self = this;
                    axios.delete('api/invoices/' + id)
                    .then((response) => {
                        self.getInvoices();
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
<template>
    <div>
        <ViewAddBtns 
            :textOne="'View Customers'"
            :textTwo="'Add A Customer'"
            :toTable="switchToTable"
            :toForm="switchToForm">    
        </ViewAddBtns>
        <hr>
        <!-- Messages -->
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- End of Messages -->
        <div v-show="table">
            <!-- Customers Table -->
            <div id="customer-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Buyer</th>
                            <th>Country</th>
                            <th>View</th>
                            <th v-if="user == 1 || user == 2">Edit</th>
                            <th v-if="user == 1">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in list">
                            <td>{{ customer.id }}</td>
                            <td>{{ customer.name }}</td>
                            <td>{{ customer.email }}</td>
                            <td>{{ customer.phone }}</td>
                            <td>{{ customer.buyer }}</td>
                            <td>{{ customer.country }}</td>
                            <td><button @click="viewCustomer(customer.id)" class="btn btn-default btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></td>
                            <td v-if="user == 1 || user == 2"><button @click="showCustomer(customer.id)" class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                            <td v-if="user == 1"><button @click="deleteCustomer(customer.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no customers to show.</p>
            </div>
        </div>
        <!-- end of customer table -->
        <transition name="fade">
            <div v-show="read" class="well">
                <h2 class="lg-font">{{ customer.name }}</h2>
                <strong class="mid-font">Email: </strong><span>{{ customer.email }}</span><br>
                <strong class="mid-font">Phone: </strong><span>{{ customer.phone }}</span><br>
                <strong class="mid-font">Buyer: </strong><span>{{ customer.buyer }}</span><br>
                <strong class="mid-font">Ship To Address: </strong><span>{{ customer.shipto }}</span><br>
                <strong class="mid-font">Bill To Address: </strong><span>{{ customer.billto }}</span><br>
                <strong class="mid-font">Country: </strong><span>{{ customer.country }}</span><br>
                <strong class="mid-font">Disclaimer: </strong><span>{{ customer.disclaimer }}</span><br>
                <strong class="mid-font">Comments: </strong><span>{{ customer.comments }}</span><br>
                <button class="btn btn-danger full-width" @click="closeView()">Close Viewing</button>
            </div>
        </transition>
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
                            <label for="billto">Bill To Address</label>
                            <textarea v-model="customer.billto" @keyup="regexBilltoCheck(customer.billto)" type="text" name="billto" class="form-control" rows="3" required maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.billto.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexBilltoWarning">{{ regexBilltoWarning }}</p>
                        </div>
                    </div>                
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="shipto">Ship To Address</label>
                            <textarea v-model="customer.shipto" @keyup="regexShiptoCheck(customer.shipto)" type="text" name="shipto" class="form-control" rows="3" required maxlength="255"></textarea>
                            <p class="alert alert-warning" v-if="customer.shipto.length == 255">255 character limit reached!</p>
                            <p class="alert alert-danger" v-if="regexShiptoWarning">{{ regexShiptoWarning }}</p>
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
                <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
                <SubmitBtns :editMode="edit" :name="name='Customer'"></SubmitBtns>
            </form>
        </div>
        <br />
        <br />
        <!-- End of add customer form -->
        <!-- Instruction Area -->
        <i @click="instruction = true" class="fa fa-question-circle fa-2x pointer" aria-hidden="true"></i>
        <transition name="fade">
            <div v-show="instruction" class="well">
                <i @click="instruction = false" class="fa fa-times-circle pull-right fa-2x pointer"></i>
                <h3 class="text-center">Customers Instructions</h3>
                <h4>Filling out the form</h4>
                <p>The customer data is essential as it is used extensively in multiple printables throughout the dataentry system. Here are some instructions on how to fill out this form. This section is the only
                section that allows for somewhat duplicate information. Sometimes you'll want the same customer name but with different addresses, or different phone numbers. This can get confusing the more duplicate entries you have
                which is why each customer entry is given an ID number so that they may be uniquely identified when being used in other parts of the system. These ID numbers are not editable and will auto increment on their own 
                with every entry. Even if you delete all customers, the ID number will continue to auto increment from where it last was. Also, feel free to edit your customer info without changing the customer information of 
                past invoices as the system will take a snap shot of the customer information at the time it was created. </p>
                <ol>
                    <li><strong>Name: </strong>The name of the customer.</li>
                    <li><strong>Email: </strong>The contact email of the customer.</li>
                    <li><strong>Phone: </strong>The contact phone number of the customer.</li>
                    <li><strong>Buyer: </strong>The name of the one who is making the purchases on behalf of the company.</li>
                    <li><strong>Country: </strong>The country of which the customer resides.</li>
                    <li><strong>Bill To Address: </strong>The address that will be billed. The address will appear on the invoice and the shipper as 
                    it appears here.</li>
                    <li><strong>Ship To Address: </strong>The address that the products will be shipping to. The address will appear on the invocie and the shipper
                    as it appears here.</li>
                    <li><strong>Disclaimer: </strong>The disclaimer is a note of information that will appear on the shipper.</li>
                    <li><strong>Comments: </strong>The comments that will need to follow this invoice through it's life cycle. This information is not printed anywhere in the system.</li>
                </ol>
            </div>
        </transition>
    </div>
</template>

<script>
    // Imports
    import ViewAddBtns from '../components/partials/view-add-btns.vue';
    import SubmitBtns from '../components/partials/submit-btn.vue';
    import ErrorMessage from '../components/partials/error-message.vue';
    import SuccessMessage from '../components/partials/success-message.vue';
    // Export
    export default {
        data() {
            return {
                edit: false, // Hides or shows edit mode which changes the text and functionality of the submit button.
                table: true, // If true, the customers table is showing. If false, the customers form is showing.
                read: false,
                instruction: false,
                customer: { // Customer model and it's values
                    id: '',
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
                // property for error messages
                errorMessage: '',
                successMessage: '',
                // List of warning properties that have value added by there corrisponding regex[name]Check methods below.
                regexNameWarning: '', 
                regexBuyerWarning: '',
                regexPhoneWarning: '',
                regexCountryWarning: '',
                regexShiptoWarning: '',
                regexBilltoWarning: '',
                regexDiscWarning: '',
                regexComWarning: ''
            }
        },
        mounted() { 
            // when vue instance is mounted, get the customers and the authenticated user.
            this.getUser();
            this.getCustomers();
        },
        components: {
            ViewAddBtns,
            SubmitBtns,
            ErrorMessage,
            SuccessMessage
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            },
            list() {
                return this.$store.getters.getCustomers;
            }
        },
        methods: {
            /*
            *===== COMPONENT METHODS =====
            */
            switchToTable(){ // prop: toTable | component: <viewAddBtns>
                this.table = true;
            },
            switchToForm(){ // prop: toForm | component: <viewAddBtns>
                this.table = false;
            },
            getUser(){ // ajax call to get the authenticated user
                this.$store.dispatch('commitPermission');
            },
            getCustomers(){ // ajax call to get all the customers
                this.$store.dispatch('commitCustomers');
            },
            // ===== C.R.U.D methods =====
            createCustomer(){ // post request to add a customer
                this.valueCheck();
                axios({
                    method: 'post',
                    url: 'api/customers/store',
                    data: this.customer,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.resetValues();
                    this.message("Customer has successfully been created!", 'success', 5000);
                }).catch((error) => {
                    throw new Error("Create Customer Failed! " + error.message);
                    this.message("Sorry! Something went wrong when creating your customer!", 'error', 10000);
                });
            },
            updateCustomer(id){ // patch request to update a customer
                this.valueCheck();
                axios({
                    method: 'patch',
                    url: 'api/customers/' + id,
                    data: this.customer,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.resetValues();
                    this.message("Customer has successfully updated!", 'success', 5000);
                }).catch( error => {
                    throw new Error("Update Customer Failed! " + error.message);
                    this.message("Sorry! Something went wrong when updating your customer!", 'error', 10000);
                });
            },
            showCustomer(id){ // grad a specific customer to be edited.
                axios({
                    method: 'get',
                    url: 'api/customers/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then( response => {
                    this.table = false;
                    for (var key in this.customer){
                        this.customer[key] = response.data[key];
                    }
                }).catch( error => {
                    throw new Error("Show Customer Failed! " + error.message);
                    this.message("Sorry! Something went wrong when receiving your customer info!", 'error', 10000);
                });
                this.edit = true;
            },
            viewCustomer(id){
                axios({
                    method: 'get',
                    url: 'api/customers/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then( response => {
                    this.read = true;
                    for (var key in this.customer){
                        this.customer[key] = response.data[key];
                    }
                }).catch( error => {
                    throw new Error("View Customer Failed! " + error.message);
                    this.message("Sorry! Something went wrong when receiving your customer info!", 'error', 10000);
                });
            },
            deleteCustomer(id){ // deletes a specific customer, only the Super Admin can make this request as the button is only visable for that user.
                if(confirm('Are you sure you want to delete this customer?')){
                    axios.delete('api/customers/' + id)
                    .then( response => {
                        this.getCustomers();
                        this.message("Customer has been successfully deleted!", 'success', 5000);
                    }).catch( error => {
                        throw new Error("Delete Customer Failed! " + error.message);
                        this.message("Sorry! Something went wrong when deleting your customer!", 'error', 10000);
                    });
                }else{
                    return;
                }
            },
            closeView(){
                this.resetValues();
                this.read = false;
            },
            /*
            * Regex methods for each of the feilds. Tried to tie all of this up into one function but
            * it was buggy and didn't work everytime. It worked a lot better when each field had
            * it's own regex check. 
            *
            * Each regex method has a empty string check because it would throw the error even if the
            * field was empty, so I added a check for emptiness and it would set the warning to an empty
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
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+$/;
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
                var pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+$/;
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
                for (var key in this.customer){
                    this.customer[key] = '';
                }
                this.edit = false;
                this.getCustomers();
                this.table = true;
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
    #customer-table { 
        max-height: 565px; 
        overflow: scroll; 
    }
</style>
 <template>
    <div>
        <i @click="instruction_1 = true" class="fa fa-question-circle fa-2x pointer" aria-hidden="true"></i>
        <transition name="fade">
            <div v-show="instruction_1" class="well">
                <i @click="instruction_1 = false" class="fa fa-times-circle pull-right fa-2x pointer"></i>
                <h3 class="text-center">Importing and Exporting Data</h3>
                <p>The Import / Export section is for creating backups of your data in either an excel format or a CSV format, both of which are readable by CSV programs such as 
                microsoft excel. When you want to create a backup of your data, click either of the export buttons and the file should automaticly download in your browser. When you want to import your data files back into the system, 
                choose them with the 'choose file' buttons. <strong>Make sure that the file you are importing is a file that belongs to it's appropriate section.</strong> If your importing your customer data, make sure 
                it is imported in the customers section. When exporting your data, make sure the exported files actually contain your data before performing any actions that would clear out your
                database.</p>
                <h4>Editting Exported Files</h4>
                <p>If your some reason you desire to edit you exported files. Please abide by these rules so that they may be importable later back into the system. </p>
                <ol>
                    <li>Stick to the same format the previous entries are in. As format changes can cause errors when importing back into the database.</li>
                    <li>Do not change the column names as they are utilized for placing the correct data back into the database.</li>
                    <li>If styleing is desired, apply minimal styleing as some styling may interrupt the importing process which may cause data lose.</li>
                    <li>And finally the most important rule is <strong>don't edit the document if you don't have to</strong> as this will allow for the most amount of success when importing back into the database.
                    These documents are meant to eventually go back into the system which means they should not be tampered with. </li>
                </ol>
            </div>
        </transition>
        <h2 class="text-center">Company Information</h2>
        <div class="well">
            <!-- Add your company info box with add button -->
            <div v-if="!companyAdded()">
                <p class="alert alert-success text-center">Please add your company info. <button class="btn btn-success btn-sm" @click="form = true">Add Company Info</button></p>
            </div>
            <!-- if company is added: Company Name with edit button -->
            <div v-if="companyAdded()">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <h2>{{ companyName }}</h2>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <button class="btn btn-default btn-sm full-width margin-top-20" v-show="!read" @click="toShow()"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <button class="btn btn-warning btn-sm full-width margin-top-20" v-show="!edit" @click="toEdit()"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button>
                    </div>
                </div>
            </div>
            <!-- Messages -->
            <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
            <SuccessMessage :successMes="successMessage"></SuccessMessage>
            <!-- End of Messages -->
            <!-- Add Company Form -->
            <div v-if="form">
                <h2 class="text-center">Add Company</h2>
                <form action="#" @submit.prevent="edit ? updateCompany(company.id) : createCompany()">
                <p class="alert alert-danger" v-if="regWarning">{{ regWarning }}</p>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="company.name" type="text" name="name" class="form-control" required maxlength="50">
                                <p class="alert alert-warning" v-if="company.name.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="inv_prefix">Invoice Prefix Number</label>
                                <input v-model="company.inv_prefix" class="form-control" type="text" name="inv_prefix" required maxlength="15">
                                <p class="alert alert-warning" v-if="company.inv_prefix.length == 15">15 character limit reached!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea v-model="company.address" name="address" class="form-control" maxlength="255"></textarea>
                                <p class="alert alert-warning" v-if="company.address.length == 255">255 character limit reached!</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea v-model="company.desc" name="desc" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input v-model="company.phone" type="text" name="phone" class="form-control" maxlength="25">
                                <p class="alert alert-warning" v-if="company.phone.length == 25">25 character limit reached!</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="company.email" type="email" name="email" class="form-control" maxlength="50">
                                <p class="alert alert-warning" v-if="company.email.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="invoice_con">Invoice Document Control Number</label>
                                <input v-model="company.invoice_con" type="text" name="invoice_con" class="form-control" maxlength="50">
                                <p class="alert alert-warning" v-if="company.invoice_con.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="shipper_con">Shipper Document Control Number</label>
                                <input v-model="company.shipper_con" type="text" name="shipper_con" class="form-control" maxlength="50">
                                <p class="alert alert-warning" v-if="company.shipper_con.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="router_con">Router Document Control Number</label>
                                <input v-model="company.router_con" type="text" name="router_con" class="form-control" maxlength="50">
                                <p class="alert alert-warning" v-if="company.router_con.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="po_con">Purchase Order Document Control Number</label>
                                <input v-model="company.po_con" type="text" name="po_con" class="form-control" maxlength="50">
                                <p class="alert alert-warning" v-if="company.po_con.length == 50">50 character limit reached!</p>
                            </div>
                        </div>
                    </div>
                    <SubmitBtns :editMode="edit" :name="name='Company'"></SubmitBtns>
                </form>
            </div>
            <!-- End of add product form -->
        </div>
        <transition name="fade">
            <div v-show="read" class="well">
                <h2 class="lg-font">{{ company.name }}</h2>
                <strong class="mid-font">Address: </strong><span>{{ company.address }}</span><br>
                <strong class="mid-font">Phone: </strong><span>{{ company.phone }}</span><br>
                <strong class="mid-font">Email: </strong><span>{{ company.email }}</span><br>
                <strong class="mid-font">Description: </strong><span>{{ company.disc }}</span><br>
                <strong class="mid-font">Invoice Prefix Number: </strong><span>{{ company.inv_prefix }}</span><br>
                <strong class="mid-font">Invoice Document Controle Number: </strong><span>{{ company.invoice_con }}</span><br>
                <strong class="mid-font">Shipper Document Controle Number: </strong><span>{{ company.shipper_con }}</span><br>
                <strong class="mid-font">Router Document Controle Number: </strong><span>{{ company.router_con }}</span><br>
                <strong class="mid-font">Purchase Order Document Controle Number: </strong><span>{{ company.po_con }}</span><br>
                <button class="btn btn-danger full-width" @click="closeView()">Close Viewing</button>
            </div>
        </transition>
        <hr>
        <!-- Instruction Area -->
        <i @click="instruction_2 = true" class="fa fa-question-circle fa-2x pointer" aria-hidden="true"></i>
        <transition name="fade">
            <div v-show="instruction_2" class="well">
                <i @click="instruction_2 = false" class="fa fa-times-circle pull-right fa-2x pointer"></i>
                <h3 class="text-center">Company Information Form</h3>
                <p>Welcome to the settings area of the dataentry system! This is where you will add all of the needed company
                    information that will be used through out your system. This information is also used on your pdf templates
                    as well as your report forms.</p>
                <h4>Filling out the form</h4>
                <p>Filling out the form is simple but some of the information that is asked for may not apply to your specific needs.
                As a summery here are what each field is used for:</p>
                <ol>
                    <li><strong>Name: </strong> This is where you will put the name of your company as you would want it to appear on invoices, shippers
                    and reports.</li>
                    <li><strong>Invoice Prefix Number: </strong> This number, as it suggests, is placed as a prefix before all of your invoice numbers
                    which are automatically generated for you. Your invoice numbers start with your prefix here and end with 0000. The invoice numbers then
                    increment from there and will continue to increment until you update your prefix number. This is so you can have invoice numbers that are 
                    unique for every year, half a year, quarter of the year or however frequent your invoice numbers need to change. Each time you update your
                    prefix number, the invoice counter will reset to 0000.</li>
                    <li><strong>Address: </strong>This is where you put the address to your company. This address is used on both the shipper and the invoice and 
                    will appear as you write it here.</li>
                    <li><strong>Description: </strong>The description of your company goes here and it currently not used on any printable documents as far as the system goes.</li>
                    <li><strong>Phone: </strong>This is where you place the phone number of the company where you want your customers to reach you at. This number will be placed on 
                    both the shipper and the invoice.</li>
                    <li><strong>Email: </strong>This is where you place your company email address which will be placed on both the shipper and the invoice.</li>
                    <li><strong>Invoice Document Control Number: </strong>The document version controle number for the invoice document.</li>
                    <li><strong>Shipper Document Control Number: </strong>The document version controle number for the shipper document.</li>
                    <li><strong>Router Document Control Number: </strong>The document version controle number for the shipper document.</li>
                    <li><strong>Purchase Order Document Control Number: </strong>The document version controle number for the purchase order document.</li>
                </ol>
            </div>
        </transition>
        <hr>
        <div class="alert alert-warning">
            <h2 class="text-center">Refresh Assets Data</h2>
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>Caution</strong> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <p>These buttons will whipe your data completely! An exported CSV file will be provided just incase this was done in error. Just simply import 
                the file back into the system using the import area below. To make sure that no accedents are made, the refresh buttons have been hidden
                until the below math problem has been solved. Type in the correct answer and the refresh buttons will appear.</p>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label for="security">5 X 23 = </label>
                    <input v-model="security" type="text" name="security" class="form-control">
                </div>
            </div>
            <br>
            <transition name="fade">
                <div class="row" v-if="security == '115'">
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-warning btn-sm width-full" href="/customers/export/drop">Refresh Customers Data</a>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-warning btn-sm width-full" href="/products/export/drop">Refresh Products Data</a>
                    </div>
                </div>
            </transition>
        </div>
        <i @click="instruction_3 = true" class="fa fa-question-circle fa-2x pointer" aria-hidden="true"></i>
        <transition name="fade">
            <div v-show="instruction_3" class="well">
                <i @click="instruction_3 = false" class="fa fa-times-circle pull-right fa-2x pointer"></i>
                <h3 class="text-center">Refresh Assets Data</h3>
                <p>The Refresh data area is primarily for those situations where you want to clear out some of your assets data and get a new start.
                Once you've clicked any of the buttons to refresh your data, an Excel file will be provided just in case this was done in error. However, It is
                highly recommended that you first export a copy of your data in the import/export section below first just in case you want to reimport your data 
                back into your database as exporting data while removing it could have some issues.</p>
            </div>
        </transition>
    </div>
</template>

<script>
    // Imports
    import SubmitBtns from '../components/partials/submit-btn.vue';
    import ErrorMessage from '../components/partials/error-message.vue';
    import SuccessMessage from '../components/partials/success-message.vue';
    // Export
    export default {
        data() {
            return {
                edit: false,
                form: false,
                read: false,
                instruction_1: false,
                instruction_2: false,
                instruction_3: false,
                security: '',
                companyName: '',
                companyId: 0,
                company: {
                    id: '',
                    name: '',
                    address: '',
                    phone: '',
                    email: '',
                    desc: '',
                    invoice_con: '',
                    shipper_con: '',
                    router_con: '',
                    po_con: '',
                    inv_prefix: ''
                },
                regWarning: '',
                errorMessage: '',
                successMessage: '',
                user: ''
            }
        },
        mounted() {
            this.getUser();
            this.getCompany();
            this.companyAdded();
        },
        components: {
            SubmitBtns,
            ErrorMessage,
            SuccessMessage
        },
        methods: {
            getUser(){
                axios.get('api/user')
                .then((response) => {
                    this.user = response.data.permission;
                }).catch((error) => {
                    throw new Error("Was not able to find user.");
                });
            },
            toEdit(){
                this.form = true;
                this.edit = true;
                this.showCompany(this.companyId);
            },
            toShow(){
                this.read = true;
                this.showCompany(this.companyId);
            },
            closeView(){
                this.read = false;
                this.resetValues();
            },
            companyAdded(){
                if(this.companyName !== ''){
                    return true;
                }else {
                    return false;
                }
            },
            getCompany(){
                axios.get('api/company')
                .then((response) => {
                    this.companyName = response.data[0].name;
                    this.companyId = response.data[0].id;
                }).catch((error) => {
                    throw new Error("getCompany method failed!", error.message);
                    this.message("Sorry! Something went wrong when receiving your company info!", 'error', 10000);
                });
            },
            createCompany(){
                this.regexCheck();
                let params = Object.assign({}, this.company);
                axios({
                    method: 'post',
                    url: 'api/company/store',
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.resetValues();
                    this.message('Company Info Successfully Added!', 'success', 5000);
                }).catch((error) => {
                    throw new Error("createCompany method failed!", error.message);
                    this.message('Sorry! Something went wrong when adding your company info!', 'error' , 10000);
                });
            },
            updateCompany(id){
                this.regexCheck();
                let params = Object.assign({}, this.company);
                axios({
                    method: 'patch',
                    url: 'api/company/' + id,
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then(() => {
                    this.resetValues();
                    this.message('Company Info Successfully Updated!', 'success', 5000);
                }).catch((error) => {
                    throw new Error("updateCompany method failed!", error.message);
                    this.message("Sorry! Something went wrong when updating your company info!", 'error', 10000);
                });
            },
            showCompany(id){
                axios({
                    method: 'get',
                    url: 'api/company/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    for(var key in this.company){
                        for(var k in response.data){
                            if(key === k){
                                this.company[key] = response.data[k];
                            }
                        }
                    }
                }).catch((error) => {
                    throw new Error("showCompany method faile!", error.message);
                    this.message("Sorry! Something went wrong in receiving your company info!", 'error', 10000);
                });
                this.edit = true;
            },
            resetValues(){
                for(var key in this.company){
                    this.company[key] = '';
                }
                this.regWarning = '';
                this.form = false;
                this.edit = false;
                this.getCompany();
                this.companyAdded();
            },
            regexCheck(){
                var arr = [this.company.invoice_con, this.company.shipper_con, this.company.router_con, this.company.po_con],
                    pattern = /^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+$/i;
                var newArr = arr.filter(function(val){
                    return pattern.test(val) === false;
                });
                if(newArr.length > 0){
                    this.regWarning = "Unapproved characters detected with the control numbers! List of approved characters: a-z, A-Z, 0-9, '()-/&*#\"' commas and periods. However, '--' is not allowed. Current values rejected: "; 
                    for(var i = 0; i < newArr.length; i++){
                        this.regWarning += "'"+newArr[i]+"'    ";
                    }
                    throw new Error("Unapproved characters rejected by the client.");
                } else {
                    this.regWarning = '';
                }
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
    .width-full {
        width: 100%;
    }
</style>
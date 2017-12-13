 <template>
    <div>
        <!-- Add your company info box with add button -->
        <div v-if="!companyAdded()">
            <p class="alert alert-success text-center">Please add your company info. <button class="btn btn-success btn-sm" @click="form = true">Add Company Info</button></p>
        </div>
        <!-- if company is added: Company Name with edit button -->
        <div v-if="companyAdded()">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <h2>{{ companyName }}</h2>
                </div>
                <div class="col-sm-12 col-md-4">
                    <button class="btn btn-primary btn-sm full-width margin-top-20" v-show="!edit" @click="toEdit()"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button>
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
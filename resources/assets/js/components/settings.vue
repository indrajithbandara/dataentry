<template>
    <div>
        <!-- Add your company info box with add button -->
        <div v-if="!companyAdded()">
            <p class="alert alert-success text-center">Add your company info here. <button class="btn btn-success btn-sm" @click="form = true">Add Company Info</button></p>
        </div>
        <!-- if company is added: Company Name with edit button -->
        <div v-if="companyAdded()">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <h2>{{ companyName }}</h2>
                </div>
                <div class="col-sm-12 col-md-4">
                    <button class="btn btn-primary margin-top-20" @click="toEdit()">Update</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="alert alert-info text-center">You currently have no company information!</p>
        </div>

        <errorMessage :errorMes="errorMessage"></errorMessage>
        <!-- Add Company Form -->
        <div v-if="form">
            <h2 class="text-center">Add Company</h2>
            <form action="#" @submit.prevent="edit ? updateCompany(company.id) : createCompany()">
            <p class="alert alert-danger" v-if="regWarning">{{ regWarning }}</p>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="company.name" type="text" name="name" class="form-control" required maxlength="50">
                    <p class="alert alert-warning" v-if="company.name.length == 50">50 character limit reached!</p>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input v-model="company.address" type="text" name="address" class="form-control" maxlength="255">
                            <p class="alert alert-warning" v-if="company.address.length == 255">255 character limit reached!</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <input v-model="company.desc" type="text" name="desc" class="form-control">
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
                            <label for="fax">Fax</label>
                            <input v-model="company.fax" type="text" name="fax" class="form-control" maxlength="25">
                            <p class="alert alert-warning" v-if="company.fax.length == 25">25 character limit reached!</p>
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
                <submitBtns :editMode="edit" :name="name='Company'"></submitBtns>
            </form>
        </div>
        <!-- End of add product form -->
    </div>
</template>

<script>
    // Imports
    import SubmitBtns from '../components/partials/submit-btn.vue';
    import ErrorMessage from '../components/partials/error-message.vue';
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
                    fax: '',
                    desc: '',
                    invoice_con: '',
                    shipper_con: '',
                    router_con: '',
                    po_con: ''
                },
                regWarning: '',
                errorMessage: '',
                user: ''
            }
        },
        mounted() {
            this.getUser();
            this.getCompany();
            this.companyAdded();
        },
        components: {
            submitBtns: SubmitBtns,
            errorMessage: ErrorMessage
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
                    this.errorHandeler(error);
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
                }).catch((error) => {
                    this.errorHandeler(error);
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
                }).catch((error) => {
                    this.errorHandeler(error);
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
                    this.errorHandeler(error);
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
                // var arr = [this.product.name, this.product.description, this.product.material],
                //     pattern = /^$|^(?!-)(?!.*--)[A-Za-z0-9\-\.\,\s]+$/;
                // var newArr = arr.filter(function(val){
                //     return pattern.test(val) === false;
                // });
                // if(newArr.length > 0){
                //     this.regWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, highens, commas and periods. However, '--' is not allowed. Current values rejected: "; 
                //     for(var i = 0; i < newArr.length; i++){
                //         this.regWarning += "'"+newArr[i]+"'    ";
                //     }
                //     throw new Error("Unapproved characters rejected by the client.");
                // } else {
                //     this.regWarning = '';
                // }
            },
            errorHandeler(error){
                if(error.response){
                    //Errors with messages
                    if(error.response.status === 401){
                        this.errorMessage = "Sorry! You are not authorized. " + error.response.status + ": " + error.response.statusText;
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')' + ": authorization needed."); 
                    } else if(error.response.status === 403){
                        this.errorMessage = "Sorry! You are not permitted to make this action. " + error.response.status + ": " + error.response.statusText;
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')' + ": permission needed to make this action."); 
                    } else if(error.response.status === 404){
                        this.errorMessage = "Sorry! Something went wrong. " + error.response.status + ": " + error.response.statusText;
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')' + ": url endpoint not found.");
                    } else if(error.response.status === 422){
                        this.errorMessage = "Unapproved input values rejected by the server. " + error.response.status + ": " + error.response.statusText;
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')' + ": Unprocessable Entities Detected.");     
                    } else if(error.response.status === 500){
                        this.errorMessage = "Sorry! Something went wrong on the server. " + error.response.status + ": " + error.response.statusText;
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')' + ": something went wrong on the server.");
                    } else {
                        throw new Error(error.response.status + ' (' + error.response.statusText + ')');
                    }
                } else if(error.message){
                    throw new Error('Error: ', error.message);
                }
            }
        }
    }
</script>
<template>
    <div>
        <!-- Products Table -->
        <div id="product-table" v-if="list.length > 0" class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Material</th>
                        <th>Revision</th>
                        <th>Rev Date</th>
                        <th>Edit</th>
                        <th v-if="user == 1">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in list">
                        <td>{{ product.name }}</td>
                        <td>{{ product.description }}</td>
                        <td v-if="product.material.length > 10" v-bind:title="product.material">{{ product.material.substring(0, 10) + '...' }}</td>
                        <td v-else>{{ product.material }}</td>
                        <td>{{ product.rev }}</td>
                        <td>{{ product.rev_date }}</td>
                        <td><button @click="showProduct(product.id)" class="btn btn-warning">Edit</button></td>
                        <td v-if="user == 1"><button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else> 
            <p class="alert alert-info text-center">You currently have no products to show.</p>
        </div>
        <!-- end of products table -->
        <hr>
        <errorMessage :errorMes="errorMessage"></errorMessage>
        <!-- Add product Form -->
        <div>
            <h2 class="text-center">Add Product</h2>
            <form action="#" @submit.prevent="edit ? updateProduct(product.id) : createProduct()">
            <p class="alert alert-danger" v-if="regWarning">{{ regWarning }}</p>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input v-model="product.name" @keyup="checkName()" type="text" name="name" class="form-control" required maxlength="25">
                            <p class="alert alert-warning" v-if="product.name.length == 25">25 character limit reached!</p>
                            <p class="alert alert-warning" v-if="nameAlert">{{ nameAlert }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input v-model="product.description" type="text" name="description" class="form-control" maxlength="25">
                            <p class="alert alert-warning" v-if="product.description.length == 25">25 character limit reached!</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="material">Material</label>
                    <input v-model="product.material" type="text" name="material" class="form-control" maxlength="70">
                    <p class="alert alert-warning" v-if="product.material.length == 70">70 character limit reached!</p>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="rev">Revision</label>
                            <input v-model="product.rev" type="text" name="rev" class="form-control" maxlength="3">
                            <p class="alert alert-warning" v-if="product.rev.length == 3">3 character limit reached!</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="rev_date">Revision Date</label>
                            <input v-model="product.rev_date" type="date" name="rev_date" class="form-control">
                        </div>
                    </div>
                </div>
                <submitBtns :editMode="edit" :name="name='Product'"></submitBtns>
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
                product: {
                    id: '',
                    name: '',
                    description: '',
                    material: '',
                    rev: '',
                    rev_date: ''
                },
                regWarning: '',
                nameAlert: '',
                errorMessage: ''
            }
        },
        mounted() {
            this.getProducts();
            this.getUser();
        },
        components: {
            submitBtns: SubmitBtns,
            errorMessage: ErrorMessage
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            },
            list() {
                return this.$store.getters.getProducts;
            }
        },
        methods: {
            getUser(){
                this.$store.dispatch('commitPermission');
            },
            getProducts(){
                this.$store.dispatch('commitProducts');
            },
            createProduct(){
                this.noDuplicateNames();
                this.regexCheck();
                if(!this.product.description){this.product.description = 'NA';}
                if(!this.product.material){this.product.material = 'NA';}
                if(!this.product.rev){this.product.rev = 'NA';}
                let params = Object.assign({}, this.product);
                axios({
                    method: 'post',
                    url: 'api/products/store',
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
            updateProduct(id){
                this.regexCheck();
                if(!this.product.description){this.product.description = 'NA';}
                if(!this.product.material){this.product.material = 'NA';}
                if(!this.product.rev){this.product.rev = 'NA';}
                let params = Object.assign({}, this.product);
                axios({
                    method: 'patch',
                    url: 'api/products/' + id,
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
            showProduct(id){
                axios({
                    method: 'get',
                    url: 'api/products/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    for(var key in this.product){
                        for(var k in response.data){
                            if(key === k){
                                this.product[key] = response.data[k];
                            }
                        }
                    }
                }).catch((error) => {
                    this.errorHandeler(error);
                });
                this.edit = true;
            },
            deleteProduct(id){
                if(confirm('Are you sure you want to delete this product?')){
                    axios.delete('api/products/' + id)
                    .then((response) => {
                        this.getProducts();
                    }).catch((error) => {
                        this.errorHandeler(error);
                    });
                }else{
                    return;
                }
            },
            resetValues(){
                for(var key in this.product){
                    this.product[key] = '';
                }
                this.regWarning = '';
                this.nameAlert = '';
                this.edit = false;
                this.getProducts();
            },
            regexCheck(){
                var arr = [this.product.name, this.product.description, this.product.material],
                    pattern = /^$|^(?!-)(?!.*--)[A-Za-z0-9\-\.\,\s]+$/;
                var newArr = arr.filter(function(val){
                    return pattern.test(val) === false;
                });
                if(newArr.length > 0){
                    this.regWarning = "Unapproved characters detected! List of approved characters: a-z, A-Z, 0-9, highens, commas and periods. However, '--' is not allowed. Current values rejected: "; 
                    for(var i = 0; i < newArr.length; i++){
                        this.regWarning += "'"+newArr[i]+"'    ";
                    }
                    throw new Error("Unapproved characters rejected by the client.");
                } else {
                    this.regWarning = '';
                }
            },
            checkName(){
                var self = this;
                var nameTaken = self.list.some(function(val){
                    return self.product.name === val.name;
                });
                if(nameTaken){
                    self.nameAlert = 'This name has already been taken.';
                }else{
                    self.nameAlert = '';
                }
            },
            noDuplicateNames(){
                var self = this;
                self.list.forEach(function(arrayItem){
                    var x = arrayItem;
                    if(self.product.name == x.name){
                        alert('This product name has already been taken. Please choose a different one to avoid duplicate information.');
                        throw new Error("This product name already exisits. Server rejects duplicate values.");
                    }
                });
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
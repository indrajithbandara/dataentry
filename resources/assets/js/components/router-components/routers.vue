<template>
    <div>
        <h1 class="text-center">Routers</h1>
        <hr>
        <ViewAddBtns
            :textOne="'View Routers'" 
            :textTwo="'Add Router'" 
            :toTable="switchToTable" 
            :toForm="switchToForm"
        ></ViewAddBtns>
        <hr>
        <!-- Error and Success Messages -->
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- table_routers = true  -->
        <!-- Start of Routers Table -->
        <div v-show="table">
            <div id="routers-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Router #</th>
                            <th>Part #</th>
                            <th>Status</th>
                            <th>Po #</th>
                            <th>Customer</th>
                            <th>Qty</th>
                            <th>Date</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="router in list">
                            <td>{{ router.router_num }}</td>
                            <td>{{ router.part_num }}</td>
                            <td v-if="router.status == 'NIP'" class="nip-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'IP'" class="ip-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'II'" class="ii-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'A'" class="a-item text-center">{{ router.status }}</td>
                            <td>{{ router.po_num }}</td>
                            <td>{{ router.customer }}</td>
                            <td>{{ router.qty }}</td>
                            <td>{{ router.date }}</td>
                            <td><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></td>
                            <td><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                            <td><button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no routers to show.</p>
            </div>
        </div>
        <!-- end of Routers table -->
        <hr v-if="!edit && table">
        <div v-if="!edit && table">
            <hr class="dashed">
            <h2 class="text-center">Search</h2>
            <div class="row">
                <!-- Start of Search By Router Number -->
                <div v-if="!edit && table" class="col-xs-12 col-lg-4">
                    <form action="#" @submit.prevent="">
                        <div class="row">
                            <div class="col-xs-8 col-sm-8">
                                <div class="form-group">
                                    <input v-model="search_router" type="text" name="search" class="form-control" placeholder="Router Number">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                    <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button @click="cancelSearch" v-show="search" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
                </div>
                <!-- End of Search By Router Number -->
                <!-- Start of Search By Part Number -->
                <div v-if="!edit && table" class="col-xs-12 col-lg-4">
                    <form action="#" @submit.prevent="">
                        <div class="row">
                            <div class="col-xs-8 col-sm-8">
                                <div class="form-group">
                                    <input v-model="search_pn_num" type="text" name="search" class="form-control" placeholder="Part Number">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                    <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button @click="cancelSearchPn" v-show="search_pn" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
                </div>
                <!-- End of Search By Part Number -->
                <!-- Start of Search By Status -->
                <div v-if="!edit && table" class="col-xs-12 col-lg-4">
                    <form action="#" @submit.prevent="">
                        <div class="row">
                            <div class="col-xs-8 col-sm-8">
                                <div class="form-group">
                                    <select v-model="search_status" class="form-control">
                                        <option>By Status</option>
                                        <option v-for="item in selectList" :value="item.value">{{ item.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <div class="form-group">
                                    <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button @click="cancelSearchStatus" v-show="search_status_mode" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
                </div>
                <!-- End of Search By Status -->
            </div>
        </div>
        <hr v-if="!edit && table">
        <!-- Start of Viewing Area -->
        <div v-show="read && !edit">
            <transition name="fade">
                <div class="well">
                    <h2 class="lg-font underline">Router #: 1002</h2>
                    <strong class="mid-font">Part Number: <span>620-1-200</span></strong><br>
                    <strong class="mid-font">Router Status: <span>NIP</span></strong><br>
                    <strong class="mid-font">Purchase Order: <span>20983948</span></strong><br>
                    <strong class="mid-font">Customer: <span>Eaton</span></strong><br>
                    <strong class="mid-font">Qty: <span>150</span></strong><br>
                    <strong class="mid-font">Date: <span>1-15-2018</span></strong><br>
                    <button class="btn btn-danger full-width">Close Viewing</button>
                </div>
            </transition>
        </div>
        <!-- End of Viewing Area -->
        <!-- Start Routers Form -->
        <div v-show="!table">
            <h2 class="text-center">Router Details</h2>
            <form action="#" @submit.prevent="">
                <NumberForm :forVal="'router_num'" :inputName="'Router Number'" :inputClass="'form-control'"></NumberForm>
                <TextForm :forVal="'part_num'" :inputName="'Part Number'" :inputClass="'form-control'"></TextForm>
                <SelectForm :inputName="'Router Status'" :inputClass="'form-control'" :list="selectList"></SelectForm>
                <TextForm :forVal="'po_num'" :inputName="'Purchase Order'" :inputClass="'form-control'"></TextForm>
                <TextForm :forVal="'customer'" :inputName="'Customer'" :inputClass="'form-control'"></TextForm>
                <NumberForm :forVal="'qty'" :inputName="'Qty'":inputClass="'form-control'"></NumberForm>
                <DateForm :forVal="'date'" :inputName="'Date'" :inputClass="'form-control'"></DateForm>
                <SubmitBtn :editMode="edit" :name="'Router'"></SubmitBtn>
            </form>
        </div>
        <!-- End Routers Form -->
        <!-- Start of Report Area -->
        <div v-if="!edit && table">
            <hr class="dashed">
            <h2 class="text-center">Report</h2>
            <form action="#" @submit.prevent="" class="space-below">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="start">Start Date</label>
                            <input v-model="start" type="date" name="start" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="end">End Date</label>
                            <input v-model="end" type="date" name="end" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="form-group">
                            <label for="rep_name">Report Name</label>
                            <input v-model="rep_name" type="text" name="rep_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <button class="btn btn-default full-width btn-margin" type="submit" name="dateSearchBtn"><i class="fa fa-file-text" aria-hidden="true"></i> Get Report</button>
                    </div>
                </div>
            </form>
            <a v-show="report" :href="'pdf/report/router/'+start+'/'+end+'/'+rep_name" class="btn btn-primary wide"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a>
        </div>
        <!-- End of Report Area -->
    </div>
</template>
<script>
    import SelectForm from '../../components/partials/form-select.vue';
    import TextForm from '../../components/partials/form-text.vue';
    import NumberForm from '../../components/partials/form-number.vue';
    import DateForm from '../../components/partials/form-date.vue';
    import ErrorMessage from '../../components/partials/error-message.vue';
    import SuccessMessage from '../../components/partials/success-message.vue';
    import SubmitBtn from '../../components/partials/submit-btn.vue';
    import ViewAddBtns from '../../components/partials/view-add-btns.vue';
    export default {
        data(){
            return {
                list: [
                    { router_num: 1001, part_num: '620-1-200', po_num: '88596', customer: 'Eaton', qty: 150, status: 'A', date: '2018-01-12' },
                    { router_num: 1002, part_num: '620-1-450', po_num: '88597', customer: 'Boing', qty: 50, status: 'II', date: '2018-01-12' },
                    { router_num: 1003, part_num: '620-1-600', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13' },
                    { router_num: 1004, part_num: '620-5-200', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14' },
                    { router_num: 1005, part_num: '620-5-600', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14' },
                ],
                // Modes
                table: true,
                edit: false,
                read: false,
                search: false,
                search_pn: false,
                search_status_mode: false,
                report: false,
                // Messages
                errorMessage: '',
                successMessage: '',
                // Data
                search_router: '',
                search_pn_num: '',
                search_status: 'By Status',
                start: '',
                end: '',
                rep_name: '',
                selectList: [
                    { name: 'Not In Production', value: 'NIP' },
                    { name: 'In Production', value: 'IP' },
                    { name: 'In Inventory', value: 'II' },
                    { name: 'Archive', value: 'A' },
                ],
            }
        },
        mounted() {

        },
        components: {
            SelectForm,
            TextForm,
            NumberForm,
            DateForm,
            ErrorMessage,
            SuccessMessage,
            SubmitBtn,
            ViewAddBtns
        },
        computed: {

        },
        methods: {
            switchToTable() {
                this.table = true;
            },
            switchToForm() {
                this.table = false;
                this.read = false;
            },
            cancelSearch() {
                this.search = false;
            },
            cancelSearchPn() {
                this.search_pn = false;
            },
            cancelSearchStatus() {
                this.search_status_mode = false;
            }
        }
    }
</script>
<style scoped>
    #routers-table { 
        max-height: 565px; 
        overflow: scroll; 
    }
    .nip-item {
        background: #af366c;
        color: #fff;
    }
    .ip-item {
        background: #208ca4;
        color: #fff;
    }
    .ii-item {
        background: #29a77a;
        color: #fff;
    }
    .a-item {
        background: #423939;
        color: #fff;
    }
    .cust_top_margin {
        margin-top: 32px;
    }
    .btn-margin {
        margin-top: 27px;
    }
    .space-below {
        margin-bottom: 20px;
    }
    .wide {
        width: 100%;
    }
    @media(max-width:1345px){
        .fa-search {
            display: none;
        }
    }
</style>
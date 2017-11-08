<template>
    <div>
        <ViewAddBtns 
            :textOne="'View Invoices'" 
            :textTwo="'Add An Invoice'"
            :toTable="switchToTable" 
            :toForm="switchToForm"
        ></ViewAddBtns>
        <hr>
        <!-- Start of Invoice Table -->
        <div v-show="table">
            <!-- Invoices Table -->
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
                            <td>{{ invoice.customer.name }}</td>
                            <td>{{ invoice.total }}</td>
                            <td><a :href="'/pdf/shipper/' + invoice.id" class="btn btn-default">Print Shipper</a></td>
                            <td><a :href="'/pdf/invoice/' + invoice.id" class="btn btn-primary">Print Invoice</a></td>
                            <td><button @click="showInvoice(invoice.id)" class="btn btn-warning">Edit</button></td>
                            <td v-if="user == 1"><button @click="deleteInvoice(invoice.id)" class="btn btn-danger">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no invoices to show.</p>
            </div>
            <!-- end of Invoices table -->
        </div>
        <!-- End of Invoice Table -->
        <hr>
        <!-- Add An Invoice Form -->
        <div v-show="!table">
            <h2 class="text-center">Invoice Details</h2>
            <form action="#" @submit.prevent="edit ? updateInvoice(invoiceObj.id) : createInvoice()">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <NumberForm
                            :dataModel="invoiceObj.inv_num" 
                            :forVal="'inv_num'" 
                            :inputName="'Invoice #'" 
                            :inputClass="'form-control'" 
                            :max="11" 
                            :update="updateInvNum"
                        ></NumberForm>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input :value="invoiceObj.date" @blur="updateDate" type="date" name="date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <select v-model="cust_id" @blur="setCustomerInfo(cust_id)" number class="form-control">
                                <option>Choose An Item</option>
                                <option v-for="customer in customers" >{{ customer.id }} - {{ customer.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h4 class="cust_top_margin"><strong>Customer:</strong> {{ invoiceObj.customer.name }}</h4>
                    </div>
                </div>

                <TextForm 
                    :dataModel="invoiceObj.po_num" 
                    :inputName="'P.O #'" 
                    :forVal="'po_num'" 
                    :inputClass="'form-control'" 
                    :max="30" 
                    :update="updatePo"
                ></TextForm>

                <!-- Add and Removing Line Item Buttons -->
                <button class="btn btn-success full-width" @click="li_btn_show_hide(1, 'show')" type="button" v-show="btn[0].button">Add A Second Line Item</button>
                <LnBtns :numOne="2" :btnNum="btn[1].button" :liShowHide="li_btn_show_hide" :disabled="false"></LnBtns>
                <LnBtns :numOne="3" :btnNum="btn[2].button" :liShowHide="li_btn_show_hide" :disabled="false"></LnBtns>
                <LnBtns :numOne="4" :btnNum="btn[3].button" :liShowHide="li_btn_show_hide" :disabled="false"></LnBtns>
                <LnBtns :numOne="5" :btnNum="btn[4].button" :liShowHide="li_btn_show_hide" :disabled="false"></LnBtns>
                <LnBtns :numOne="6" :btnNum="btn[5].button" :liShowHide="li_btn_show_hide" :disabled="false"></LnBtns>
                <LnBtns :numOne="7" :btnNum="btn[6].button" :liShowHide="li_btn_show_hide" :disabled="true"></LnBtns>
                <!-- End of Adding and Removing Line Item Buttons -->

                <hr class="dashed">

                <!-- ============================================ Line Items ============================================ -->
                <div ref="ln_container" class="overflow-scroll padding radius">
                    <!-- =============== Line Item One ================= -->
                    <div id="line_item_one">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="0" :header="'Line Item One'"
                            :forValLi="'li_one'" :forValQty="'qty_one'" 
                            :forValUnit="'unit_one'" :forValExt="'extended_one'" 
                        ></LineItem>
                    </div>

                    <div id="line_item_two" v-if="ln[1].line">
                        <!-- ============== Line Item Two ============== -->
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="1" :header="'Line Item Two'"
                            :forValLi="'li_two'" :forValQty="'qty_two'" 
                            :forValUnit="'unit_two'" :forValExt="'extended_two'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Two ============== -->

                        <!-- ============== Line Item Three ============== -->
                    <div id="line_item_three" v-if="ln[2].line">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="2" :header="'Line Item Three'"
                            :forValLi="'li_three'" :forValQty="'qty_three'" 
                            :forValUnit="'unit_three'" :forValExt="'extended_three'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Three ============== -->

                        <!-- ============== Line Item Four ============== -->
                    <div id="line_item_four" v-if="ln[3].line">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="3" :header="'Line Item Four'"
                            :forValLi="'li_four'" :forValQty="'qty_four'" 
                            :forValUnit="'unit_four'" :forValExt="'extended_four'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Four ============== -->

                        <!-- ============== Line Item five ============== -->
                    <div id="line_item_five" v-if="ln[4].line">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="4" :header="'Line Item Five'"
                            :forValLi="'li_five'" :forValQty="'qty_five'" 
                            :forValUnit="'unit_five'" :forValExt="'extended_five'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Five ============== -->

                        <!-- ============== Line Item Six ============== -->
                    <div id="line_item_six" v-if="ln[5].line">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="5" :header="'Line Item Six'"
                            :forValLi="'li_six'" :forValQty="'qty_six'" 
                            :forValUnit="'unit_six'" :forValExt="'extended_six'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Six ============== -->

                        <!-- ============== Line Item Seven ============== -->
                    <div id="line_item_seven" v-if="ln[6].line">
                        <LineItem
                            :model="invoiceObj" :products="products" :itemNum="6" :header="'Line Item Seven'"
                            :forValLi="'li_seven'" :forValQty="'qty_seven'" 
                            :forValUnit="'unit_seven'" :forValExt="'extended_seven'" 
                        ></LineItem>
                    </div>
                        <!-- ============== End of Line Item Seven ============== -->
                </div>
                <!-- ========================================= End of Line Items ======================================= -->

                <hr class="dashed">

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <NumberFormFee
                            :dataModel="invoiceObj.ship_fee" 
                            :forVal="'ship_fee'" 
                            :inputName="'Shipping Fee'" 
                            :inputClass="'form-control'"
                            :update="updateShip"
                        ></NumberFormFee>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <NumberFormFee
                            :dataModel="invoiceObj.misc_char" 
                            :forVal="'misc_char'" 
                            :inputName="'Misc. Charges'" 
                            :inputClass="'form-control'"
                            :update="updateMisc"
                        ></NumberFormFee>
                    </div>
                </div>

                <div class="pull-right">
                    <h3>Total: ${{ invoiceObj.total }}</h3>
                </div>

                <div class="clearfix"></div>

                <TextForm 
                    :dataModel="invoiceObj.carrier" 
                    :inputName="'Carrier'" 
                    :forVal="'carrier'" 
                    :inputClass="'form-control'" 
                    :max="50" 
                    :update="updateCarrier" 
                ></TextForm>

                <div class="form-group">
                    <label>Order Complete</label>
                    <select :value="invoiceObj.complete" @blur="updateComplete" class="form-control">
                        <option>Choose An Option</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <TextAreaForm 
                    :dataModel="invoiceObj.memo" 
                    :inputName="'Memo'" 
                    :forVal="'memo'" 
                    :inputClass="'form-control'" 
                    :rows="3" 
                    :max="255" 
                    :update="updateMemo"
                ></TextAreaForm>

                <SubmitBtns :editMode="edit" :name="name='Invoice'"></SubmitBtns>
            </form>
        </div>
        <!-- End of Invoice Form -->
        <hr class="dashed">
        <div>
            <h2 class="text-center">Search</h2>
            <form action="#" @submit.prevent="dateRangeSearch()">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label for="start">Start Date</label>
                            <input type="date" name="start" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label for="end">End Date</label>
                            <input type="date" name="end" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <button class="btn btn-primary full-width btn-margin" type="submit" name="dateSearchBtn">Get Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    // Imports
    import ViewAddBtns from '../components/partials/view-add-btns.vue';
    import LnBtns from '../components/partials/ln-btns.vue';
    import SubmitBtns from '../components/partials/submit-btn.vue';
    import TextForm from '../components/partials/form-text.vue';
    import TextAreaForm from '../components/partials/form-textarea.vue';
    import NumberForm from '../components/partials/form-number.vue';
    import NumberFormFee from '../components/partials/form-number-fee.vue';
    import LineItem from '../components/partials/line-item.vue';
    // Export
    export default {
        data() {
            return {
                cust_id: '',
                /*
                * EDIT MODE:
                * if edit = false, the invoice form is hidden and the invoice table is displayed.
                * if edit = true, the invoice form is displayed, the invoice table is hidden and the submit button for the updateInvoice method is displayed.
                * Triggers: Edit buttons on the invoices table.
                * Methods Involved: showInvoice() | resetValues()
                */
                edit: false, 
                /*
                * INVOICE TABLE AND ADDING AN INVOICE:
                *
                * if table = true, the invoice table is displayed and the invoice form is hidden.
                * if table = false, the invoice table is hidden and the invoice form is displayed for adding an invoice.
                * Triggers: 'View Invoice' and 'Add An Invoice' buttons 
                * Methods Involved: showInvoice() | resetValues()
                */
                table: true, 
                /*
                * LINE ITEM FORMS AND LINE IIEM BUTTONS:
                *
                * ln[i].line is meant for hidding and showing the seven different line item forms.
                * if ln[i].line = true, the form is displayed.
                * if ln[i].line = false, the form is hidden.
                *
                * btn[i].button is meant for hidding and showing the seven different button containers for hidding and show the seven different line item forms
                * if btn[i].button = true, the button container is displayed
                * if btn[i].button = false, the button container is hidden
                *
                * The reason for using arrays of objects is so that these values can be looped over for when an invoice is brought in through an ajax call and the
                * proper buttons and line items need to be showing based on the information provided about the lines items. See 'setLineItems' method for more explination.
                *
                * Methods Involved: li_btn_show_hide() | setLineItems()
                */
                ln: [{line: true}, {line: false}, {line: false}, {line: false}, {line: false}, {line: false}, {line: false}], // array of 7 objects
                btn: [{button: true}, {button: false}, {button: false}, {button: false}, {button: false}, {button: false}, {button: false}], // array of 7 objects
            }
        },
        mounted() { 
            /*
            * When Vue instance is mounted:
            * 1.) Get current user in order to validate there permission level
            * 2.) Get all invoices to display onto the invoices table
            * 3.) Get all customers to have for customer dropdown
            * 4.) Get all products to have for product dropdowns
            */
            this.getUser();
            this.getInvoices();
            this.getCustomers();
            this.getProducts();
        },
        components: {
            ViewAddBtns, 
            LnBtns,
            SubmitBtns,
            TextForm,
            TextAreaForm,
            NumberForm,
            NumberFormFee,
            LineItem
        },
        computed: {
            // GETTERS
            user() { return this.$store.getters.getUser; },
            products() { return this.$store.getters.getProducts; },
            customers() { return this.$store.getters.getCustomers; },
            list() { return this.$store.getters.getInvoices; },
            invoiceObj() { return this.$store.state.invoices.invoice; }
        },
        methods: {
            // MUTATIONS
            updateInvNum(e) { this.$store.commit('updateInvNum', e.target.value); },
            updateDate(e) { this.$store.commit('updateDate', e.target.value); },
            updatePo(e) { this.$store.commit('updatePo', e.target.value); },
            updateShip(e) { this.$store.commit('updateShipFee', e.target.value); },
            updateMisc(e) { this.$store.commit('updateMiscChar', e.target.value); },
            updateComplete(e) { this.$store.commit('updateComplete', e.target.value); },
            updateCarrier(e) { this.$store.commit('updateCarrier', e.target.value); },
            updateMemo(e) { this.$store.commit('updateMemo', e.target.value); },
            // ACTIONS
            getUser() { this.$store.dispatch('commitPermission'); },
            getCustomers(){ this.$store.dispatch('commitCustomers'); },
            getProducts(){ this.$store.dispatch('commitProducts'); },
            getInvoices(){ this.$store.dispatch('commitInvoices'); },
            setCustomerInfo(id) { this.$store.dispatch('commitOneCustomer', id); },
            // METHODS
            dateRangeSearch() {
                this.$store.dispatch('dateRangeSearch')
                .then(() => {
                    this.getInvoices();
                })
                .catch((error) => {
                    throw new Error("Something went wrong with the date search." + error);
                });
            },
            switchToTable(){ // prop: toTable | component: <viewAddBtns>
                this.table = true;
            },
            switchToForm(){ // prop: toForm | component: <viewAddBtns>
                this.table = false;
            },
            /*
            * SHOWING AND HIDING BUTTONS AND LINE ITEMS AS WELL AS SCROLLING THE CONTAINER TO THE BOTTOM
            * Params: 1.) Number from 1-7,
            *         2.) String 'hide' or 'show'
            *
            * - li_btn_show_hide with the 'show' action word is meant for showing the next button and line item on the DOM while hiding the button that was just clicked. 
            *
            * - li_btn_show_hide with the 'hide' action word is meant for hiding the most recent button and line item added while showing the previous butten that was hidden again. 
            *   Each time the one of these buttons is clicked, the resetLineItem() and setTotal() methods are fired in order to reset the values of the 
            *   now hidden line item as well as re-calculate the total of the invoice. 
            *   ****** IMPORTANT NOTE *******
            * - Even though line items are hidden from site on the page, there values are still calculated from the invoice model. These line items
            *   themselves are no longer on the DOM but the model still remains available for calcultion. 
            */
            li_btn_show_hide(num, action){
                if(action === 'hide'){
                    var actOne = true;
                    var actTwo = false;
                }else if(action === 'show'){
                    var actOne = false;
                    var actTwo = true;
                }else{
                    throw new Error("li_btn_show_hide requires one of two optional actions words: 'hide' or 'show'");
                }
                switch(num){
                    case 1:
                        this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    case 2:
                         this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    case 3:
                        this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    case 4:
                        this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    case 5:
                        this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    case 6:
                        this.btn[num-1].button = actOne; this.btn[num].button = actTwo; this.ln[num].line = actTwo;
                    break;
                    default:
                        throw new Error('Sorry, Something went wrong with the line item buttons.');
                    break;
                }
                this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                if(action === 'hide'){
                    this.$store.commit('resetLineItem', num);
                    this.$store.dispatch('commitTotal');
                }
            },
            /*
            * This method is used when an invoice is shown for updating. After the model has been updated by the 'setInvoiceData' method, this method
            * is called in order to show the line item containers that do not have null or 0 values. Once those have been set to true, the relevant button
            * for that line item is set to true as well. The first button is set to false by default and will be shown if there is only one line item to show.
            */
            setLineItems(){
                this.btn[0].button = false;
                for(var i = 0; i < 7; i++){
                    for(var key in this.invoiceObj.line_items[i]){
                        if(this.invoiceObj.line_items[i][key] === null){
                            this.btn[i-1].button = true;
                            return;
                        } else if(i === 6){
                            this.btn[i].button = true;
                            this.ln[i].line = true;
                        } else {
                            this.ln[i].line = true;
                        }
                    }
                }
            },
            createInvoice(){ // post request to add an invoice
                this.$store.dispatch('createNewInvoice')
                .then(() => { 
                    this.resetValues(); 
                })
                .catch((error) => {
                    throw new Error('Something went wrong with the dispatch for createNewInvoice');
                });
            },
            updateInvoice(id){ // patch request to update an invoice
                this.$store.dispatch('updateInvoice', id)
                .then(() => {
                    this.resetValues();
                })
                .catch((error) => {
                    throw new Error('Something went wrong with the dispatch for updateInvoice');
                });
            },
            showInvoice(id){ // get request to show an invoice for editing
                this.$store.dispatch('showInvoice', id)
                .then(() => {
                    this.setLineItems();
                    this.table = false;
                    this.edit = true;
                })
                .catch((error) => {
                    throw new Error('Something went wrong with the dispatch for showInvoice');
                });
            },
            deleteInvoice(id){
                this.$store.dispatch('deleteInvoice', id)
                .then(() => {
                    this.getInvoices();
                })
                .catch((error) => {
                    throw new Error('Something went wrong with the dispatch for deleteInvoice');
                })
            },
            resetValues(){ // After form is submitted, values are reset to either 0 or empty string
                for(var i = 0; i < this.ln.length; i++){
                    for(var b in this.ln[i]){
                        if(i == 0){
                            this.ln[i][b] = true;
                            this.btn[i].button = true;
                        }else {
                            this.ln[i][b] = false;
                            this.btn[i].button = false;
                        }
                    }
                }
                this.cust_id = '';
                this.$store.dispatch('commitInvoices');
                this.edit = false;
                this.table = true;
            }
        }
    }
</script>
<style scoped>
    .cust_top_margin {
        margin-top: 32px;
    }
    .btn-margin {
        margin-top: 27px;
    }
</style>
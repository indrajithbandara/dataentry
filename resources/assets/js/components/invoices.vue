<template>
    <div>
        <div class="row"> 
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = true" class="btn btn-primary btn-lg full-width">View Invoices</button></div>
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = false" class="btn btn-success btn-lg full-width">Add An Invoice</button></div>
        </div>
        <hr>
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
                            <td><button @click="printShipper(invoice.id)" class="btn btn-default">Print Shipper</button></td>
                            <td><button @click="printInvoice(invoice.id)" class="btn btn-primary">Print Invoice</button></td>
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
        <hr>
        <!-- Add An Invoice Form -->
        <div v-show="!table">
            <h2 class="text-center">Add Invoice</h2>
            <form action="#" @submit.prevent="edit ? updateInvoice(invoice.id) : createInvoice()">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="inv_num">Invoice #</label>
                            <input v-model="invoice.inv_num" @blur="toInt()" number type="number" name="inv_num" class="form-control" required maxlength="11">
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
                    <select v-model="invoice.customer.id" @blur="getOneCustomer(invoice.customer.id)" number class="form-control" required>
                        <option>Choose An Item</option>
                        <option v-for="customer in customers_list">{{ customer.id }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="po_num">P.O #</label>
                    <input v-model="invoice.po_num" type="text" name="po_num" class="form-control" required maxlength="30">
                    <p class="alert alert-warning" v-if="invoice.po_num.length == 30">30 character limit reached!</p>
                </div>

                <!-- Add and Removing Line Item Buttons -->
                <button class="btn btn-success full-width" @click="showTwo()" type="button" v-show="btn_one">Add A Second Line Item</button>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="showThree()" type="button" v-show="btn_two">Add A Third Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideTwo()" type="button" v-show="btn_two">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="showFour()" type="button" v-show="btn_three">Add A Fourth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideThree()" type="button" v-show="btn_three">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="showFive()" type="button" v-show="btn_four">Add A Fifth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideFour()" type="button" v-show="btn_four">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="showSix()" type="button" v-show="btn_five">Add A Sixth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideFive()" type="button" v-show="btn_five">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="showSeven()" type="button" v-show="btn_six">Add A Seventh Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideSix()" type="button" v-show="btn_six">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-disabled full-width" type="button" v-show="btn_seven" disabled>Line Items Limit Reached</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="hideSeven()" type="button" v-show="btn_seven">Remove A Line Item</button>
                    </div>
                </div>
                <!-- End of Adding and Removing Line Item Buttons -->

                <hr class="dashed">

                <!-- ============================================ Line Items ============================================ -->
                <div ref="ln_container" class="overflow-scroll padding radius">
                    <div id="line_item_one">
                        <!-- ============== Line Item One ============== -->
                        <h4 class="text-center background padding radius">Line Item One</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_one">Line Item</label>
                                    <input v-model="invoice.line_items[0].item" type="text" name="li_one" class="form-control" maxlength="15" required>
                                    <p class="alert alert-warning" v-if="invoice.line_items[0].item.length == 15">15 character limit reached!</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[0].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_one">Qty</label>
                                <input v-model="invoice.line_items[0].qty" number @keyup="getExtended(0)" type="number" name="qty_one" min="0" step="1" class="form-control" maxlength="11" required>
                                <p class="alert alert-warning" v-if="invoice.line_items[0].qty.length == 11">11 character limit reached!</p>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_one">Unit Price</label>
                                <input v-model="invoice.line_items[0].unit" number @keyup="getExtended(0)" type="number" name="unit_one" min="0" step="0.01" class="form-control" maxlength="6" required>
                                <p class="alert alert-warning" v-if="invoice.line_items[0].unit.length == 6">6 character limit reached!</p>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_one">Ext Price</label>
                                <input v-model="invoice.line_items[0].extended" number type="number" name="extended_one" min="0" step="0.01" class="form-control"  maxlength="8" readonly>
                                <p class="alert alert-warning" v-if="invoice.line_items[0].extended.length == 8">8 character limit reached!</p>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item One ============== -->
                    </div>

                    <div id="line_item_two" v-if="ln_two">
                        <!-- ============== Line Item Two ============== -->
                        <h4 class="text-center background padding radius">Line Item Two</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_two">Line Item</label>
                                    <input v-model="invoice.line_items[1].item" type="text" name="li_two" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[1].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_two">Qty</label>
                                <input v-model="invoice.line_items[1].qty" number @keyup="getExtended(1)" type="number" name="qty_two" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_two">Unit Price</label>
                                <input v-model="invoice.line_items[1].unit" number @keyup="getExtended(1)" type="number" name="unit_two" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_two">Ext Price</label>
                                <input v-model="invoice.line_items[1].extended" number type="number" name="extended_two" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Two ============== -->
                    </div>

                    <div id="line_item_three" v-if="ln_three">
                        <!-- ============== Line Item Three ============== -->
                        <h4 class="text-center background padding radius">Line Item Three</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_three">Line Item</label>
                                    <input v-model="invoice.line_items[2].item" type="text" name="li_three" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[2].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_three">Qty</label>
                                <input v-model="invoice.line_items[2].qty" number @keyup="getExtended(2)" type="number" name="qty_three" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_three">Unit Price</label>
                                <input v-model="invoice.line_items[2].unit" number @keyup="getExtended(2)" type="number" name="unit_three" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_three">Ext Price</label>
                                <input v-model="invoice.line_items[2].extended" number type="number" name="extended_three" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Three ============== -->
                    </div>

                    <div id="line_item_four" v-if="ln_four">
                        <!-- ============== Line Item Four ============== -->
                        <h4 class="text-center background padding radius">Line Item Four</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_four">Line Item</label>
                                    <input v-model="invoice.line_items[3].item" type="text" name="li_four" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[3].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_four">Qty</label>
                                <input v-model="invoice.line_items[3].qty" number @keyup="getExtended(3)" type="number" name="qty_four" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_four">Unit Price</label>
                                <input v-model="invoice.line_items[3].unit" number @keyup="getExtended(3)" type="number" name="unit_four" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_four">Ext Price</label>
                                <input v-model="invoice.line_items[3].extended" number type="number" name="extended_four" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Four ============== -->
                    </div>

                    <div id="line_item_five" v-if="ln_five">
                        <!-- ============== Line Item five ============== -->
                        <h4 class="text-center background padding radius">Line Item Five</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_five">Line Item</label>
                                    <input v-model="invoice.line_items[4].item" type="text" name="li_five" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[4].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_three">Qty</label>
                                <input v-model="invoice.line_items[4].qty" number @keyup="getExtended(4)" type="number" name="qty_five" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_five">Unit Price</label>
                                <input v-model="invoice.line_items[4].unit" number @keyup="getExtended(4)" type="number" name="unit_five" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_five">Ext Price</label>
                                <input v-model="invoice.line_items[4].extended" number type="number" name="extended_five" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Five ============== -->
                    </div>

                    <div id="line_item_six" v-if="ln_six">
                        <!-- ============== Line Item Six ============== -->
                        <h4 class="text-center background padding radius">Line Item Six</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_six">Line Item</label>
                                    <input v-model="invoice.line_items[5].item" type="text" name="li_six" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[5].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_six">Qty</label>
                                <input v-model="invoice.line_items[5].qty" number @keyup="getExtended(5)" type="number" name="qty_six" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_six">Unit Price</label>
                                <input v-model="invoice.line_items[5].unit" number @keyup="getExtended(5)" type="number" name="unit_six" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_six">Ext Price</label>
                                <input v-model="invoice.line_items[5].extended" number type="number" name="extended_six" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Six ============== -->
                    </div>

                    <div id="line_item_seven" v-if="ln_seven">
                        <!-- ============== Line Item Seven ============== -->
                        <h4 class="text-center background padding radius">Line Item Seven</h4>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="li_seven">Line Item</label>
                                    <input v-model="invoice.line_items[6].item" type="text" name="li_seven" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select v-model="invoice.line_items[6].product" class="form-control" required>
                                        <option>Choose An Item</option>
                                        <option v-for="product in products_list">{{ product.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="qty_seven">Qty</label>
                                <input v-model="invoice.line_items[6].qty" number @keyup="getExtended(6)" type="number" name="qty_seven" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_seven">Unit Price</label>
                                <input v-model="invoice.line_items[6].unit" number @keyup="getExtended(6)" type="number" name="unit_seven" min="0" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="extended_seven">Ext Price</label>
                                <input v-model="invoice.line_items[6].extended" number type="number" name="extended_seven" min="0" step="0.01" class="form-control" readonly>
                            </div>
                        </div>
                        <br />
                        <!-- ============== End of Line Item Seven ============== -->
                    </div>
                </div>
                <!-- ========================================= End of Line Items ======================================= -->

                <hr class="dashed">

                <div class="form-group">
                    <label for="ship_fee">Shipping Fee</label>
                    <input v-model="invoice.ship_fee" number type="number" @keyup="getTotal()" name="ship_fee" min="0" step="0.01" class="form-control">
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
        <!-- End of add invoice form -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                edit: false, // Hides or shows edit mode which changes the text and functionality of the submit button.
                table: true, // If true, the invoices table is showing. If false, the invoices form is showing.
                // Line Item Forms
                ln_one: true, ln_two: false, ln_three: false, ln_four: false, ln_five: false, ln_six: false, ln_seven: false,
                // Line Item Buttons
                btn_one: true, btn_two: false, btn_three: false, btn_four: false, btn_five: false, btn_six: false, btn_seven: false,
                // List out Arrays
                list: [], // Invoices Items
                customers_list: [], // Customers Dropdown
                products_list: [], // Products Dropdown
                // Invoice Model
                invoice: {
                    inv_num: 0,
                    date: '',
                    // Copy of the customer in the customers table
                    customer: {
                        id: '',
                        name: '',
                        shipto: '',
                        billto: '',
                        buyer: '',
                        email: '',
                        phone: '',
                        country: '',
                        disclaimer: '',
                        comments: '',
                    },
                    po_num: '',
                    line_items: 
                    [
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 },
                        { item: '', product: '', qty: 0, unit: 0, extended: 0 }
                    ],
                    ship_fee: 0,
                    total: 0,
                    memo: ''
                },
                // Property for know who the user is and knowing what to hide form other users. 
                user: ''
            }
        },
        mounted() { 
            // when vue instance is mounted, get the display the invoices and the authenticated user.
            this.getInvoices();
            this.getCustomers();
            this.getProducts();
            this.getUser();
        },
        methods: {
            li_btn_show(num){
                switch(num){
                    case 1:
                        this.btn_one = false; this.btn_two = true; this.ln_two = true; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    case 2:
                         this.btn_two = false; this.btn_three = true; this.ln_three = true; 
                         this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    case 3:
                        this.btn_three = false; this.btn_four = true; this.ln_four = true; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    case 4:
                        this.btn_four = false; this.btn_five = true; this.ln_five = true; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    case 5:
                        this.btn_five = false; this.btn_six = true; this.ln_six = true; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    case 6:
                        this.btn_six = false; this.btn_seven = true; this.ln_seven = true; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;
                    break;
                    default:
                        console.log("Something went wrong with the line item buttons");
                    break;
                }
            },
            
            showTwo(){ this.btn_one = false; this.btn_two = true; this.ln_two = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideTwo(){ 
                this.btn_one = true; 
                this.btn_two = false; 
                this.ln_two = false; 
                this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                this.resetLineItem(1); 
                this.getTotal();
            },
            showThree(){ this.btn_two = false; this.btn_three = true; this.ln_three = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideThree(){ this.btn_two = true; this.btn_three = false; this.ln_three = false; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; this.resetLineItem(2); this.getTotal();},
            showFour(){ this.btn_three = false; this.btn_four = true; this.ln_four = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideFour(){ this.btn_three = true; this.btn_four = false; this.ln_four = false; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; this.resetLineItem(3); this.getTotal();},
            showFive(){ this.btn_four = false; this.btn_five = true; this.ln_five = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideFive(){ this.btn_four = true; this.btn_five = false; this.ln_five = false; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; this.resetLineItem(4); this.getTotal();},
            showSix(){ this.btn_five = false; this.btn_six = true; this.ln_six = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideSix(){ this.btn_five = true; this.btn_six = false; this.ln_six = false; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; this.resetLineItem(5); this.getTotal();},
            showSeven(){ this.btn_six = false; this.btn_seven = true; this.ln_seven = true; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight;},
            hideSeven(){ this.btn_six = true; this.btn_seven = false; this.ln_seven = false; this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; this.resetLineItem(6); this.getTotal();},
            resetLineItem(num){
                this.invoice.line_items[num].item = '';
                this.invoice.line_items[num].product = '';
                this.invoice.line_items[num].qty = 0;
                this.invoice.line_items[num].unit = 0;
                this.invoice.line_items[num].extended = 0;
            },
            getTotal(){
                var total = 
                this.invoice.line_items[0].extended +
                this.invoice.line_items[1].extended +
                this.invoice.line_items[2].extended +
                this.invoice.line_items[3].extended +
                this.invoice.line_items[4].extended +
                this.invoice.line_items[5].extended +
                this.invoice.line_items[6].extended +
                parseFloat(this.invoice.ship_fee);
                this.invoice.total = total.toFixed(2);
            },
            getExtended(num){
                this.invoice.line_items[num].extended = this.invoice.line_items[num].qty * this.invoice.line_items[num].unit; this.getTotal();
            },
            toInt(){
                this.invoice.inv_num = parseInt(this.invoice.inv_num);
            },
            getUser(){ // ajax call to get the authenticated user
                axios.get('api/user')
                .then((response) => {
                    this.user = response.data.permission;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getCustomers(){ // ajax call to get available customers for the customers dropdown
                axios.get('api/customers')
                .then((response) => {
                    this.customers_list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getProducts(){ // ajax call to get available products for the products dropdowns
                axios.get('api/products')
                .then((response) => {
                    this.products_list = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getInvoices(){ // ajax call to get all the Inovices
                axios.get('api/invoices')
                .then((response) => {
                    var newData = function(){
                        var data = response.data;
                        for(var i = 0; i < data.length; i++){
                            for(var key in data[i]){
                                if(key === 'customer'){
                                    data[i].customer = JSON.parse(data[i].customer);
                                } else if (key === 'line_items') {
                                    data[i].line_items = JSON.parse(data[i].line_items);
                                }
                            }
                        }
                        return data;
                    }
                    this.list = newData();
                }).catch((error) => {
                    console.log(error);
                });
            },
            getOneCustomer(id){ // get a specific customer to store with invoice.
                let self = this;
                axios({
                    method: 'get',
                    url: 'api/customers/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    self.invoice.customer.id = response.data.id;
                    self.invoice.customer.name = response.data.name;
                    self.invoice.customer.shipto = response.data.shipto;
                    self.invoice.customer.billto = response.data.billto;
                    self.invoice.customer.buyer = response.data.buyer;
                    self.invoice.customer.email = response.data.email;
                    self.invoice.customer.phone = response.data.phone;
                    self.invoice.customer.country = response.data.country;
                    self.invoice.customer.disclaimer = response.data.disclaimer;
                    self.invoice.customer.comments = response.data.comments;
                }).catch((error) => {
                    console.log(error.message);
                });
            },
            createInvoice(){ // post request to add an invoice
                let self = this;
                let params = Object.assign({}, self.invoice);
                axios({
                    method: 'post',
                    url: 'api/invoices/store',
                    data: params,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
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
            resetValues(){
                this.invoice.inv_num = '';
                this.invoice.date = '';
                this.invoice.customer.id = '';
                this.invoice.customer.name = '';
                this.invoice.customer.shipto = '';
                this.invoice.customer.billto = '';
                this.invoice.customer.buyer = '';
                this.invoice.customer.email = '';
                this.invoice.customer.phone = '';
                this.invoice.customer.country = '';
                this.invoice.customer.disclaimer = '';
                this.invoice.customer.comments = '';
                this.invoice.po_num = '';
                this.invoice.line_items[0].item = '';
                this.invoice.line_items[0].product = '';
                this.invoice.line_items[0].qty = 0;
                this.invoice.line_items[0].unit = 0;
                this.invoice.line_items[0].extended = 0;
                this.invoice.line_items[1].item = '';
                this.invoice.line_items[1].product = '';
                this.invoice.line_items[1].qty = 0;
                this.invoice.line_items[1].unit = 0;
                this.invoice.line_items[1].extended = 0;
                this.invoice.line_items[2].item = '';
                this.invoice.line_items[2].product = '';
                this.invoice.line_items[2].qty = 0;
                this.invoice.line_items[2].unit = 0;
                this.invoice.line_items[2].extended = 0;
                this.invoice.line_items[3].item = '';
                this.invoice.line_items[3].product = '';
                this.invoice.line_items[3].qty = 0;
                this.invoice.line_items[3].unit = 0;
                this.invoice.line_items[3].extended = 0;
                this.invoice.line_items[4].item = '';
                this.invoice.line_items[4].product = '';
                this.invoice.line_items[4].qty = 0;
                this.invoice.line_items[4].unit = 0;
                this.invoice.line_items[4].extended = 0;
                this.invoice.line_items[5].item = '';
                this.invoice.line_items[5].product = '';
                this.invoice.line_items[5].qty = 0;
                this.invoice.line_items[5].unit = 0;
                this.invoice.line_items[5].extended = 0;
                this.invoice.line_items[6].item = '';
                this.invoice.line_items[6].product = '';
                this.invoice.line_items[6].qty = 0;
                this.invoice.line_items[6].unit = 0;
                this.invoice.line_items[6].extended = 0;
                this.invoice.ship_fee = 0;
                this.invoice.total = 0;
                this.invoice.memo = '';
                this.edit = false;
                this.getInvoices();
                this.table = true;
            }
        }
    }
</script>
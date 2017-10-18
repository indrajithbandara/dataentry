<template>
    <div>
        <div class="row"> 
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = true" class="btn btn-primary btn-lg full-width">View Invoices</button></div>
            <div class="col-xs-6 col-sm-6 col-md-6"><button @click="table = false" class="btn btn-success btn-lg full-width">Add An Invoice</button></div>
        </div>
        <hr>
        <div v-show="table">
            <!-- Invoices Table -->
            <div id="product-table" v-if="invoices_list.length > 0" class="table-responsive">
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
                        <tr v-for="invoice in invoices_list">
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

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <select v-model="invoice.customer.id" @blur="getOneCustomer(invoice.customer.id)" number class="form-control">
                                <option>Choose An Item</option>
                                <option v-for="customer in customers_list" >{{ customer.id }} - {{ customer.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <h4 class="cust_top_margin"><strong>Customer:</strong> {{ invoice.customer.name }}</h4>
                    </div>
                </div>

                <div class="form-group">
                    <label for="po_num">P.O #</label>
                    <input v-model="invoice.po_num" type="text" name="po_num" class="form-control" required maxlength="30">
                    <p class="alert alert-warning" v-if="invoice.po_num.length == 30">30 character limit reached!</p>
                </div>

                <!-- Add and Removing Line Item Buttons -->
                <button class="btn btn-success full-width" @click="li_btn_show(1)" type="button" v-show="btn_one">Add A Second Line Item</button>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="li_btn_show(2)" type="button" v-show="btn_two">Add A Third Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(1)" type="button" v-show="btn_two">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="li_btn_show(3)" type="button" v-show="btn_three">Add A Fourth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(2)" type="button" v-show="btn_three">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="li_btn_show(4)" type="button" v-show="btn_four">Add A Fifth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(3)" type="button" v-show="btn_four">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="li_btn_show(5)" type="button" v-show="btn_five">Add A Sixth Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(4)" type="button" v-show="btn_five">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-success full-width" @click="li_btn_show(6)" type="button" v-show="btn_six">Add A Seventh Line Item</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(5)" type="button" v-show="btn_six">Remove A Line Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-disabled full-width" type="button" v-show="btn_seven" disabled>Line Items Limit Reached</button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <button class="btn btn-danger full-width" @click="li_btn_hide(6)" type="button" v-show="btn_seven">Remove A Line Item</button>
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
                                <input v-model="invoice.line_items[0].qty" number @keyup="setExtended(0)" type="number" name="qty_one" min="0" step="1" class="form-control" maxlength="11" required>
                                <p class="alert alert-warning" v-if="invoice.line_items[0].qty.length == 11">11 character limit reached!</p>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_one">Unit Price</label>
                                <input v-model="invoice.line_items[0].unit" number @keyup="setExtended(0)" type="number" name="unit_one" min="0" step="0.01" class="form-control" maxlength="6" required>
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
                                <input v-model="invoice.line_items[1].qty" number @keyup="setExtended(1)" type="number" name="qty_two" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_two">Unit Price</label>
                                <input v-model="invoice.line_items[1].unit" number @keyup="setExtended(1)" type="number" name="unit_two" min="0" step="0.01" class="form-control" required>
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
                                <input v-model="invoice.line_items[2].qty" number @keyup="setExtended(2)" type="number" name="qty_three" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_three">Unit Price</label>
                                <input v-model="invoice.line_items[2].unit" number @keyup="setExtended(2)" type="number" name="unit_three" min="0" step="0.01" class="form-control" required>
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
                                <input v-model="invoice.line_items[3].qty" number @keyup="setExtended(3)" type="number" name="qty_four" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_four">Unit Price</label>
                                <input v-model="invoice.line_items[3].unit" number @keyup="setExtended(3)" type="number" name="unit_four" min="0" step="0.01" class="form-control" required>
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
                                <input v-model="invoice.line_items[4].qty" number @keyup="setExtended(4)" type="number" name="qty_five" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_five">Unit Price</label>
                                <input v-model="invoice.line_items[4].unit" number @keyup="setExtended(4)" type="number" name="unit_five" min="0" step="0.01" class="form-control" required>
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
                                <input v-model="invoice.line_items[5].qty" number @keyup="setExtended(5)" type="number" name="qty_six" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_six">Unit Price</label>
                                <input v-model="invoice.line_items[5].unit" number @keyup="setExtended(5)" type="number" name="unit_six" min="0" step="0.01" class="form-control" required>
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
                                <input v-model="invoice.line_items[6].qty" number @keyup="setExtended(6)" type="number" name="qty_seven" min="0" step="1" class="form-control" required>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <label for="unit_seven">Unit Price</label>
                                <input v-model="invoice.line_items[6].unit" number @keyup="setExtended(6)" type="number" name="unit_seven" min="0" step="0.01" class="form-control" required>
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
                    <input v-model="invoice.ship_fee" number type="number" @keyup="setTotal()" name="ship_fee" min="0" step="0.01" class="form-control">
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
                * ln_{num} are meant for hidding and showing the seven different line item forms.
                * if ln_{num} = true, the form is displayed.
                * if ln_{num} = false, the form is hidden.
                *
                * btn_{num} are meant for hidding and showing the seven different button containers for hidding and show the seven different line item forms
                * if btn_{num} = true, the button container is displayed
                * if btn_{num} = false, the button container is hidden
                *
                * Methods Involved: li_btn_show() | li_btn_hide()
                */
                ln_one: true, ln_two: false, ln_three: false, ln_four: false, ln_five: false, ln_six: false, ln_seven: false,
                btn_one: true, btn_two: false, btn_three: false, btn_four: false, btn_five: false, btn_six: false, btn_seven: false,
                /*
                * LISTS OF COLLECTIONS:
                *
                * These arrays are for looping over to show in tables or dropdown lists.
                * 1.) invoices_list is an array of objects listing out on the invoices table
                * Methods Involved: getInvoices()
                *
                * 2.) customers_list is an array of objects listing out the customer dropdown list as '{id} - {name}'
                * Methods Involved: getCustomers()
                *
                * 3.) product_list is an array of objects listing out the product dropdown lists as '{name}'
                * Methods Involved: getProducts()
                */
                invoices_list: [],
                customers_list: [],
                products_list: [],
                /*
                * THE INVOICE MODEL:
                *
                * The invoice model is an object conaining the following properties:
                * 1.) inv_num - Invoice Number | Type: Number
                * 2.) data - Shipping Date | Type: Date
                * 3.) customer - Customer Snap Shot | Type: Object | Description: Meant for saving a snap shot of the customer this invoice is 
                *                made for as json. This is so because the invoice model has no relationship with the customer model. The reason for this
                *                is so that the customer data per invoice is preserved which allows the user to change customer information with
                *                out corrupting the information that was truthy at the time of the making of an invoice. This method was prefered 
                *                over saving multiple versions of a customer model and then setting them to a value like 'edited' which makes for
                *                more requests being sent to the server for version checking. Even though this method takes up more storage over the
                *                long run, it allows the app to run more efficiently when internet connections are slow. This object goes thorugh parsing
                *                in the getInvoices() method.
                * 4.) po_num - Purchase Order Number | Type: String
                * 5.) line_items - List of line items | Type: Array of Objects | Description: The list of line items is an array of seven objects stored as 
                *                as json in one column. This array goes through parsing in the getInvoices() method. Each obeject has three numeric properties
                *                that get passed through the setExtended() method which is triggered on every keyup event on the 'Qty' and 'Unit Price' inputs. 
                *                This method sets the value of each 'extended' price property in order to be passed through the setTotal() method which sets 
                *                the value of the 'invoice.total' property.
                * 6.) ship_fee - Shipping Fees | Type: Number
                * 7.) total - Total Price of all Line Items Extended Prices | Type: Number
                * 8.) memo - Alternate information for the invoice | Type: String
                */
                invoice: {
                    inv_num: 0,
                    date: '',
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
                    line_items: [
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
                /*
                *  THE CURRENT AUTHENTICATED USER:
                *
                * The 'user' propertie is to store the permission level (1-4) of the currently logged in user so that certain aspects of the invoice form
                * can be either off limits or hidden from other users. This property is set in the getUser() method.
                */
                user: ''
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
        methods: {
            /*
            *===== GETTER METHODS =====
            */
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
            getInvoices(){ // ajax call to get all the Inovices and parse nested json data
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
                    this.invoices_list = newData();
                }).catch((error) => {
                    console.log(error);
                });
            },
            getOneCustomer(cust){ // get a customer snap shot to store with current invoice model
                let id = parseInt(cust[0]);
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
            /*
            *===== SETTER METHODS =====
            */
            setTotal(){ // Adds up extended values and ship_fee value to be stored in the invoice total
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
            setExtended(num){ // Adds up the 'qty' and the 'unit' values to set the 'extended' property for this line item
                this.invoice.line_items[num].extended = this.invoice.line_items[num].qty * this.invoice.line_items[num].unit; 
                this.setTotal();
            },
            /*
            *===== HIDING AND SHOWING METHODS =====
            *
            * SHOWING AND HIDING BUTTONS AND LINE ITEMS AS WELL AS SCROLLING THE CONTAINER TO THE BOTTOM
            *
            * There are two types of buttons:
            * 1.) Buttons that show line items
            * 2.) Buttons that hide line items
            *
            * - li_btn_show is meant for showing the next button and line item on the DOM while hiding the button that was just clicked. 
            *
            * - li_btn_hide is meant for hiding the most recent button and line item added while showing the previous butten that was hidden again. 
            *   Each time the one of these buttons is clicked, the resetLineItem() and setTotal() methods are fired in order to reset the values of the 
            *   now hidden line item as well as re-calculate the total of the invoice. 
            *   ****** IMPORTANT NOTE *******
            * - Even though line items are hidden from site on the page, there values are still calculated from the invoice model. These line items
            *   themselves are no longer on the DOM but the model still remains available for calcultion. 
            */
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
                        console.log("Sorry!! Something went wrong with this button!");
                    break;
                }
            },
            li_btn_hide(num){
                switch(num){
                    case 1:
                        this.btn_one = true; this.btn_two = false; this.ln_two = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(1); this.setTotal();
                    break;
                    case 2:
                        this.btn_two = true; this.btn_three = false; this.ln_three = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(2); this.setTotal();
                    break;
                    case 3:
                        this.btn_three = true; this.btn_four = false; this.ln_four = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(3); this.setTotal();
                    break;
                    case 4:
                        this.btn_four = true; this.btn_five = false; this.ln_five = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(4); this.setTotal();
                    break;
                    case 5:
                        this.btn_five = true; this.btn_six = false; this.ln_six = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(5); this.setTotal();
                    break;
                    case 6:
                        this.btn_six = true; this.btn_seven = false; this.ln_seven = false; 
                        this.$refs.ln_container.scrollTop = this.$refs.ln_container.scrollHeight; 
                        this.resetLineItem(6); this.setTotal();
                    break;
                    default:
                        console.log('Sorry!! Something went wrong with this button!');
                    break;
                }
            },
            /*
            *===== CONVERSION METHODS =====
            */
            toInt(){ // converting the invoice number (starting as a string) to a number to be stored in the database.
                this.invoice.inv_num = parseInt(this.invoice.inv_num);
            },
            /*
            *===== C.R.U.D METHODS =====
            */
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
            showInvoice(id){ // get request to show an invoice for editing
                let self = this;
                axios({
                    method: 'get',
                    url: 'api/invoices/' + id,
                    validateStatus(status) {
                        return status >= 200 && status < 300;
                    }
                }).then((response) => {
                    self.table = false;
                    // set model values to response.data
                }).catch((error) => {
                    console.log(error.message);
                });
                self.edit = true;
            },
            deleteInvoice(id){ // delete request to delete an invoice, only permision level 1 users can make this request as the button is only visable for them.
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
            *===== RESET METHODS =====
            */
            resetValues(){ // After form is submitted, values are reset to either 0 or empty string
                let self = this;
                for(var key in self.invoice){
                    if(key == 'inv_num' || key == 'ship_fee' || key == 'total'){
                        self.invoice[key] = 0;
                    }else if(key == 'date' || key == 'po_num' || key == 'memo'){
                        self.invoice[key] = '';
                    }else if(key == 'customer'){
                        for(var k in self.invoice.customer){
                            self.invoice.customer[k] = '';
                        }
                    }else if(key == 'line_items'){
                        for(var i = 0; i < 7; i++){
                            self.resetLineItem(i);
                        }  
                    }
                }
                this.edit = false;
                this.getInvoices();
                this.table = true;
            },
            resetLineItem(num){
                let self = this;
                for(var key in self.invoice.line_items[num]){
                    if(key == 'item' || key == 'product'){
                        self.invoice.line_items[num][key] = '';
                    }else{
                        self.invoice.line_items[num][key] = 0;
                    }
                }
            }
        }
    }
</script>
<style scoped>
    .cust_top_margin {
        margin-top: 32px;
    }
</style>
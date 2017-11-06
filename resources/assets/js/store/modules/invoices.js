const state = {
    invoices: [],
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
        misc_char: 0,
        ship_fee: 0,
        total: 0,
        complete: 0,
        carrier: '',
        memo: ''
    }
};

const getters = {
    getInvoices: state => state.invoices,
};

const mutations = {
    setInvoices: (state, payload) => {
        state.invoices = payload;
    },
    setCustomer: (state, payload) => {
        state.invoice.customer = payload;
    },
    updateInvNum: (state, payload) => {
        state.invoice.inv_num = parseInt(payload);
    },
    updateDate: (state, payload) => {
        state.invoice.date = payload;
    },
    updatePo: (state, payload) => {
        state.invoice.po_num = payload;
    },
    updateCarrier: (state, payload) => {
        state.invoice.carrier = payload;
    },
    updateMemo: (state, payload) => {
        state.invoice.memo = payload;
    },
    updateComplete: (state, payload) => {
        state.invoice.complete = parseInt(payload);
    },
    // Line item Mutations
    updateLineItem: (state, payload) => {
        state.invoice.line_items[payload.item].item = payload.event;
    },
    updateProduct: (state, payload) => {
        state.invoice.line_items[payload.item].product = payload.event;
    },
    updateQty: (state, payload) => {
        state.invoice.line_items[payload.item].qty = payload.event;
    },
    updateUnit: (state, payload) => {
        state.invoice.line_items[payload.item].unit = payload.event;
    },
    updateExtended: (state, payload) => {
        state.invoice.line_items[payload.item].extended = payload.ext;
    },
    updateShipFee: (state, payload) => {
        state.invoice.ship_fee = payload;  
    },
    updateMiscChar: (state, payload) => {
        state.invoice.misc_char = payload;  
    },
    updateTotal: (state, payload) => {
        state.invoice.total = payload;  
    }
};

const actions = {
    commitInvoices: ({ commit }) => {
        axios.get('api/invoices')
        .then((response) => {
            var newData = () => {
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
            commit('setInvoices', newData());
        }).catch((error) => {
            console.log(error);
        });
    },
    commitOneCustomer: ( { commit }, payload ) => {
        axios({
            method: 'get',
            url: 'api/customers/' + parseInt(payload[0]),
            validateStatus(status) {
                return status >= 200 && status < 300;
            }
        }).then((response) => {
            commit('setCustomer', response.data);
        }).catch((error) => {
            console.log(error.message);
        });
    },
    /*
    payload = { event = keyup
        item: Number,
        event: input value,
        set: Number: 0 = qty, 1 = unit
    }
    */
    commitMath: ( { commit }, payload ) => {
        if(payload.set === 0){
            commit('updateQty', {item: payload.item, event: payload.event});
        } else if(payload.set === 1){
            commit('updateUnit', {item: payload.item, event: payload.event});
        }
            let extended = state.invoice.line_items[payload.item].qty * 
                           state.invoice.line_items[payload.item].unit;
            commit('updateExtended', {item: payload.item, ext: extended});
    },
    commitTotal: ({ commit }) => {
        let total = () => {
            let t = 0;
            for(let i = 0; i < 7; i++){
                t += state.invoice.line_items[i].extended;
            }
            t += parseFloat(state.invoice.ship_fee);
            t += parseFloat(state.invoice.misc_char);
            return t;
        }
        let totalToFloat = total();
        commit('updateTotal', totalToFloat.toFixed(2));
    }
}

export default {
    state,
    getters,
    mutations,
    actions
};
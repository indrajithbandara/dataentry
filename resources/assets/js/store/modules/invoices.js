const state = {
    invoices: [],
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
        console.log(payload);
        if(payload.set === 0){
            commit('updateQty', {item: payload.item, event: payload.event});
            console.log("qty commited");
        } else if(payload.set === 1){
            commit('updateUnit', {item: payload.item, event: payload.event});
            console.log("unit commited");
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
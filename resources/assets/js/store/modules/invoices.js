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
    updateInvNum: (state, payload) => {
        state.invoice.inv_num = parseInt(payload);
    },
    updateDate: (state, payload) => {
        state.invoice.date = payload;
    },
    updateCarrier: (state, payload) => {
        state.invoice.carrier = payload;
    },
    updateMemo: (state, payload) => {
        state.invoice.memo = payload;
    },
    updateComplete: (state, payload) => {
        state.invoice.complete = parseInt(payload);
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
    }
}

export default {
    state,
    getters,
    mutations,
    actions
};
const state = {
    invoices: []
};

const getters = {
    getInvoices: (state) => {
        return state.invoices;
    }
};

const mutations = {
    setInvoices: (state, payload) => {
        state.invoices = payload;
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
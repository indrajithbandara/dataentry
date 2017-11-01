const state = {
    customers: []
};

const getters = {
    getCustomers: (state) => {
        return state.customers;
    }
};

const mutations = {
    setCustomers: (state, payload) => {
        state.customers = payload;
    }
};

const actions = {
    commitCustomers: ({ commit }) => {
        axios.get('api/customers')
        .then((response) => {
            commit('setCustomers', response.data);
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
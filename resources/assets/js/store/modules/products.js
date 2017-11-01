const state = {
    products: []
};

const getters = {
    getProducts: (state) => {
        return state.products;
    }
};

const mutations = {
    setProducts: (state, payload) => {
        state.products = payload;
    }
};

const actions = {
    commitProducts: ({ commit }) => {
        axios.get('api/products')
        .then((response) => {
            commit('setProducts', response.data);
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

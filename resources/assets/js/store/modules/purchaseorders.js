/**
 * @const customers state | object
 */
const state = {
    purchaseorders: []
};

/**
 * @const purchaseorders getters | object
 */
const getters = {
    /**
     * Gets the purchaseorder list
     *
     * @param state
     * @return Array
     */
    getPurchaseorders: (state) => {
        return state.purchaseorders;
    }
};

/**
 * @const Purchaseorders Mutations | object
 */
const mutations = {
    /**
     * Mutations for setting the state with the array of purchaseorders
     *
     * @param state | vuex state
     * @param payload | payload from dispatcher
     */
    setPurchaseorders: (state, payload) => {
        state.purchaseorders = payload;
    }
};

/**
 * @const Purchaseorders Actions | object
 */
const actions = {
    /**
     * Gets purchaseorders data to be commited to mutator
     *
     * @param commit | object
     * @return void
     */
    commitPurchaseorders: ({ commit }) => {
        // axios.get('api/customers')
        // .then((response) => {
        //     commit('setCustomers', response.data);
        // }).catch((error) => {
        //     throw new Error("commit customer failed!!" + error);
        // });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
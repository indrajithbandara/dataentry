/**
 * @const inventory state | object
 */
const state = {
    inventory: []
};

/**
 * @const inventory getters | object
 */
const getters = {
    /**
     * Gets the inventory list
     *
     * @param state
     * @return Array
     */
    getInventory: (state) => {
        return state.inventory;
    }
};

/**
 * @const Inventory Mutations | object
 */
const mutations = {
    /**
     * Mutations for setting the state with the array of Inventory
     *
     * @param state | vuex state
     * @param payload | payload from dispatcher
     */
    setInventory: (state, payload) => {
        state.inventory = payload;
    }
};

/**
 * @const Inventory Actions | object
 */
const actions = {
    /**
     * Gets Inventory data to be commited to mutator
     *
     * @param commit | object
     * @return void
     */
    commitInventory: ({ commit }) => {
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
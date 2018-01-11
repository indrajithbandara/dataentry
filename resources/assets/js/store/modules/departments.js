/**
 * @const departments state | object
 */
const state = {
    departments: []
};

/**
 * @const departments getters | object
 */
const getters = {
    /**
     * Gets the department list
     *
     * @param state
     * @return Array
     */
    getDepartments: (state) => {
        return state.departments;
    }
};

/**
 * @const Departments Mutations | object
 */
const mutations = {
    /**
     * Mutations for setting the state with the array of departments
     *
     * @param state | vuex state
     * @param payload | payload from dispatcher
     */
    setDepartments: (state, payload) => {
        state.departments = payload;
    }
};

/**
 * @const Departments Actions | object
 */
const actions = {
    /**
     * Gets departments data to be commited to mutator
     *
     * @param commit | object
     * @return void
     */
    commitDepartments: ({ commit }) => {
        // axios.get('api/departments')
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
const state = {
    users: []
};

const getters = {
    getUsers: (state) => {
        return state.users;
    }
};

const mutations = {
    setUsers: (state, payload) => {
        state.users = payload;
    }
};

const actions = {
    commitUsers: ({ commit }) => {
        axios.get('api/users')
        .then((response) => {
            commit('setUsers', response.data);
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
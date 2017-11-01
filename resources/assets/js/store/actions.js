export const commitPermission = ({ commit }) => {
    axios.get('api/user')
    .then((response) => {
        commit('setPermission', response.data.permission);
    }).catch((error) => {
        console.log(error);
    });
};
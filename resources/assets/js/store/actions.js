/**
 * Gets the user permission level in order to restrict certain users
 *
 * @param commit | object
 * @return void
 */
export const commitPermission = ({ commit }) => {
    axios.get('api/user')
    .then((response) => {
        commit('setPermission', response.data.permission);
    }).catch((error) => {
        throw new Error(" commit permission failed!" + error);
    });
};
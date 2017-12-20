/**
 * Set the permission level to the state
 *
 * @param state | vuex state
 * @param payload | object
 * @return void
 */
export const setPermission = (state, payload) => {
    state.permission = payload;
};
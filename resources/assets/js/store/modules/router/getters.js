/**
 * Get the routers from the vuex state
 *
 * @param state | Vuex state
 * @return array 
 */
export const getRouters = state => state.routers

/**
 * Get the routers total for report mode
 *
 * @param state | Vuex state
 * @return number
 */
export const getRouteTotal = state => state.route_total
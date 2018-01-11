// Tasks
import * as getters from './getters';
import * as mutations from './mutations';
import * as actions from './actions';
const state = {
    // Array for storing routers collections
    routers: [],
    route_total: 0,
    router: {
        //
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
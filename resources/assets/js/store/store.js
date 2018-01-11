require('./../bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
// Modules
import invoices from './modules/invoice/invoices';
import routers from './modules/router/routers';
import users from './modules/users';
import products from './modules/products';
import customers from './modules/customers';
import departments from './modules/departments';
import inventory from './modules/inventory';
import purchaseorders from './modules/purchaseorders';
// Tasks
import * as getters from './getters';
import * as mutations from './mutations';
import * as actions from './actions';

Vue.use(Vuex);

/**
 * Sets up the vuex global state object
 */
export const store = new Vuex.Store({
    state: {
        id: 0,
        permission: 0
    },
    getters,
    mutations,
    actions,
    modules: {
        users,
        invoices,
        routers,
        products,
        customers,
        departments,
        inventory,
        purchaseorders
    }
});
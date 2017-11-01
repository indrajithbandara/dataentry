require('./../bootstrap');
import Vue from 'vue';
import Vuex from 'vuex';
// Modules
import customers from './modules/customers';
import products from './modules/products';
import invoices from './modules/invoices';
// Tasks
import * as getters from './getters';
import * as mutations from './mutations';
import * as actions from './actions';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        permission: 0
    },
    getters,
    mutations,
    actions,
    modules: {
        customers,
        products,
        invoices
    }
});
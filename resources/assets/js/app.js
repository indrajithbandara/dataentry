require('./bootstrap');
window.Vue = require('vue');

// Vuex Store
import { store } from './store/store'

// Parents Components
Vue.component('dashboard', require('./components/dashboard.vue'));
Vue.component('settings', require('./components/settings.vue'));
Vue.component('users', require('./components/users.vue'));
Vue.component('customers', require('./components/customers.vue'));
Vue.component('products', require('./components/products.vue'));
Vue.component('invoices', require('./components/invoices.vue'));


// Parent vue instances when element is present
if (document.getElementById('dashboard-app')) {
    const dashboardApp = new Vue({ el: '#dashboard-app', store: store });
} else if (document.getElementById('settings-app')) {
    const settingsApp = new Vue({ el: '#settings-app', store: store });
} else if (document.getElementById('users-app')) {
    const usersApp = new Vue({ el: '#users-app', store: store });
} else if (document.getElementById('customers-app')) {
    const custApp = new Vue({ el: '#customers-app', store: store });
} else if (document.getElementById('products-app')) {
    const prodApp = new Vue({ el: '#products-app', store: store });
} else if (document.getElementById('invoice-app')) {
    const invApp = new Vue({ el: '#invoice-app', store: store });
}
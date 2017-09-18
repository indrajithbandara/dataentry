
require('./bootstrap');
window.Vue = require('vue');

// Vue Components
Vue.component('dashboard', require('./components/dashboard.vue'));
Vue.component('settings', require('./components/settings.vue'));
Vue.component('users', require('./components/users.vue'));
Vue.component('customers', require('./components/customers.vue'));
Vue.component('products', require('./components/products.vue'));
Vue.component('invoices', require('./components/invoices.vue'));
// Vue.component('purchaseorders', require('./components/purchaseorders.vue'));
// Vue.component('routers', require('./components/routers.vue'));
// Vue.component('inventory', require('./components/inventory.vue'));


// Vue Instances
if (document.getElementById('dashboard-app')) {
    const dashboardApp = new Vue({ el: '#dashboard-app' });
}
if (document.getElementById('settings-app')) {
    const settingsApp = new Vue({ el: '#settings-app' });
}
if (document.getElementById('users-app')) {
    const usersApp = new Vue({ el: '#users-app' });
}
if (document.getElementById('customers-app')) {
    const custApp = new Vue({ el: '#customers-app' });
}
if (document.getElementById('products-app')) {
    const prodApp = new Vue({ el: '#products-app' });
}
if (document.getElementById('invoice-app')) {
    const invApp = new Vue({ el: '#invoice-app' });
}
// if (document.getElementById('purchaseorders-app')) {
//     const purchApp = new Vue({ el: '#purchaseorders-app' });
// }
// if (document.getElementById('routers-app')) {
//     const routApp = new Vue({ el: '#routers-app' });
// }
// if (document.getElementById('inventory-app')) {
//     const invApp = new Vue({ el: '#inventory-app' });
// }

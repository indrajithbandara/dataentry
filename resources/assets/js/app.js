
require('./bootstrap');
window.Vue = require('vue');

// Parents Components
Vue.component('dashboard', require('./components/dashboard.vue'));
Vue.component('settings', require('./components/settings.vue'));
Vue.component('users', require('./components/users.vue'));
Vue.component('customers', require('./components/customers.vue'));
Vue.component('products', require('./components/products.vue'));
Vue.component('invoices', require('./components/invoices.vue'));
// Vue.component('purchaseorders', require('./components/purchaseorders.vue'));
// Vue.component('routers', require('./components/routers.vue'));
// Vue.component('inventory', require('./components/inventory.vue'));


// Parent Vue Instances
if (document.getElementById('dashboard-app')) {
    const dashboardApp = new Vue({ el: '#dashboard-app' });
} else if (document.getElementById('settings-app')) {
    const settingsApp = new Vue({ el: '#settings-app' });
} else if (document.getElementById('users-app')) {
    const usersApp = new Vue({ el: '#users-app' });
} else if (document.getElementById('customers-app')) {
    const custApp = new Vue({ el: '#customers-app' });
} else if (document.getElementById('products-app')) {
    const prodApp = new Vue({ el: '#products-app' });
} else if (document.getElementById('invoice-app')) {
    const invApp = new Vue({ el: '#invoice-app' });
}
// else if (document.getElementById('purchaseorders-app')) {
//     const purchApp = new Vue({ el: '#purchaseorders-app' });
// }
// else if (document.getElementById('routers-app')) {
//     const routApp = new Vue({ el: '#routers-app' });
// }
// else if (document.getElementById('inventory-app')) {
//     const invApp = new Vue({ el: '#inventory-app' });
// }


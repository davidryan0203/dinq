/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('menu-item-category', require('./components/MenuItem/Category.vue').default);
Vue.component('menu-items', require('./components/MenuItem/Items.vue').default);
Vue.component('menu-mixer', require('./components/MenuItem/Mixer.vue').default);
Vue.component('order-list', require('./components/Orders/List.vue').default);
Vue.component('order-payouts', require('./components/Orders/Payouts.vue').default);
Vue.component('customers', require('./components/Customers.vue').default);
Vue.component('waiter', require('./components/Waiter.vue').default);
Vue.component('tax-rates', require('./components/TaxRates.vue').default);
Vue.component('admin-venue', require('./components/Admin/Venue.vue').default);
Vue.component('admin-supplier', require('./components/Admin/Supplier.vue').default);
Vue.component('admin-menu-item', require('./components/MenuItem/AdminItems.vue').default);
Vue.component('dashboard', require('./components/Dashboard/Dashboard.vue').default);
Vue.component('dashboard-order', require('./components/Dashboard/Order.vue').default);
Vue.component('latest-order-list', require('./components/Dashboard/LatestOrders.vue').default);
Vue.component('dashboard-feeds', require('./components/Dashboard/Feeds.vue').default);
Vue.component('dashboard-posts', require('./components/Dashboard/Posts.vue').default);
Vue.component('feeds', require('./components/Feeds.vue').default);
Vue.component('activities', require('./components/Admin/Activities.vue').default);
Vue.component('checkins', require('./components/Checkins.vue').default);
Vue.component('influencers', require('./components/Admin/Influencers.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueToastr from "vue-toastr";
Vue.use(VueToastr, {
  //defaultProgressBar: false,
});
const app = new Vue({
    el: '#app',
});

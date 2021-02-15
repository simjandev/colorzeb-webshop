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
Vue.component('nav-product-search-component', require('./components/nav_product_search_component.vue').default);
Vue.component('navbar-cart-component', require('./components/navbar_cart_component.vue').default);
Vue.component('contact-component', require('./components/contact_component.vue').default);
Vue.component('image-slide-component', require('./components/image_slide_component.vue').default);
Vue.component('product-slide-component', require('./components/product_slide_component.vue').default);
Vue.component('add-to-cart-button-component', require('./components/add_to_cart_button_component.vue').default);
Vue.component('view-product-button-component', require('./components/view_product_button_component.vue').default);
Vue.component('product-details-component', require('./components/product_details_component.vue').default);
Vue.component('cart-item-component', require('./components/cart_item_component.vue').default);
Vue.component('cart-component', require('./components/cart_component.vue').default);
Vue.component('search-filter-component', require('./components/search_filter_component.vue').default);
Vue.component('double-slider-component', require('./components/double_slider_component.vue').default);
Vue.component('order-steps-component', require('./components/order_steps_component.vue').default);
Vue.component('order-login-component', require('./components/order_login_component.vue').default);
Vue.component('order-shipping-component', require('./components/order_shipping_component.vue').default);
Vue.component('user-sidebar-component', require('./components/user_sidebar_component.vue').default);
Vue.component('user-data-component', require('./components/user_data_component.vue').default);

Vue.component('modify-product-component', require('./components/admin/modify_product_component.vue').default);
Vue.component('modify-categories-component', require('./components/admin/modify_categories_component.vue').default);
Vue.component('modify-order-component', require('./components/admin/modify_order_component.vue').default);
Vue.component('admin-sidebar-component', require('./components/admin/admin_sidebar_component.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

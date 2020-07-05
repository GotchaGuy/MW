/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// import App from './App.vue';

window.EventBus = new Vue();

Vue.use(ElementUI);

var moment = require('moment'); // require
moment().format();
// window.moment = require('moment');
// // var moment = require('moment');
// // moment().format();

import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'
Vue.use(VueAwesomeSwiper, /* { default options with global component } */);

import Antd from 'ant-design-vue';
// import App from './App';
import 'ant-design-vue/dist/antd.css';
Vue.config.productionTip = false;

Vue.use(Antd);

window.EventBus = new Vue();

// var sourceMap = require("source-map");

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

Vue.component('el-nav', require('./components/partials/NavigationComponent.vue').default);
Vue.component('donate', require('./components/partials/DrawerDonateFormComponent.vue').default);

Vue.component('campaigns', require('./components/CampaignsComponent.vue').default);
Vue.component('campaign', require('./components/CampaignComponent.vue').default);
Vue.component('campaign-form', require('./components/CampaignFormComponent.vue').default);

Vue.component('following', require('./components/FollowingComponent.vue').default);
Vue.component('posts', require('./components/PostsComponent.vue').default);
Vue.component('post-form', require('./components/PostFormComponent.vue').default);


Vue.component('organization', require('./components/OrganizationComponent.vue').default);

Vue.component('account', require('./components/AccountComponent.vue').default);

Vue.component('register', require('./components/RegisterComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

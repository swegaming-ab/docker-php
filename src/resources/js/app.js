// import 'babel-polyfill';
import Vue from 'vue';
require('./bootstrap');

window.Vue = require('vue');
var Scrollactive = require('vue-scrollactive');
Vue.use(Scrollactive);

import VScrollLock from 'v-scroll-lock';
Vue.use(VScrollLock);

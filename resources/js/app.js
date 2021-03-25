require('./bootstrap')

window.Vue = require('vue')

import store from './store'
import router from './router'

import './permission';

import vuetify from './plugins/vuetify';

import Mixins from './mixins'
Vue.mixin(Mixins);

import './filters'

import './plugins'


Vue.component('app-catering', require('./Main').default)

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store
});

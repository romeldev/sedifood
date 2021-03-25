import Vue from 'vue'
// Vue.use(require('vue-moment'));

// const moment = require('moment')
require('moment/locale/es')

import moment from 'moment-timezone'
 
Vue.use(require('vue-moment'), {
    moment
})
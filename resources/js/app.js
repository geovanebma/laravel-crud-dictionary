const axios = require("axios")
require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import Vuex from 'Vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        item: {}
    }
})

Vue.component('block-component', require('./components/Block.vue').default);
Vue.component('insert-component', require('./components/Insert.vue').default);
Vue.component('dictionary-component', require('./components/Dictionary.vue').default);
Vue.component('phrasal_verbs-component', require('./components/PhrasalVerbs.vue').default);

const app = new Vue({
    el: '#app',
    store
});
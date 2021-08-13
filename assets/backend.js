window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true

import { createApp } from 'vue'
const backend = createApp({
    beforeMount() {
        backend.config.globalProperties.$role = document.getElementById('wrapper').attributes['data-roles'].value;
        store.dispatch('Auth/me', null, {root: true})
    }
})

//Router
import Router from './components/backend/vue-router/router'
backend.use(Router)

//Components
backend.component('backend-base', require('./components/backend/BackendBase').default)
backend.component('page-template', require('./components/backend/components/global/page/PageTemplate').default)

//Vuex
import store from "./vuex/store";
backend.use(store)

//Mount
backend.mount('#wrapper')
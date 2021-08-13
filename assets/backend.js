window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true;
window.axios.defaults.showLoader = true;

import { createApp } from 'vue'
const backend = createApp({
    beforeMount() {
        backend.config.globalProperties.$role = document.getElementById('wrapper').attributes['data-roles'].value;
        window.axios.interceptors.request.use(
            config => {
                if (config.showLoader) {
                    store.dispatch('Loader/pending', null, {root:true});
                }
                return config;
            },
            error => {
                if (error.config.showLoader) {
                    store.dispatch('Loader/done', null, {root:true});
                }
                return Promise.reject(error);
            },
        );
        window.axios.interceptors.response.use(
            response => {
                if (response.config.showLoader) {
                    store.dispatch('Loader/done', null, {root:true});
                }

                return response;
            },
            error => {
                let response = error.response;
                if (response.config.showLoader) {
                    store.dispatch('Loader/done', null, {root:true});
                }
                return Promise.reject(error);
            },
        );

        window.axios.interceptors.response.use(
            response => response,
            error => {
                const {status} = error.response;
                if (status === 401) {
                    location.reload();
                }
                return Promise.reject(error);
            }
        );

        this.$nextTick().then(() => {
            store.dispatch('Auth/me', null, {root: true})
        })
    }
})

//Router
import Router from './components/backend/vue-router/router'
backend.use(Router)

//Components
backend.component('backend-base', require('./components/backend/BackendBase').default)
backend.component('page-template', require('./components/backend/components/global/page/PageTemplate').default)
backend.component('page-header', require('./components/backend/components/global/page/PageHeader').default)
//Vuex
import store from "./vuex/store";
backend.use(store)

//Mount
backend.mount('#wrapper')
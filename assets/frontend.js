import moment from "moment";

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true;
window.axios.defaults.showLoader = true;

import { createApp } from 'vue'
const frontend = createApp({
    beforeMount() {
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
    }
})

//Router
import Router from './components/frontend/vue-router/router'
frontend.use(Router)

//Components
frontend.component('frontend-base', require('./components/frontend/FrontendBase').default)

//Vuex
import store from "./vuex/store";
frontend.use(store)

//Vue Mesa Tables
import VueMesa from "./vue-plugins/VueMesas/index";
frontend.use(VueMesa, {})

//Vue final modal
import vfmPlugin from 'vue-final-modal'
frontend.use(vfmPlugin)

//Form Components
frontend.component('multi-select', require('@vueform/multiselect').default)

//Mount
frontend.mount('#app')
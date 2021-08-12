window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

import { createApp } from 'vue'
const frontend = createApp({})

//Router
import Router from './components/frontend/vue-router/router'
frontend.use(Router)

//Components
frontend.component('frontend-base', require('./components/frontend/FrontendBase').default)

//Mount
frontend.mount('#app')
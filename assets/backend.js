window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

import { createApp } from 'vue'
const backend = createApp({})

//Router
import Router from './components/frontend/vue-router/router'
backend.use(Router)

//Components
backend.component('backend-base', require('./components/backend/BackendBase').default)

//Mount
backend.mount('#app')
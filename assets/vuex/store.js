import { createStore } from 'vuex'
import Auth from './modules/auth'
import Loader from './modules/loader'
const store = createStore({
    modules: {
        Auth, Loader
    }
})

export default store
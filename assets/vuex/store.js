import { createStore } from 'vuex'
import Auth from './modules/auth'
const store = createStore({
    modules: {
        Auth
    }
})

export default store
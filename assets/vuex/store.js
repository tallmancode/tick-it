import { createStore } from 'vuex'
import Auth from './modules/auth'
import Tickets from './modules/tickets'
import Loader from './modules/loader'
const store = createStore({
    modules: {
        Auth, Tickets, Loader
    }
})

export default store
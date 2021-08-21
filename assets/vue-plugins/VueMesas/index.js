//Components
import VueMesas from './src/VueMesa'
import Helpers from './src/js/helpers'
export default {
    install: (app, options) => {
        options = {
            ...options
        }
        app.config.globalProperties.$vueMesa =  Helpers;
        app.component('vue-mesa', VueMesas)
    }
}

//Components
import TmcGravatar from './src/TmcGravatar'
import TmcAvatar from './src/TmcAvatar'
export default {
    install: (app, options) => {
        options = {
            ...options
        }
        app.component('tmc-gravatar', TmcGravatar)
        app.component('tmc-avatar', TmcAvatar)
    }
}

export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: false,
    },

    getters: {
        authenticated (state) {
            return state.authenticated;
        },
        user (state) {
            return state.user;
        },
        usersName (state) {
            console
            return state.user.name+' '+state.user.surname;
        },
        hasRole: (state) => (role) => {
            console.log(state.user)
            if (state.user.length !== 0 && state.user) {
                if(typeof role === 'string'){
                    return state.user.roles.includes(role);
                } else if (typeof role === 'object'){

                } else {
                    return false
                }

            }
            return false;
        },
    },

    mutations: {
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value;
        },

        SET_USER (state, value) {
            state.user = value;
        },

        UPDATES_EMAIL_SETTINGS(state, value) {
            state.user.emailSettings = state.user.emailSettings.filter(exisitng => exisitng.id !== value.id )
        }
    },

    actions: {
        async logOut ({commit}) {
            await axios
                .post('/logout')
                .then((resp) => {
                    if (resp.status === 204) {
                        commit('SET_AUTHENTICATED', false);
                        commit('SET_USER', null);
                        location.reload();
                    }
                })
                .catch((e) => {
                    //TODO: display error to user
                });
        },

        me ({commit, dispatch}) {
            return axios.get('/api/user/me').then((response) => {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', response.data);
                return response.data;
            }).catch((e) => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
                if (e.response.status === 401) {
                    location.reload();
                }
            });
        },

        updateEmailSettings({commit}, values){
            commit('UPDATES_EMAIL_SETTINGS', values)
        }
    },
};

export default {
    namespaced: true,

    state: {
        types: false,
        statuses: false,
        tickets: false
    },

    getters: {
        getTickets(state){
            if(state.tickets){
                return state.tickets
            }

            return []
        },
        getTypes(state){
            if(state.types){
                console.log(state.types)
                return state.types
            }
            return [];
        },
        getStatuses(state){
            if(state.statuses){
                console.log(state.statuses)
                return state.statuses
            }
            return [];
        }
    },

    mutations: {
        SET_TYPES (state, value) {
            state.types = value;
        },
        SET_STATUSES (state, value) {
            state.statuses = value;
        },
        SET_TICKETS (state, value) {
            state.tickets = value;
        }
    },
    actions: {
        fetchTypes({commit}){
            axios
                .get('/api/ticket_types')
                .then((resp) => {
                    commit('SET_TYPES', resp.data['hydra:member'])
                })
        },
        fetchStatuses({commit}){
            axios
                .get('/api/ticket_statuses')
                .then((resp) => {
                    commit("SET_STATUSES", resp.data['hydra:member'])
                })
        },
        fetchTickets({commit}){
            axios
                .get('/api/tickets')
                .then((resp) => {
                    commit('SET_TICKETS', resp.data['hydra:member'])
                })
        },
        createTicket({state}, formData){
            return axios
                .post('/api/tickets', formData, {showLoader: false})
                .then((resp) => {
                   return resp
                }).catch((err) => {
                    return err
                })
        },
        geolocation() {
            return new Promise((resolve, reject) => {
                if(!("geolocation" in navigator)) {
                    reject(new Error('Geolocation is not available.'));
                }

                navigator.geolocation.getCurrentPosition(pos => {
                    resolve(pos);
                }, err => {
                    reject(err);
                });

            });
        },
    },
};

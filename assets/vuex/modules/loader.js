export default {
    namespaced: true,
    state: {
        loading: true,
        requestsPending: 0,
    },
    actions: {
        show({ commit }) {
            commit("show");
        },
        hide({ commit }) {
            commit("hide");
        },
        pending({ commit }) {
            commit("pending");
        },
        done({ commit }) {
            commit("done");
        }
    },
    mutations: {
        show(state) {
            state.loading = true;
        },
        hide(state) {
            state.loading = false;
        },
        pending(state) {
            console.log('bob')
            if (state.requestsPending === 0) {
                this.commit("Loader/show");
            }

            state.requestsPending++;
        },
        done(state) {
            if (state.requestsPending >= 1) {
                state.requestsPending--;
            }
            if (state.requestsPending <= 0) {
                this.commit("Loader/hide");
            }
        }
    }
};

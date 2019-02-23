import connection from '../network';

const SET_USER = 'setUser';

export default {
    namespaced: true,
    state:      {
        user: null
    },
    getters:    {
        isLoggedIn (state) {
            return state.user !== null;
        }
    },
    actions:    {
        attemptLogin ({ commit }, credentials) {
            return connection.post('/login', credentials).then(response => {
                if (response.data.auth) {
                    commit(SET_USER, true);
                }

                return response.data.auth;
            });
        },
        checkAuthenticationState ({ commit }) {
            return connection.get('/loginCheck')
                .then(response => {
                    if (response.data.auth) {
                        commit(SET_USER, true);
                    }
                    return response.data.auth;
                });
        }
    },
    mutations:  {
        [SET_USER] (state, user) {
            state.user = user;
        }
    }
}
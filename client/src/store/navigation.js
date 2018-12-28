export default {
    namespaced: true,
    state: {
        systemId: 1,
        position: {
            x: 1,
            y: 1
        }
    },
    mutations: {
        move(state, {x, y}) {
            state.position.x += x;
            state.position.y += y;
        }
    },
    actions: {
        move({commit, rootGetters}, payload) {
            let canJump = rootGetters['vessel/engine/canJump'];

            if (canJump) {
                commit('move', payload);
                commit('vessel/engine/jump', null, {root: true});
            }
        }
    },
    getters: {
        system(state) {
            return {
                id: state.systemId,
                name: 'Alpha Centari'
            }
        },
        position(state) {
            return state.position;
        }
    }
}

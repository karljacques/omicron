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
        moveUp({commit}) {
            commit('move', {x: 0, y: 1});
        },
        moveDown({commit}) {
            commit('move', {x: 0, y: -1});
        },
        moveLeft({commit}) {
            commit('move', {x: -1, y: 0});
        },
        moveRight({commit}) {
            commit('move', {x: 1, y: 0});
        }
    },
    getters: {
        system(state) {
            return {
                id: state.systemId,
                name: 'null'
            }
        },
        position(state) {
            return state.position;
        }
    }
}

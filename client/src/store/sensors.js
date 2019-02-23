export default {
    namespaced: true,
    state: {
        ships: []
    },
    getters: {
        ships: (state) => state.ships
    },
    mutations: {
        setShips(state, ships) {
            state.ships = ships;
        }
    }
}
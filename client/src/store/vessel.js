import engine from './vessel/engine';

export default {
    namespaced: true,
    state: {
        ship: null
    },
    getters: {
        ship: (state) => state.ship
    },
    mutations: {
        set (state, ship) {
            state.ship = ship;
        }
    },
    modules: {
        engine
    }

}
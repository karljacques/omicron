import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';
import vessel from './store/vessel';
import user from './store/user';
import sensors from './store/sensors';

import network from './network';

const store = new Vuex.Store({
    state:     {
        now: new Date
    },
    mutations: {
        updateTime (state) {
            state.now = new Date
        }
    },
    actions:   {
        start ({ state }) {
            setInterval(() => {
                // I modify this directly from the action as using a mutation
                // fills up the vuex devtool tab
                state.now = new Date;

                //state.now = new Date
            }, 100);
        },
        fetchInitialState ({ commit }) {
            return network.get('/fetchInitialState').then(response => {
                const data = response.data;

                const system = response.data.system;
                const nodes  = response.data.jump_nodes;

                const planets  = response.data.planets;
                const stations = response.data.stations;

                const shipsInSector = response.data.ships_in_sector;

                commit('sensors/setShips', shipsInSector);
                commit('navigation/set', { system, nodes, planets, stations });
                commit('vessel/set', response.data.ship);
            });
        }
    },
    getters:   {
        getTime (state) {
            return state.now.getTime();
        }
    },
    modules:   {
        navigation,
        vessel,
        user,
        sensors
    }
});

export default store;



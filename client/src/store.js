import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';
import vessel from './store/vessel';
import user from './store/user';
import sensors from './store/sensors';
import character from './store/character';
import dockable from './store/dockable';

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

                const system = data.system;
                const nodes  = data.jump_nodes;

                const planets  = data.planets;
                const stations = data.stations;

                const shipsInSector = data.ships_in_sector;

                const character = data.character;

                commit('sensors/setShips', shipsInSector);
                commit('navigation/set', { system, nodes, planets, stations });
                commit('vessel/set', data.ship);
                commit('character/set', character);

                if (data.dockable) {
                    commit('dockable/set', data.dockable);
                }
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
        sensors,
        character,
        dockable
    }
});

export default store;



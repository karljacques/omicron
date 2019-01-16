import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';
import vessel from './store/vessel';
import user from './store/user';
import network from './network';

const store = new Vuex.Store({
    state: {
        now: new Date
    },
    mutations: {
        updateTime(state) {
            state.now = new Date
        }
    },
    actions: {
        start({state}) {
            setInterval(() => {
                // I modify this directly from the action as using a mutation
                // fills up the vuex devtool tab
                state.now = new Date;

                //state.now = new Date
            }, 100);
        },
        fetchInitialState({commit}) {
            return network.get('/fetchInitialState').then(response => {
                const data = response.data;

                const position = {
                    system_id: data.ship.system_id,
                    x: data.ship.position_x,
                    y: data.ship.position_y
                };

                const system = response.data.system;
                const nodes = response.data.jump_nodes;

                commit('navigation/setPosition', position);
                commit('navigation/system/set', {system, nodes});

                commit('vessel/engine/jump', {fuel: response.data.ship.fuel}, {root: true});
            });
        }
    },
    getters: {
        getTime(state) {
            return state.now.getTime();
        }
    },
    modules: {
        navigation,
        vessel,
        user
    }
});

export default store;



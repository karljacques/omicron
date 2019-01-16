import system from './navigation/system';
import sectorTypes from './navigation/sectorTypes';

export default {
    namespaced: true,
    state: {
        position: {
            x: 1,
            y: 1
        }
    },
    mutations: {
        move(state, {x, y}) {
            state.position.x += x;
            state.position.y += y;
        },
        setPosition(state, {x,y}) {
            state.position = {x,y};
        }
    },
    actions: {
        move({commit, rootGetters, getters}, payload) {
            let canJump = rootGetters['vessel/engine/canJump'];

            if (canJump) {
                commit('vessel/engine/jump', {fuelCost: getters.sectorType.moveCost}, {root: true});
                commit('move', payload);
            }
        }
    },
    getters: {
        position(state) {
            return state.position;
        },
        system(state) {
            return state.system;
        },
        sector(state, getters, rootState, rootGetters) {
            let position = state.position;

            return rootGetters['navigation/system/sector'](position);
        },
        sectorType(state, getters, rootState, rootGetters) {
            return rootGetters['navigation/system/sectorType'](getters.sector.sector_type_id);
        }
    },
    modules: {
        system,
        sectorTypes
    }
}

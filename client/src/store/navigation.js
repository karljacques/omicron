import system from './navigation/system';
import sectorTypes from './navigation/sectorTypes';

import network from '../network';

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
        move({commit, rootGetters}, {x,y}) {
            let canJump = rootGetters['vessel/engine/canJump'];

            if (canJump) {
                network.post('move', {x,y}).then(response => {
                    if (response.data.success) {
                        commit('vessel/engine/jump', {fuel: response.data.ship.fuel}, {root: true});
                        commit('move', {x,y});
                    } else {
                        console.error('Unable to jump to co-ordinates');
                    }
                })

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

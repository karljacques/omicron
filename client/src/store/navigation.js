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
        sector(state) {
            let position = state.position;

            let sector = state.system.sectors.find(x => x.position.x === position.x && x.position.y === position.y);

            if (sector) {
                return sector;
            }

            return {
                position: {
                    x: position.x,
                    y: position.y
                },
                type: 1
            }
        },
        sectorType(state, getters) {
            return state.sectorTypes.types.find(x => x.id === getters.sector.type);
        }
    },
    modules: {
        system,
        sectorTypes
    }
}

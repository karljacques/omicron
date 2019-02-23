import system from './navigation/system';
import sectorTypes from './navigation/sectorTypes';

import network from '../network';
import { EventBus } from '../eventBus';

export default {
    namespaced: true,
    state:      {
        position: {
            x: 1,
            y: 1
        },
        dockedAt: null
    },
    mutations:  {
        setPosition (state, { x, y }) {
            state.position = { x, y };
        },
        dock (state, { dockableId }) {

            if (dockableId) {
                EventBus.$emit('game.dock');
            }

            state.dockedAt = dockableId;
        },
        undock (state) {
            EventBus.$emit('game.undock');

            state.dockedAt = null;
        }
    },
    actions:    {
        move ({ commit }, { x, y }) {
            network.post('move', { x, y }).then(response => {
                if (response.data.success) {
                    commit('vessel/engine/jump', { fuel: response.data.ship.fuel }, { root: true });
                    commit('setPosition', { x: response.data.ship.position_x, y: response.data.ship.position_y });
                    commit('sensors/setShips', response.data.ships_in_sector, {root: true});
                } else {
                    console.error('Unable to jump to co-ordinates');
                }
            })
        },
        jump ({ commit }, jumpNodeId) {
            return network.post(`jump/${jumpNodeId}`).then(response => {
                if (response.data.success) {
                    commit('setPosition', {
                        x: response.data.ship.position_x,
                        y: response.data.ship.position_y
                    });

                    const system   = response.data.system;
                    const nodes    = response.data.jump_nodes;
                    const stations = response.data.stations;
                    const planets  = response.data.planets;

                    commit('navigation/system/set', { system, nodes, planets, stations }, { root: true });
                }
            });
        },
        dock ({ commit }, dockableId) {
            return network.post(`dock/${dockableId}`).then(response => {
                if (response.data.success) {
                    commit('dock', {
                        dockableId
                    });

                    return true;
                }
            })
        },
        undock ({ commit }) {
            return network.post(`undock`).then(response => {
                if (response.data.success) {
                    commit('undock');
                }
            })
        }
    },
    getters:    {
        position (state) {
            return state.position;
        },
        system (state) {
            return state.system;
        },
        sector (state, getters, rootState, rootGetters) {
            let position = state.position;

            return rootGetters['navigation/system/sector'](position);
        },
        sectorType (state, getters, rootState, rootGetters) {
            return rootGetters['navigation/system/sectorType'](getters.sector.sector_type_id);
        },
        docked: state => state.dockedAt
    },
    modules:    {
        system,
        sectorTypes
    }
}

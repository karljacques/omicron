import network from '../network';
import { EventBus } from '../eventBus';

export default {
    namespaced: true,
    state:      {
        ship: null
    },
    getters:    {
        ship:     (state) => state.ship,
        position: (state) => ({ x: state.ship ? state.ship.position_x : 0, y: state.ship ? state.ship.position_y : 0 }),
        fuel:     (state) => state.ship ? state.ship.fuel : 0,
        docked:   (state) => state.ship ? state.ship.docked_at !== null : false
    },
    mutations:  {
        set (state, ship) {
            state.ship = ship;
        },
        setPosition (state, { x, y }) {
            state.ship.position_x = x;
            state.ship.position_y = y;
        },
        dock (state, { dockableId }) {

            if (dockableId) {
                EventBus.$emit('game.dock');
            }

            state.ship.docked_at = dockableId;
        },
        undock (state) {
            EventBus.$emit('game.undock');

            state.ship.docked_at = null;
        }
    },
    actions:    {
        move ({ commit }, { x, y }) {
            network.post('move', { x, y }).then(response => {
                if (response.data.success) {
                    commit('set', response.data.ship);
                    commit('sensors/setShips', response.data.ships_in_sector, { root: true });
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

                    commit('navigation/set', { system, nodes, planets, stations }, { root: true });
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
    }

}
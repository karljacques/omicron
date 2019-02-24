import { EventBus } from '../eventBus';

export default {
    namespaced: true,
    state: {
        dockable: null
    },
    mutations: {
        set(state, dockable) {

            if (state.dockable === null && dockable !== null) {
                EventBus.$emit('game.dock');
            }

            state.dockable = dockable;
        }
    },
    getters: {
        name: (state) => state.dockable ? state.dockable.name : null,
        dockable: state => state.dockable
    }
}
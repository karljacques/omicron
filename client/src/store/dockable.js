export default {
    namespaced: true,
    state: {
        dockable: null
    },
    mutations: {
        set(state, dockable) {
            state.dockable = dockable;
        }
    },
    getters: {
        name: (state) => state.dockable ? state.dockable.name : null,
        dockable: state => state.dockable
    }
}
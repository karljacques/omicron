export default {
    namespaced: true,
    state: {
        id: null,
        name: null,
        jumpNodes: [],
        sectors: []
    },
    getters: {
        sector: state => position => {
            let sector = state.sectors.find(sector => sector.x == position.x && sector.y == position.y);

            if (sector) {
                return sector;
            }


            return {
                x: position.x,
                y: position.y,
                sector_type_id: 1
            }
        },
        sectorType: (state, getters, rootState) => sectorTypeId => {
            return rootState.navigation.sectorTypes.types.find(x => x.id === sectorTypeId);
        },
        jumpNodes(state) {
            return state.jumpNodes;
        }
    },
    mutations: {
        set(state, {system, nodes}) {

            state.id = system.id;
            state.name = system.name;
            state.sectors = system.sectors;
            state.size_x = system.size_x;
            state.size_y = system.size_y;

            state.jumpNodes = [...nodes];


        },

    }
}
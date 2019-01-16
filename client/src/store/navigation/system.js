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
                position: {
                    x: position.x,
                    y: position.y
                },
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
        set(state, {id, name, sectors, size_x, size_y}) {
            state.id = id;
            state.name = name;
            state.sectors = sectors;
            state.size_x = size_x;
            state.size_y = size_y;
        }
    }
}
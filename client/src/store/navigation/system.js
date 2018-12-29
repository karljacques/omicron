export default {
    namespaced: true,
    state: {
        id: 1,
        name: 'Alpha Centuri',
        jumpNodes: [
            {
                position: {
                    x: 12,
                    y: 3
                },
                target: {
                    system: 2,
                    x: 1,
                    y: 3
                }
            }
        ],
        sectors: [
            {
                position: {
                    x: 1,
                    y: 1
                },
                type: 2
            },
            {
                position: {
                    x: 1,
                    y: 1
                },
                type: 2
            },
            {
                position: {
                    x: 2,
                    y: 1
                },
                type: 2
            },
            {
                position: {
                    x: 1,
                    y: 2
                },
                type: 3
            }
        ]
    },
    getters: {
        sector: state => position => {
            let sector = state.sectors.find(x => x.position.x === position.x && x.position.y === position.y);

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
        sectorType: (state, getters, rootState) => sectorTypeId => {
            return rootState.navigation.sectorTypes.types.find(x => x.id === sectorTypeId);
        },
        jumpNodes(state){
            return state.jumpNodes;
        }
    }
}
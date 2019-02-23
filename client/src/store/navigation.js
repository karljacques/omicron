export default {
    namespaced: true,
    state:      {
        sectorTypes: [
            {
                id:       1,
                name:     'Deep Space',
                moveCost: 1,
                img:      './sectorTypes/deepSpace.jpg',
                color:    '#000'
            },
            {
                id:       2,
                name:     'Gas Cloud',
                moveCost: 2,
                img:      './sectorTypes/gasCloud.jpg',
                color:    '#ff1571'
            },
            {
                id:       3,
                name:     'Ion Storm',
                moveCost: 3,
                img:      './sectorTypes/ionStorm.jpg',
                color:    '#0472cb'
            }
        ],
        system:      null,
        jumpNodes:   [],
        planets:     [],
        stations:    []
    },
    mutations:  {
        set (state, { system, nodes, planets, stations }) {

            state.system = system;

            state.jumpNodes = [...nodes];
            state.planets   = [...planets];
            state.stations  = [...stations];
        },
    },
    actions:    {},
    getters:    {
        sector:     (state, getters) => position => {
            const sector = getters.sectors.find(sector => sector.x === position.x && sector.y === position.y);

            if (sector) {
                return sector;
            }

            return {
                x:              position.x,
                y:              position.y,
                sector_type_id: 1
            }
        },
        sectorType: (state) => sectorTypeId => {
            return state.sectorTypes.find(x => x.id === sectorTypeId);
        },
        sectors:    state => state.system ? state.system.sectors : [],
        jumpNodes:  state => state.jumpNodes,
        planets:    state => state.planets,
        stations:   state => state.stations,
        system:     state => state.system,
        systemSizeX: state => state.system ? state.system.size_x : 0,
        systemSizeY: state => state.system ? state.system.size_y : 0
    }
}

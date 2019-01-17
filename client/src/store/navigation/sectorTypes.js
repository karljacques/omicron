export default {
    namespaced: true,
    state: {
        types: [
            {
                id: 1,
                name: 'Deep Space',
                moveCost: 1,
                img: './sectorTypes/deepSpace.jpg',
                color: '#000'
            },
            {
                id: 2,
                name: 'Gas Cloud',
                moveCost: 2,
                img: './sectorTypes/gasCloud.jpg',
                color: '#ff1571'
            },
            {
                id: 3,
                name: 'Ion Storm',
                moveCost: 3,
                img: './sectorTypes/ionStorm.jpg',
                color: '#0472cb'
            }
        ]
    }
}
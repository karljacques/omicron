export default {
    namespaced: true,
    state: {
        types: [
            {
                id: 1,
                name: 'Deep Space',
                moveCost: 1,
                img: './sectorTypes/deepSpace.jpg'
            },
            {
                id: 2,
                name: 'Gas Cloud',
                moveCost: 5,
                img: './sectorTypes/gasCloud.jpg'
            }
        ]
    }
}
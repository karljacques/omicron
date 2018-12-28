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
            }
        ]
    },
    getters: {

    }
}
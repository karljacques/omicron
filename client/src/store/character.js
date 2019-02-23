export default {
    namespaced: true,
    state:      {
        character: {
            money: null
        }
    },
    getters:    {
        money: (state) => state.character.money
    },
    mutations:  {
        set (state, character) {
            state.character = character;
        }
    }

}
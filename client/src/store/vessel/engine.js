export default {
    namespaced: true,
    state: {
        coolDownTime: 1000,
        lastJumpTime: null
    },
    getters: {
        canJump(state, getters, rootState) {
            if (state.lastJumpTime === null) {
                return true;
            }

            // Get the current time and see if lastJumpTime + coolDownTime < current
            let currentTime = rootState.now.getTime();

            return state.lastJumpTime + state.coolDownTime < currentTime;
        },
        timeToNextJump(state, getters, rootState) {
            if (getters.canJump) {
                return 0;
            }

            let currentTime = rootState.now.getTime();
            return (state.lastJumpTime + state.coolDownTime) - currentTime;
        },
        coolDownTime(state) {
            return state.coolDownTime;
        }
    },
    mutations: {
        jump(state) {
            state.lastJumpTime = (new Date()).getTime();
        }
    }
}
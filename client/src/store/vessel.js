export default {
    namespaced: true,
    state: {
        engine: {
            coolDownTime: 6000, // In milliseconds,
            lastJumpTime: null
        }
    },
    getters: {
        canJump(state, getters, rootState) {
            if (state.engine.lastJumpTime === null) {
                return true;
            }

            // Get the current time and see if lastJumpTime + coolDownTime < current
            let currentTime = rootState.now.getTime();

            return state.engine.lastJumpTime + state.engine.coolDownTime < currentTime;
        },
        timeToNextJump(state, getters, rootState) {
            if (getters.canJump) {
                return 0;
            }

            let currentTime = rootState.now.getTime();
            return (state.engine.lastJumpTime + state.engine.coolDownTime) - currentTime;
        },
        coolDownTime(state) {
            return state.engine.coolDownTime;
        }
    },
    mutations: {
        jump(state) {
            state.engine.lastJumpTime = (new Date()).getTime();
        }
    }

}
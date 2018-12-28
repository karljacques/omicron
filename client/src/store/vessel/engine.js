export default {
    namespaced: true,
    state: {
        coolDownTime: 125,
        lastJumpTime: null,
        fuel: 125
    },
    getters: {
        canJump(state, getters, rootState) {
            if (state.lastJumpTime === null) {
                return true;
            }

            // Get the current time and see if lastJumpTime + coolDownTime < current
            let currentTime = rootState.now.getTime();

            return state.lastJumpTime + getters.coolDownTime < currentTime;
        },
        timeToNextJump(state, getters, rootState) {
            if (getters.canJump) {
                return 0;
            }

            let currentTime = rootState.now.getTime();
            return (state.lastJumpTime + getters.coolDownTime) - currentTime;
        },
        coolDownTime(state) {
            if (state.fuel > 0) {
                return state.coolDownTime;
            } else {
                return 10000;
            }
        },
        fuel(state) {
            return state.fuel;
        }
    },
    mutations: {
        jump(state, {fuelCost}) {
            state.lastJumpTime = (new Date()).getTime();
            state.fuel -= fuelCost;

            if (state.fuel < 0) {
                state.fuel = 0;
            }
        }
    }
}
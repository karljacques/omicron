import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';
import vessel from './store/vessel';
import user from './store/user';

const store = new Vuex.Store({
    state: {
        now: new Date
    },
    mutations: {
        updateTime(state) {
            state.now = new Date
        }
    },
    actions: {
        start({commit, state}) {
            setInterval(() => {
                // I modify this directly from the action as using a mutation
                // fills up the vuex devtool tab
                state.now = new Date;

                //state.now = new Date
            }, 100);
        }
    },
    getters: {
        getTime(state) {
            return state.now.getTime();
        }
    },
    modules: {
        navigation,
        vessel,
        user
    }
});

export default store;



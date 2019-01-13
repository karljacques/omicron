import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';
import vessel from './store/vessel';
import user from './store/user';

const store = new Vuex.Store({
    // state: {
    //     now: new Date
    // },
    // mutations: {
    //     updateTime(state) {
    //         state.now = new Date
    //     }
    // },
    // actions: {
    //     start({commit}) {
    //         setInterval(() => {
    //             commit('updateTime')
    //         }, 100);
    //     }
    // },
    modules: {
        navigation,
        vessel,
        user
    }
});

export default store;



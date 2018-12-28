import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Import modules
import navigation from './store/navigation';

export default new Vuex.Store({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        navigation
    }
})

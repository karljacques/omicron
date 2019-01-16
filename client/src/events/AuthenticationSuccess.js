import {EventBus} from "../eventBus";
import store from '../store';

EventBus.$on('authentication-success', () => {
    // Trigger Vuex call to get the initial state
    store.dispatch('fetchInitialState');
});
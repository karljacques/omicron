import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'
import store from './store'
import Vuetify from 'vuetify'
import {EventBus} from './eventBus';

Vue.config.productionTip = false;

store.dispatch('start');

Vue.use(Vuetify, {
    theme: {
        primary: '#ffc107',
        secondary: '#607d8b',
        accent: '#ffeb3b',
        error: '#e91e63',
        warning: '#ff5722',
        info: '#009688',
        success: '#4caf50'
    }
});

new Vue({
    router,
    store,
    render: h => h(App),
    mounted() {
        document.addEventListener('keyup', function (evt) {
            EventBus.$emit('keyup', {key: evt.key});
        });
    }
}).$mount('#app');

Vue.filter('currency', function(value) {
   return '$' + (value/100.0).toFixed(2);
});

import './events/AuthenticationSuccess';

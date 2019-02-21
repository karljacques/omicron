import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import SectorInformation from './components/game/navigation/movement/SectorInformation';
import StationOverview from './components/game/docked/station/StationOverview';

export default new Router({
    routes: [
        // {
        //   path: '/about',
        //   name: 'about',
        //   // route level code-splitting
        //   // this generates a separate chunk (about.[hash].js) for this route
        //   // which is lazy-loaded when the route is visited.
        //   component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
        // }
        {
            path:      '/',
            name:      'sector-overview',
            component: SectorInformation
        },
        {
            path: '/StationOverview/',
            name: 'station-overview',
            component: StationOverview
        }
    ]
})

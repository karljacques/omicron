<template>
  <v-app dark>
    <v-toolbar app>
      <v-toolbar-title class="headline text-uppercase">
        <span>OMICRON</span>
        <span class="font-weight-light">BETA</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-content>
        <grid/>
        <position-details/>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>

import Grid from "./components/game/navigation/movement/Grid";
import PositionDetails from "./components/game/navigation/movement/PositionDetails";
export default {
  name: 'App',
    components: {PositionDetails, Grid},
    data () {
    return {
      //
    }
  }
}
</script>

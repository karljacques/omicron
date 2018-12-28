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
        <v-container fluid>
            <v-layout>
                <v-flex xs3>
                    <grid/>
                    <position-details/>
                </v-flex>
                <v-flex xs6>
                    <router-view/>
                </v-flex>
                <v-flex xs3></v-flex>
            </v-layout>
        </v-container>


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

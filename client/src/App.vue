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
                    <status/>
                </v-flex>
                <v-flex xs6>
                    <alerts></alerts>
                    <sector-information></sector-information>
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
import Status from "./components/game/vessel/Status";
import Alerts from "./components/game/general/Alerts";
import SectorInformation from "./components/game/navigation/movement/SectorInformation";
export default {
  name: 'App',
    components: {SectorInformation, Alerts, Status, Grid},
    data () {
    return {
      //
    }
  }
}
</script>

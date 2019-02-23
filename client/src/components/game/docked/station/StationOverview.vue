<template>
    <div v-if="dockable">
        <v-card>
            <v-card-title>
                <h4>Docked at {{ dockable.name }}</h4>

            </v-card-title>
            <v-card-text>
                <b>({{dockable.system.id }}) {{ dockable.system.name }}</b>
                <p>Sector: {{ dockable.position_x }}, {{ dockable.position_y }}</p>
            </v-card-text>
            <v-card-actions>
                <v-btn outline color="primary" @click="undock">Undock</v-btn>
            </v-card-actions>

        </v-card>
        <v-tabs v-model="active">
            <v-tab key="marketplace">Marketplace</v-tab>
            <v-tab-item key="marketplace">
                <v-card>
                    <v-card-text>
                        <marketplace></marketplace>
                    </v-card-text>
                </v-card>

            </v-tab-item>
            <v-tab key="shipyard">Shipyard</v-tab>
            <v-tab-item key="shipyard">

            </v-tab-item>
            <v-tab key="upgrades">Upgrades</v-tab>
            <v-tab-item key="upgrades"></v-tab-item>

        </v-tabs>


    </div>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import Marketplace from './Marketplace';

    export default {
        name:     "StationOverview",
        components: { Marketplace },
        data () {
            return {
                active:  'marketplace',
            }
        },
        methods:  {
            ...mapActions('vessel', ['undock'])
        },
        computed: {
            ...mapGetters('vessel', ['docked']),
            ...mapGetters('dockable', ['dockable']),
        }
    }
</script>

<style scoped>

</style>
<template>
    <div>
        <v-card>
            <v-card-title>
                <h4>Docked at {{ dockable.name }}</h4>

            </v-card-title>
            <v-card-text>
                <b>({{dockable.system.id }}) {{ dockable.system.name }}</b>
                <p>Sector: {{ dockable.position_x }}, {{ dockable.position_y }}</p>
            </v-card-text>
            <v-card-actions>
                <v-btn outline color="warning" @click="undock">Undock</v-btn>
            </v-card-actions>

        </v-card>


    </div>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name:     "StationOverview",
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
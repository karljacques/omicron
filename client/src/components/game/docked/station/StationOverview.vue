<template>
    <div>
        <p>Docked at {{ docked }}</p>
        <v-btn type="success" @click="undock">Undock</v-btn>
    </div>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name:     "StationOverview",
        methods:  {
            ...mapActions('navigation', ['undock'])
        },
        computed: {
            ...mapGetters('navigation', ['docked'])
        }
    }
</script>

<style scoped>

</style>
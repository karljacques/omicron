<template>
    <div>
        <v-alert :value="fuel === 0" type="error">You are out of fuel. Until you refuel, your jumps will be powered by a backup generator with a cooldown time of 10s.</v-alert>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "Alerts",
        computed: {
            ...mapGetters({
                fuel: 'vessel/engine/fuel'
            })
        }
    }
</script>

<style scoped>

</style>
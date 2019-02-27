<template>
    <div style="margin-top:50px;" v-if="ship">
        <h3>Cargo <small>{{ ship.cargo }}/{{ ship.max_cargo }}</small></h3>
        <table>
            <tbody>
                <tr v-for="storable in ship.storables" :key="storable.id">
                    <th>{{ storable.name }}</th>
                    <td>{{ storable.pivot.quantity }}<small v-if="storable.cargo_size > 1"> @{{ storable.cargo_size }}</small></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "Cargo",
        computed: {
            ...mapGetters({
                ship:  'vessel/ship'
            })
        },
    }
</script>

<style scoped>

</style>
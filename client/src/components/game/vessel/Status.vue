<template>
    <div>
        <table>
            <tr>
                <th>Money</th>
                <td> {{ money/100.0 }}</td>
            </tr>
            <tr>
                <th>Fuel</th>
                <td>{{ fuel }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:     "Status",
        computed: {
            ...mapGetters({
                fuel:  'vessel/fuel',
                money: 'character/money'
            })
        }
    }
</script>

<style scoped>

</style>
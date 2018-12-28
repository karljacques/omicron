<template>
    <div>
        <table>
            <tr>
                <th>Fuel</th>
                <td>{{ fuel }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: "Status",
        computed: {
            ...mapGetters({
                fuel: 'vessel/engine/fuel'
            })
        }
    }
</script>

<style scoped>

</style>
<template>
    <table>
        <tr>
            <th>System</th>
            <td>({{ system.id }}) {{ system.name }}</td>
        </tr>
        <tr>
            <th>X</th>
            <td>{{ position.x }}</td>
        </tr>
        <tr>
            <th>Y</th>
            <td>{{ position.y }}</td>
        </tr>
    </table>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "PositionDetails",
        computed: {
            ...mapGetters({
                position: 'navigation/position',
                system: 'navigation/system'
            })
        }
    }
</script>

<style scoped>

</style>
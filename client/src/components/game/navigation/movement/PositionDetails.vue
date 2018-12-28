<template>
    <table>
        <tr>
            <th>System</th>
            <td>{{ $store.getters['navigation/system'].id }}</td>
        </tr>
        <tr>
            <th>X</th>
            <td>{{ $store.getters['navigation/position'].x }}</td>
        </tr>
        <tr>
            <th>Y</th>
            <td>{{ $store.getters['navigation/position'].y }}</td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "PositionDetails"
    }
</script>

<style scoped>

</style>
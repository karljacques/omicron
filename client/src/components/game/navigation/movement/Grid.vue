<template>
    <table>
        <tr>
            <td></td>
            <td><v-icon class="arrow" @click="$store.dispatch('navigation/moveUp')">keyboard_arrow_up</v-icon></td>
            <td></td>
        </tr>
        <tr>
            <td><v-icon class="arrow" @click="$store.dispatch('navigation/moveLeft')">keyboard_arrow_left</v-icon></td>
            <td></td>
            <td><v-icon class="arrow" @click="$store.dispatch('navigation/moveRight')">keyboard_arrow_right</v-icon></td>
        </tr>
        <tr>
            <td></td>
            <td><v-icon class="arrow" @click="$store.dispatch('navigation/moveDown')">keyboard_arrow_down</v-icon></td>
            <td></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "Grid"
    }
</script>

<style scoped>
    .arrow:hover {
        cursor: pointer;
    }

    .arrow {
        user-select: none;
    }
</style>
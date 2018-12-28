<template>
    <table class="navigation-grid">
        <tr>
            <td></td>
            <td>
                <v-icon class="arrow" @click="$store.dispatch('navigation/move', {x: 0, y: 1})">keyboard_arrow_up
                </v-icon>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <v-icon class="arrow" @click="$store.dispatch('navigation/move',  {x: -1, y: 0})">keyboard_arrow_left
                </v-icon>
            </td>
            <td><v-progress-circular
                    v-if="!$store.getters['vessel/canJump']"
                    size="24"
                    indeterminate
                    color="amber"
                    width="1"
            >{{ Math.ceil($store.getters['vessel/timeToNextJump'] / 1000.0) }}</v-progress-circular></td>
            <td>
                <v-icon class="arrow" @click="$store.dispatch('navigation/move',  {x: 1, y: 0})">keyboard_arrow_right
                </v-icon>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <v-icon class="arrow" @click="$store.dispatch('navigation/move',  {x: 0, y: -1})">keyboard_arrow_down
                </v-icon>
            </td>
            <td></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "Grid"
    }
</script>

<style scoped lang="scss">
    .arrow:hover {
        cursor: pointer;
    }

    .arrow {
        user-select: none;
    }

    .navigation-grid td {
        margin:0 auto;
        text-align: center;
    }

</style>
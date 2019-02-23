<template>
    <div>
        <table class="status-table" v-if="ship">
            <tr>
                <th>Money</th>
                <td> {{ money|currency }}</td>
            </tr>
            <tr></tr>
            <tr>
                <th>Fuel</th>
                <td :style="{color: getStatusRowColor(ship.fuel, ship.max_fuel)}">
                    {{ ship.fuel }}/{{ ship.max_fuel }}
                </td>
            </tr>
            <tr>
                <th>Power</th>
                <td :style="{color: getStatusRowColor(ship.power, ship.max_power)}">
                    {{ ship.power }}/{{ ship.max_power }}
                </td>
            </tr>
            <tr></tr>
            <tr>
                <th>Shields</th>
                <td :style="{color: getStatusRowColor(ship.shields, ship.max_shields)}">
                    {{ ship.shields }}/{{ ship.max_shields }}
                </td>
            </tr>
            <tr>
                <th>Armour</th>
                <td :style="{color: getStatusRowColor(ship.armour, ship.max_armour)}">
                    {{ ship.armour }}/{{ ship.max_armour }}
                </td>
            </tr>
            <tr></tr>
            <tr>
                <th>HP</th>
                <td :style="{color: getStatusRowColor(ship.hit_points, ship.max_hit_points)}">
                    {{ ship.hit_points }}/{{ ship.max_hit_points }}
                </td>
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
                money: 'character/money',
                ship:  'vessel/ship'
            })
        },
        methods:  {
            getStatusRowColor (current, max) {
                if (current / max < 0.2) {
                    return '#e91e63'
                } else if (current / max < 0.5) {
                    return '#ff5722';
                } else {
                    return '#4caf50';
                }
            }
        }
    }
</script>

<style scoped>
    .status-table th {
        text-align: left;
    }
</style>
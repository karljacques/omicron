<template>
    <table class="minimap-grid">
        <tr v-for="(row, index) in rows" :key="index">
            <td v-for="(sector, index) in row" :style="'background-color: ' + sector.sectorType.color" :key="index">
                {{ index }}P
            </td>
        </tr>
    </table>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "MiniMap",
        data() {
            return {

            }
        },
        computed: {
            rows() {

                let grid = [];

               for (let relativeY = 0; relativeY < 5; relativeY++) {
                   grid[4-relativeY] = [];

                   for (let relativeX = 0; relativeX < 5; relativeX++ ) {
                       let x = relativeX + this.position.x - 2;
                       let y = relativeY + this.position.y - 2;

                       let sector = this.$store.getters['navigation/system/sector']({x, y});
                       grid[4-relativeY][relativeX] = {
                           sector,
                           sectorType: this.$store.getters['navigation/system/sectorType'](sector.type)
                       };
                   }
               }

               return grid;
            },
            ...mapGetters({
                system: 'navigation/system',
                position: 'navigation/position'
            })
        }
    }
</script>

<style scoped>
    .minimap-grid td {
        width:30px;
        height:30px;
    }
</style>
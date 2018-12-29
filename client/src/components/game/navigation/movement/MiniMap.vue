<template>
    <table>
        <tr v-for="(row, index) in rows" :key="index">
            <td v-for="(sector, index) in row" :style="'background-color: ' + sector.sectorType.color" :key="index">
                {{ index }}
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
                let sectors = this.system.sectors;

                let upperX = this.position.x + 2; // ToDo: Make this less than system upper bound
                let upperY = this.position.y + 2;

                let lowerX = Math.max(this.position.x, 0);
                let lowerY = Math.max(this.position.y, 0);

                let grid = [];

               for (let relativeX = 0; relativeX < 5; relativeX++) {
                   grid[relativeX] = [];

                   for (let relativeY = 0; relativeY < 5; relativeY++ ) {
                       let x = relativeX + this.position.x - 2;
                       let y = relativeY + this.position.y - 2;

                       let sector = this.$store.getters['navigation/system/sector']({x, y});
                       grid[relativeX][relativeY] = {
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

</style>
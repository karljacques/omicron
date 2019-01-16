<template>
    <table class="minimap-grid">
        <tr v-for="(row, index) in rows" :key="index">
            <td v-for="(sector, index) in row" :style="'background-color: ' + getSectorColor(sector)" :key="index">
                {{ sector.letter }}
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
                           sectorType: this.$store.getters['navigation/system/sectorType'](sector.sector_type_id),
                           letter: this.getSectorLetter(x,y)
                       };
                   }
               }

               return grid;
            },
            ...mapGetters({
                system: 'navigation/system',
                position: 'navigation/position',
                jumpNodes: 'navigation/system/jumpNodes'
            })
        },
        methods: {
            getSectorLetter(x, y) {
                let node = this.jumpNodes.find(n => n.position.x === x && n.position.y === y);

                if (node) {
                    return 'N';
                }

                return '';
            },
            getSectorColor(sector) {
                if (sector.sector.x <= 0 || sector.sector.y <= 0) {
                    return '#333';
                }

                return sector.sectorType.color;
            }
        }
    }
</script>

<style scoped>
    .minimap-grid td {
        width:30px;
        height:30px;

        text-align: center;
    }
</style>
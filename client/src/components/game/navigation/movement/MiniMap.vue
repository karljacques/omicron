<template>
    <table class="minimap-grid">
        <tr v-for="(row, index_y) in rows" :key="index_y">
            <td v-for="(sector, index_x) in row" :style="'background-color: ' + getSectorColor(sector)" :key="index_x" :class="index_x == mapSize && mapSize == index_y ? 'current-location' : ''">
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
                mapSize: 5
            }
        },
        computed: {
            rows() {

                let grid = [];

                for (let relativeY = 0; relativeY < (this.mapSize*2) + 1; relativeY++) {
                    grid[(this.mapSize*2) - relativeY] = [];

                    for (let relativeX = 0; relativeX < (this.mapSize*2) + 1; relativeX++) {
                        let x = relativeX + this.position.x - this.mapSize;
                        let y = relativeY + this.position.y - this.mapSize;

                        let sector = this.$store.getters['navigation/system/sector']({x, y});

                        grid[(this.mapSize*2) - relativeY][relativeX] = {
                            sector,
                            sectorType: this.$store.getters['navigation/system/sectorType'](sector.sector_type_id),
                            letter: this.getSectorLetter(x, y)
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
                let node = this.jumpNodes.find(n => n.source_x === x && n.source_y === y);

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
        width: 30px;
        height: 30px;

        text-align: center;
    }

    .current-location {
        border: 2px solid green;
    }
</style>
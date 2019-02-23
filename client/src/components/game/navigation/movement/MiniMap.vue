<template>
    <table class="minimap-grid">
        <tr v-for="(row, index_y) in rows" :key="index_y">
            <td v-for="(sector, index_x) in row" :style="'background-color: ' + getSectorColor(sector)" :key="index_x"
                :class="getSectorClassList(sector)">
                {{ sector.letter }}
            </td>
        </tr>
    </table>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:     "MiniMap",
        data () {
            return {
                mapSize: 4
            }
        },
        computed: {
            rows () {

                let grid = [];

                for (let relativeY = 0; relativeY < (this.mapSize * 2) + 1; relativeY++) {
                    grid[(this.mapSize * 2) - relativeY] = [];

                    for (let relativeX = 0; relativeX < (this.mapSize * 2) + 1; relativeX++) {
                        let x = relativeX + this.position.x - this.mapSize;
                        let y = relativeY + this.position.y - this.mapSize;

                        let sector = this.sector({ x, y });

                        grid[(this.mapSize * 2) - relativeY][relativeX] = {
                            sector,
                            sectorType: this.sectorType(sector.sector_type_id),
                            letter:     this.getSectorLetter(x, y)
                        };
                    }
                }

                return grid;
            },
            ...mapGetters({
                position: 'vessel/position'
            }),
            ...mapGetters('navigation', [
                'jumpNodes',
                'planets',
                'stations',
                'sectorType',
                'sector',
                'system',
                'systemSizeX',
                'systemSizeY'
            ])
        },
        methods:  {
            getSectorLetter (x, y) {
                const node    = this.jumpNodes.find(n => n.source_x === x && n.source_y === y);
                const station = this.stations.find(s => s.position_x === x && s.position_y === y);
                const planet  = this.planets.find(p => p.position_x === x && p.position_y === y);

                let str = ''

                if (station) {
                    str += 'S';
                }

                if (planet) {
                    str += 'P';
                }

                if (node) {
                    str += 'N';
                }

                return str;
            },
            getSectorColor (sector) {
                if (sector.sector.x <= 0 || sector.sector.y <= 0) {
                    return '#333';
                }

                return sector.sectorType.color;
            },
            getSectorClassList (sector) {
                return {
                    'current-location': sector.sector.x === this.position.x && sector.sector.y === this.position.y,
                    'top-edge':         sector.sector.y === this.systemSizeY + 1 && sector.sector.x <= this.systemSizeX && sector.sector.x > 0,
                    'right-edge':       sector.sector.x === this.systemSizeX + 1 && sector.sector.y <= this.systemSizeY && sector.sector.y > 0,
                    'bottom-edge':      sector.sector.y === 0 && sector.sector.x > 0 && sector.sector.x <= this.systemSizeX,
                    'left-edge':        sector.sector.x === 0 && sector.sector.y > 0 && sector.sector.y <= this.systemSizeY,
                };
            }
        }
    }
</script>

<style scoped lang="scss">
    .minimap-grid td {
        width: 30px;
        height: 30px;

        text-align: center;
    }

    .minimap-grid td.current-location {
        border: 2px solid rgb(255, 255, 255);
    }

    $border-color: #ff001e;

    .top-edge {
        border-bottom: 2px dotted $border-color;
    }

    .right-edge {
        border-left: 2px dotted $border-color;
    }

    .left-edge {
        border-right: 2px dotted $border-color;
    }

    .bottom-edge {
        border-top: 2px dotted $border-color;
    }
</style>
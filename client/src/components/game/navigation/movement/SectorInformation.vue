<template>
    <v-container>
        <v-layout>
            <v-flex xs4>
                <v-card height="100%">
                    <v-img class="sector-image" :src="sectorType.img"></v-img>
                    <v-card-title primary-title>
                        <div>
                            <h3>{{ sectorType.name }}</h3>
                            <p>Move Cost: {{ sectorType.moveCost }}</p>

                            <h4>({{ system.id }}) {{ system.name }}</h4>
                            <p>Sector {{ position.x }}.{{ position.y }}</p>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
            <v-flex xs4 v-if="jumpNodeInSector">
                <v-card height="100%">
                    <v-img class="jump-node-image" src="jump_node.jpg"></v-img>
                    <v-card-title primary-title>
                        <div>
                            <h3>Jump Node</h3>
                            <p>Destination: {{ jumpNodeInSector.destination_system_id }}.{{
                                jumpNodeInSector.destination_x
                                }}.{{
                                jumpNodeInSector.destination_y }}</p>
                            <v-btn :loading="jumping" color="primary" outline @click="onJumpClick">Jump</v-btn>

                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
            <v-flex xs4 v-if="planetInSector">
                <v-card height="100%">
                    <v-img class="jump-node-image" src="planet.jpg"></v-img>
                    <v-card-title primary-title>
                        <div>
                            <h3>{{ planetInSector.name }}</h3>
                            <p><b>Habitable Planet</b><br> Population: {{ planetInSector.population.toLocaleString() }}
                            </p>
                            <v-btn color="primary" outline @click="onClickDock(planetInSector.id)">Land</v-btn>

                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
            <v-flex xs4 v-if="stationInSector">
                <v-card height="100%">
                    <v-img class="jump-node-image" :src="planetInSector ? 'station_planet.jpg' : 'station.jpg'"></v-img>
                    <v-card-title primary-title>
                        <div>
                            <h3>{{ stationInSector.name }}</h3>
                            <p>Capacity: {{ stationInSector.capacity }} <br> Ships Docked: 0</p>
                            <v-btn color="primary" outline @click="onClickDock(stationInSector.id)">Dock</v-btn>

                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>


        </v-layout>
        <h3 v-if="shipsInSector.length > 1">Ships in sector</h3>
        <v-layout>
            <v-flex xs12 v-for="ship in shipsInSector" :key="ship.id" v-if="ship.id !== currentShip.id">
                <v-card>
                    <v-card-title>
                        <h4>{{ ship.name }}</h4>
                    </v-card-title>
                    <v-card-text>
                        Level 1
                    </v-card-text>
                    <v-card-actions>
                        <v-btn>Attack</v-btn>
                        <v-btn>Message</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import { EventBus } from '../../../../eventBus';

    export default {
        name:     "SectorInformation",
        data () {
            return {
                jumping: false
            }
        },
        methods:  {
            onJumpClick () {
                this.jumping = true;

                this.jump(this.jumpNodeInSector.id).then(() => {
                    this.jumping = false;
                });
            },
            onClickDock (dockableId) {
                this.dock(dockableId).then(success => {
                    if (success) {
                        EventBus.$emit('game.docked');
                    }
                });
            },
            ...mapActions({
                jump:   'navigation/jump',
                dock:   'navigation/dock',
                undock: 'navigation/undock'
            })
        },
        computed: {
            ...mapGetters({
                sector:        'navigation/sector',
                sectorType:    'navigation/sectorType',
                system:        'navigation/system',
                position:      'navigation/position',
                docked:        'navigation/docked',
                shipsInSector: 'sensors/ships',
                currentShip:   'vessel/ship'
            }),
            ...mapGetters('navigation/system', [
                'jumpNodes',
                'planets',
                'stations'
            ]),
            jumpNodeInSector () {
                return this.jumpNodes.find(x => x.source_x === this.position.x && x.source_y === this.position.y);
            },
            planetInSector () {
                return this.planets.find(x => x.position_x === this.position.x && x.position_y === this.position.y)
            },
            stationInSector () {
                return this.stations.find(s => s.position_x === this.position.x && s.position_y === this.position.y);
            }

        }

    }
</script>

<style scoped>
    .sector-image {
        height: 200px;
        object-fit: cover;
    }

    .jump-node-image {
        height: 200px;
        object-fit: cover;
    }
</style>
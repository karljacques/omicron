<template>
    <v-container>
        <v-layout>
            <v-flex xs2>
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
            <v-flex xs2>
                <v-card v-if="jumpNodeInSector" height="100%">
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
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "SectorInformation",
        data() {
            return {
                jumping: false
            }
        },
        methods: {
            onJumpClick() {
                this.jumping = true;

                this.jump(this.jumpNodeInSector.id).then(() => {
                    this.jumping = false;
                });
            },
            ...mapActions({
                jump: 'navigation/jump'
            })
        },
        computed: {
            ...mapGetters({
                sector: 'navigation/sector',
                sectorType: 'navigation/sectorType',
                system: 'navigation/system',
                position: 'navigation/position',
                jumpNodes: 'navigation/system/jumpNodes'
            }),
            jumpNodeInSector() {
                return this.jumpNodes.find(x => x.source_x === this.position.x && x.source_y === this.position.y);
            },

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
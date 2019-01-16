<template>
    <div>
        <v-card>
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
        <v-card v-if="jumpNodeInSector">
            <v-card-title primary-title>
                <div>
                    <h3>Jump Node</h3>
                    <p>Destination: {{ jumpNodeInSector.destination_system_id }}.{{ jumpNodeInSector.destination_x }}.{{ jumpNodeInSector.destination_y }}</p>
                    <v-btn color="primary" outline>Jump</v-btn>

                </div>
            </v-card-title>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "SectorInformation",
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
            }
        }

    }
</script>

<style scoped>
    .sector-image {
        height: 75px;
        object-fit: cover;
    }
</style>
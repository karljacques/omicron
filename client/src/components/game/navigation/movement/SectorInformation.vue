<template>
    <div>
        <img class="sector-image" :src="sectorType.img">

        <h2>{{ sectorType.name }}</h2>
        <p>Move Cost: {{ sectorType.moveCost }}</p>



        <h3>({{ system.id }}) {{ system.name }}</h3>
        <p>Sector {{ position.x }}.{{ position.y }}</p>
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
                position: 'navigation/position'
            })
        }

    }
</script>

<style scoped>
    .sector-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 1px solid grey;
        position: relative;
        right: 0;
        top: 0;
        float: right;
    }
</style>
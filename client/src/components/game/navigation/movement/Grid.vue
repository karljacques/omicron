<template>
    <div>
        <table class="navigation-grid" :class="{'disabled' : !canJump}">
            <tr>
                <td></td>
                <td>
                    <v-icon v-if="upMoveExists" class="arrow" @click="move({x: 0, y: 1})">keyboard_arrow_up
                    </v-icon>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <v-icon v-if="leftMoveExists" class="arrow" @click="move({x: -1, y: 0})">
                        keyboard_arrow_left
                    </v-icon>
                </td>
                <td>
                </td>
                <td>
                    <v-icon v-if="rightMoveExists" class="arrow" @click="move({x: 1, y: 0})">
                        keyboard_arrow_right
                    </v-icon>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <v-icon v-if="downMoveExists" class="arrow" @click="move({x: 0, y: -1})">
                        keyboard_arrow_down
                    </v-icon>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import { EventBus } from '../../../../eventBus';

    export default {
        name:    "Grid",
        methods: {
            ...mapActions({
                move: 'vessel/move'
            })
        },

        mounted () {
            EventBus.$on('keyup', ({ key }) => {
                switch (key) {
                    case 'ArrowUp':
                        this.move({ x: 0, y: 1 });
                        break;
                    case 'ArrowDown':
                        this.move({ x: 0, y: -1 });
                        break;
                    case 'ArrowLeft':
                        this.move({ x: -1, y: 0 });
                        break;
                    case 'ArrowRight':
                        this.move({ x: 1, y: 0 });
                        break;
                }

            });
        },
        computed: {
            ...mapGetters({
                systemSizeX: 'navigation/systemSizeX',
                systemSizeY: 'navigation/systemSizeY',
                position:    'vessel/position'
            }),
            upMoveExists () {
                return this.systemSizeY > this.position.y;
            },
            downMoveExists () {
                return this.position.y > 1;
            },
            leftMoveExists () {
                return this.position.x > 1;
            },
            rightMoveExists () {
                return this.systemSizeX > this.position.x;
            },
            canJump () {
                return true;
            }
        }
    }
</script>

<style scoped lang="scss">
    .arrow:hover {
        cursor: pointer;
    }

    .arrow, .navigation-grid {
        user-select: none;
    }

    .navigation-grid td {
        margin: 0 auto;
        text-align: center;
        width: 24px;
        height: 24px;
    }

    .navigation-grid.disabled .arrow, .arrow.disabled {
        color: #696969;
    }

</style>
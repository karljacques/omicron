<template>
    <div>
        <h2>Buy</h2>
        <v-data-table :headers="headers" :items="fromServer">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.stock }}</td>
                <td>{{ props.item.price|currency }}</td>
                <td>
                    <v-text-field v-model="quantities[props.item.id]" type="number"
                                  placeholder="Quantity"></v-text-field>
                </td>
                <td>{{ calculateTotalCost(props.item)|currency }}
                </td>
                <td>
                    <v-btn color="primary" outline @click="buy(props.item)"
                           :disabled="!quantities[props.item.id] || (calculateTotalCost(props.item) > money)">Buy
                    </v-btn>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import { mapGetters, mapMutations } from 'vuex';
    import network from '../../../../network';

    export default {
        name:     "Marketplace",
        computed: {
            ...mapGetters('vessel', ['ship']),
            ...mapGetters('character', ['money']),
            fuelRequired () {
                const diff = this.ship.max_fuel - this.ship.fuel;
                if (diff < 0) {
                    return 0;
                }

                return diff;
            }
        },
        created () {
            this.$set(this.quantities, 1, this.fuelRequired);
        },
        data () {
            return {
                headers:    [
                    {
                        text:  'Commodity',
                        value: 'name'
                    },
                    {
                        text:  'In Stock',
                        value: 'stock'
                    },
                    {
                        text:  'Price',
                        value: 'price'
                    }, {
                        text:     'Quantity',
                        value:    null,
                        sortable: false
                    },
                    {
                        text:     'Total',
                        value:    null,
                        sortable: false
                    },
                    {
                        value:    null,
                        sortable: false
                    }
                ],
                fromServer: [
                    {
                        id:    1,
                        name:  'Fuel',
                        price: 2500,
                        stock: 2032
                    },
                    {
                        id:    2,
                        name:  'Metals',
                        price: 3200,
                        stock: 200
                    },
                    {
                        id:    3,
                        name:  'Chemicals',
                        price: 7800,
                        stock: 200
                    }
                ],
                quantities: {}
            }
        },
        methods:  {
            ...mapMutations({
                setCharacter: 'character/set',
                setShip:      'vessel/set'
            }),
            calculateTotalCost (item) {
                return (this.quantities[item.id] ? Math.min(item.stock, this.quantities[item.id]) : 0) * item.price;
            },
            buy (item) {
                network.post('/marketplace/buy', {
                    commodity_id: item.id,
                    quantity:     this.quantities[item.id]
                }).then(response => {
                    if (response.data.success) {
                        this.setCharacter(response.data.character);
                        this.setShip(response.data.ship);

                        this.$delete(this.quantities, item.id);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
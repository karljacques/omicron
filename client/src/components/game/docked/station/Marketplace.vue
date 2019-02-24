<template>
    <div>
        <h2>Buy</h2>
        <v-data-table :headers="headers" :items="fromServer">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.commodity.name }}</td>
                <td>{{ props.item.stock }}</td>
                <td>{{ props.item.sell|currency }}</td>
                <td>
                    <v-text-field v-model="quantities[props.item.commodity_id]" type="number"
                                  placeholder="Quantity"></v-text-field>
                </td>
                <td>{{ calculateTotalCost(props.item)|currency }}
                </td>
                <td>
                    <v-btn color="primary" outline @click="buy(props.item)"
                           :disabled="!quantities[props.item.commodity_id] || (calculateTotalCost(props.item) > money)">
                        Buy
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

            network.post('/marketplace/get/' + this.ship.docked_at).then(response => {
                this.fromServer = response.data.commodities_sold;
            });
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
                fromServer: [],
                quantities: {}
            }
        },
        methods:  {
            ...mapMutations({
                setCharacter: 'character/set',
                setShip:      'vessel/set'
            }),
            calculateTotalCost (item) {
                return (this.quantities[item.commodity_id] ? Math.min(item.stock, this.quantities[item.commodity_id]) : 0) * item.sell;
            },
            buy (item) {
                network.post('/marketplace/buy', {
                    commodity_id: item.commodity_id,
                    quantity:     this.quantities[item.commodity_id],
                    price:        item.sell
                }).then(response => {
                    if (response.data.success) {
                        this.setCharacter(response.data.character);
                        this.setShip(response.data.ship);

                        this.$delete(this.quantities, item.commodity_id);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
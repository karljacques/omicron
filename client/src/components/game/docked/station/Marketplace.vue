<template>
    <div>
        <h2>Buy</h2>
        <v-data-table :headers="headers" :items="fromServer">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.stock }}</td>
                <td>{{ props.item.price|currency }}</td>
                <td>
                    <v-text-field v-model="quantities[props.item.id]" type="number" placeholder="Quantity"></v-text-field>
                </td>
                <td>{{ (quantities[props.item.id] ? Math.min(props.item.stock, quantities[props.item.id]) : 0) * props.item.price|currency }}</td>
                <td>
                    <v-btn color="primary" outline>Buy</v-btn>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:     "Marketplace",
        computed: {
            ...mapGetters('vessel', ['ship']),
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
                test: 'hello',
                headers: [
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
                        text: 'Quantity',
                        value:    null,
                        sortable: false
                    },
                    {
                        text: 'Total',
                        value: null,
                        sortable: false
                    },
                    {
                        value:    null,
                        sortable: false
                    }
                ],
                fromServer: [
                    {
                        id: 1,
                        name:  'Fuel',
                        price: 2500,
                        stock: 2032
                    },
                    {
                        id: 2,
                        name:  'Metals',
                        price: 3200,
                        stock: 200
                    },
                    {
                        id: 3,
                        name:  'Chemicals',
                        price: 7800,
                        stock: 200
                    }
                ],
                quantities: {
                }
            }
        }
    }
</script>

<style scoped>

</style>
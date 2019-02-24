<template>
    <v-data-table :headers="headers" :items="items">
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
                <v-btn color="primary" outline @click="onClickAction(props.item)"
                       :disabled="!quantities[props.item.commodity_id] || (calculateTotalCost(props.item) > money)">
                    Buy
                </v-btn>
            </td>
        </template>
    </v-data-table>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name:     "MarketTable",
        props:    {
            fuelRequired: {
                required: false
            },
            action:       {
                required: true
            },
            items:        {
                required: true
            }
        },
        computed: {
            ...mapGetters('character', ['money']),
        },
        methods:  {
            calculateTotalCost (item) {
                const quantity = this.quantities[item.commodity_id] ? Math.min(item.stock, this.quantities[item.commodity_id]) : 0;
                return quantity * item.sell;
            },
            onClickAction (item) {
                this.$emit('transaction', {
                    item,
                    action:   this.action,
                    quantity: this.quantities[item.commodity_id]
                });

                this.$delete(this.quantities, item.commodity_id);
            }
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
                quantities: {}
            }
        },
        created () {
            this.$set(this.quantities, 1, this.fuelRequired);
        }
    }
</script>

<style scoped>

</style>
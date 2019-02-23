<template>
    <div>
        <h2>Buy</h2>
        <v-data-table :headers="headers" :items="items">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.quantity }}</td>
                <td>{{ props.item.price|currency }}</td>
                <td>
                    <v-text-field type="number" placeholder="Quantity"></v-text-field>
                </td>
                <td>
                    <v-btn color="primary" outline>Buy</v-btn>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    export default {
        name: "Marketplace",
        data () {
            return {
                headers: [
                    {
                        text:  'Commodity',
                        value: 'name'
                    },
                    {
                        text:  'In Stock',
                        value: 'quantity'
                    },
                    {
                        text:  'Price',
                        value: 'price'
                    }, {
                        value: null,
                        sortable: false
                    }, {
                        value: null,
                        sortable: false
                    }
                ],
                items:   [
                    {
                        name:     'Fuel',
                        price:    2500,
                        quantity: 532
                    },
                    {
                        name:     'Metals',
                        price:    3200,
                        quantity: 200
                    },
                    {
                        name:     'Chemicals',
                        price:    7800,
                        quantity: 200
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
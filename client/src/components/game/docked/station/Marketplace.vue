<template>
    <div>
        <h2>Buy</h2>
        <market-table :fuel-required="fuelRequired"
                      action="buy"
                      :items="sold"
                      @transaction="onTransaction"/>

        <h2>Sell</h2>
        <market-table action="sell"
                      :items="bought"
                      @transaction="onTransaction"/>
    </div>
</template>

<script>
    import { mapGetters, mapMutations } from 'vuex';
    import network from '../../../../network';
    import MarketTable from './MarketTable';

    export default {
        name:       "Marketplace",
        components: { MarketTable },
        computed:   {
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
            network.post('/marketplace/get/' + this.ship.docked_at).then(response => {
                this.bought = response.data.commodities_bought;
                this.sold   = response.data.commodities_sold;
            });
        },
        data () {
            return {
                bought: [],
                sold:   []
            }
        },
        methods:    {
            ...mapMutations({
                setCharacter: 'character/set',
                setShip:      'vessel/set'
            }),

            onTransaction ({ item, action, quantity }) {
                // Swap the price from the action
                const costField = action === 'buy' ? 'sell' : 'buy';
                network.post('/marketplace/' + action, {
                    commodity_id: item.commodity_id,
                    quantity:     quantity,
                    price:        item[costField]
                }).then(response => {
                    if (response.data.success) {
                        this.setCharacter(response.data.character);
                        this.setShip(response.data.ship);
                    }

                });
            }
        }
    }
</script>

<style scoped>

</style>
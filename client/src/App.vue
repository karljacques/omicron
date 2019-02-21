<template>
    <v-app dark>
        <v-toolbar app>
            <v-toolbar-title class="headline text-uppercase">
                <span>OMICRON</span>
                <span class="font-weight-light">BETA</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>

        <v-content v-if="$store.getters['user/isLoggedIn']">
            <v-container fluid>
                <v-layout>
                    <v-flex xs1>
                        <grid/>
                        <status/>
                    </v-flex>
                    <v-flex xs9>
                        <v-container grid-list-md>
                            <v-layout>
                                <v-flex xs12>
                                    <alerts></alerts>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <router-view/>
                                </v-flex>
                            </v-layout>
                        </v-container>

                    </v-flex>
                    <v-flex xs2>
                        <mini-map></mini-map>
                    </v-flex>
                </v-layout>
            </v-container>


        </v-content>

        <LoginModal v-if="modals.showLoginModal"/>
    </v-app>
</template>

<script>

    import Grid from "./components/game/navigation/movement/Grid";
    import Status from "./components/game/vessel/Status";
    import Alerts from "./components/game/general/Alerts";
    import MiniMap from "./components/game/navigation/movement/MiniMap";
    import { EventBus } from "./eventBus";
    import LoginModal from './components/authentication/LoginModal';

    export default {
        name:       'App',
        components: { LoginModal, MiniMap, Alerts, Status, Grid },
        data () {
            return {
                modals:   {
                    showLoginModal: false
                }
            }
        },
        created () {
            this.$store.dispatch('user/checkAuthenticationState').then(authenticated => {
                this.modals.showLoginModal = !authenticated;

                if (authenticated) {
                    EventBus.$emit('authentication-success');
                }
            });

            EventBus.$on('authentication-success', () => {
               this.modals.showLoginModal = false;
            });
        }
    }
</script>

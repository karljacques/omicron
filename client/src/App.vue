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
                                    <sector-information></sector-information>
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

        <v-dialog :value="modals.showLoginModal" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <h1>Login</h1>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-flex>
                            <v-text-field v-model="email" label="Email"></v-text-field>
                            <v-text-field v-model="password" type="password" label="Password"></v-text-field>
                        </v-flex>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="attemptLogin">Login</v-btn>
                </v-card-actions>

            </v-card>

        </v-dialog>
    </v-app>
</template>

<script>

    import Grid from "./components/game/navigation/movement/Grid";
    import Status from "./components/game/vessel/Status";
    import Alerts from "./components/game/general/Alerts";
    import SectorInformation from "./components/game/navigation/movement/SectorInformation";
    import MiniMap from "./components/game/navigation/movement/MiniMap";
    import {EventBus} from "./eventBus";

    export default {
        name: 'App',
        components: {MiniMap, SectorInformation, Alerts, Status, Grid},
        data() {
            return {
                modals: {
                    showLoginModal: false
                },
                email: '',
                password: ''
            }
        },
        created() {
            this.$store.dispatch('user/checkAuthenticationState').then(authenticated => {
                this.modals.showLoginModal = !authenticated;

                if (authenticated) {
                    EventBus.$emit('authentication-success');
                }
            });

            document.addEventListener('keyup', function(e) {
                EventBus.$emit('keyup', e.key);
            });

            EventBus.$on('keyup', (key) => {
                if (key === 'Enter' && this.modals.showLoginModal) {
                    this.attemptLogin();
                }
            })
        },
        methods: {
            attemptLogin() {
                this.$store.dispatch('user/attemptLogin', {
                    email: this.email,
                    password: this.password
                })
                    .then(authenticated => {
                        this.modals.showLoginModal = !authenticated;

                        if (authenticated) {
                            EventBus.$emit('authentication-success');
                        }
                    });
            }
        }
    }
</script>

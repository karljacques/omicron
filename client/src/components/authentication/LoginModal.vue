<template>
    <v-dialog :value="true" persistent max-width="600px">
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
</template>

<script>
    import { EventBus } from '../../eventBus';

    export default {
        name:    "LoginModal",
        data () {
            return {
                email:    '',
                password: ''
            }
        },
        created () {
            EventBus.$on('keyup', this.onKeyPress);
        },
        destroyed () {
            EventBus.$off('keyup', this.onKeyPress);
        },
        methods: {
            onKeyPress ({ key }) {
                if (key === 'Enter' && this.modals.showLoginModal) {
                    this.attemptLogin();
                }
            },
            attemptLogin () {
                this.$store.dispatch('user/attemptLogin', {
                    email:    this.email,
                    password: this.password
                })
                    .then(authenticated => {
                        if (authenticated) {
                            EventBus.$emit('authentication-success');
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>
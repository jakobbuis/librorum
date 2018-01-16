<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <span class="md-title">Login</span>
            </md-app-toolbar>

            <md-app-content>
                <form novalidate class="md-layout-row md-gutter" @submit.prevent="login">
                    <md-card class="md-flex-50 md-flex-small-100">
                        <md-card-header>
                            <div class="md-title">Login to start using librorum</div>
                        </md-card-header>

                        <md-progress-bar md-mode="indeterminate" v-if="sending" />

                        <md-card-content>
                            <md-field>
                                <label for="email">Email</label>
                                <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
                            </md-field>

                            <md-field>
                                <label for="password">Password</label>
                                <md-input type="password" name="password" id="password" autocomplete="password" v-model="form.password" :disabled="sending" />
                            </md-field>
                        </md-card-content>

                        <md-card-actions>
                            <md-button type="submit" class="md-primary md-raised" :disabled="sending">Login</md-button>
                        </md-card-actions>
                    </md-card>
                </form>
            </md-app-content>
        </md-app>
    </div>
</template>

<script>
export default {
    data() {
        return {
            sending: false,
            form: {
                email: null,
                password: null,
            },
        };
    },

    created() {
        if (this.$store.getters.loggedIn) {
            this.$router.app.$emit('confirmation', { text: "You're already signed in, no need to do that again" });
            this.$router.push('/');
        }
    },

    methods: {
        login() {
            axios.post('/login', this.form).then((response) => {
                this.$store.commit('login', response.data);
                this.$router.app.$emit('confirmation', { text: 'Logged in!'});
                this.$router.push('/');
            }).catch(() => {
                this.$router.app.$emit('confirmation', { text: 'Invalid credentials' });
            });
        }
    },
};
</script>

<style lang="scss" scoped>
</style>

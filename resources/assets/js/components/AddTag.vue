<template>
     <md-app>
        <md-app-toolbar class="md-primary">
            <router-link to="/">
                <md-button class="md-icon-button">
                    <md-icon>arrow_back</md-icon>
                </md-button>
            </router-link>
            <span class="md-title">Librorum</span>
        </md-app-toolbar>

        <md-app-content>
            <form novalidate class="md-layout-row md-gutter" @submit.prevent="saveTag">
                <md-card class="md-flex-50 md-flex-small-100">
                    <md-progress-bar md-mode="indeterminate" v-if="state === 'saving'" />

                    <md-card-header>
                        <div class="md-title">Add tag</div>
                    </md-card-header>

                    <md-card-content>
                        <div class="md-layout-row md-gutter md-layout-wrap">
                            <div class="md-flex md-flex-small-100">
                                <md-field>
                                    <label for="slug">Name</label>
                                    <md-input
                                        type="text"
                                        id="tag"
                                        name="tag"
                                        v-model="form.tag"
                                        maxlength="32" />
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>

                    <md-card-actions>
                        <md-button type="submit" class="md-primary" :disabled="state === 'saving'">Add tag</md-button>
                    </md-card-actions>
                </md-card>
                <md-snackbar :md-active="state === 'saved'">All done! Sending you back.</md-snackbar>
            </form>
        </md-app-content>
    </md-app>
</template>

<script>
export default {
    data() {
        return {
            form: {
                slug: null,
            },
            timers: [],
            state: 'forming', // forming -> saving -> saved
        };
    },

    methods: {
        saveTag() {
            this.state = 'saving';
            axios.post('/tags', this.form).then((response) => {
                this.state = 'saved';
                const timer = setTimeout(() => {
                    history.back();
                }, 3000);
                this.timers.push(timer);
            });
        },
    },

    beforeDestroy() {
        this.timers.forEach(timer => clearTimeout(this.timers));
        this.timers = [];
    },
};
</script>

<template>
     <md-app>
        <md-app-toolbar class="md-primary">
            <md-button class="md-icon-button" @click="toPageForm">
                <md-icon>arrow_back</md-icon>
            </md-button>
            <span class="md-title">Librorum</span>
        </md-app-toolbar>

        <md-app-content>
            <form novalidate class="md-layout-row md-gutter" @submit.prevent="saveNotebook">
                <md-card class="md-flex-50 md-flex-small-100">
                    <md-progress-bar md-mode="indeterminate" v-if="state === 'saving'" />

                    <md-card-header>
                        <div class="md-title">Start a new notebook</div>
                    </md-card-header>

                    <md-card-content>
                        <div class="md-layout-row md-gutter md-layout-wrap">
                            <div class="md-flex md-flex-small-100">
                                <md-field>
                                    <label for="slug">Reference</label>
                                    <md-input
                                        type="text"
                                        id="slug"
                                        name="slug"
                                        v-model="form.slug"
                                        maxlength="2" />
                                </md-field>
                                <small>Use 2 characters</small>
                            </div>
                        </div>
                    </md-card-content>

                    <md-card-actions>
                        <md-button type="submit" class="md-primary" :disabled="state === 'saving'">Start notebook</md-button>
                    </md-card-actions>
                </md-card>
                <md-snackbar :md-active="state === 'saved'">Done! Sending you back to start using your shiny new notebook</md-snackbar>
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
            state: 'forming', // forming -> saving -> saved
        };
    },

    methods: {
        saveNotebook() {
            this.state = 'saving';
            axios.post('/notebooks', this.form).then((response) => {
                this.state = 'saved';
                setTimeout(() => {
                    history.back();
                }, 3000);
            });
        },

        toPageForm() {
            history.back();
        },
    },
};
</script>

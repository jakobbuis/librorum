<template>
     <md-app>
        <md-app-toolbar class="md-primary">
            <router-link to="/notebooks">
                <md-button class="md-icon-button">
                    <md-icon>arrow_back</md-icon>
                </md-button>
            </router-link>

            <span class="md-title">{{ notebook.slug }}</span>

            <div class="md-toolbar-section-end">
                <md-button class="md-icon-button" @click="trash">
                    <md-icon>delete</md-icon>
                </md-button>
            </div>
        </md-app-toolbar>

        <md-app-content>
            <page-table
                :pages="notebook.pages"
                v-if="state === 'loaded' && notebook.pages.length > 0"
                @trashed="(page) => this.notebook.pages.splice(this.notebook.pages.indexOf(page), 1)"
                @restored="(page) => this.notebook.pages.push(page)" />

            <md-empty-state
                    v-if="notebook.pages.length === 0 && state === 'loaded'"
                    md-icon="bookmark_border"
                    md-label="Empty notebook">
                    <p class="md-empty-state-description">
                        This notebook has no pages tagged, yet. Once you tag
                        some new pages, you'll see them show up here.
                    </p>
                    <router-link to="/add-page">
                        <md-button class="md-primary md-raised">
                            Tag a new page
                        </md-button>
                    </router-link>
                </md-empty-state>

            <md-empty-state v-if="state === 'gone'" md-icon="label_outline" md-label="Notebook deleted">
                <p class="md-empty-state-description">
                    This notebook has been deleted, but it is still located in the
                    <router-link to="/trash">trash</router-link>. You can restore
                    it, or open the trash to purge it forever.
                </p>
                <md-button class="md-raised md-primary" @click="recoverNotebook">
                    Recover this notebook from trash
                </md-button>
            </md-empty-state>

            <md-empty-state v-if="state === 'missing'" md-icon="label_outline" md-label="Notebook not found">
                <p class="md-empty-state-description">
                    This notebook does not exist. If there was a notebook here in the past,
                    it has now been trashed <em>and</em> purged, and it is most
                    definitely unrecoverable.
                </p>
            </md-empty-state>

            <md-empty-state v-if="state === 'unauthorized'" md-icon="label_outline" md-label="Not yours">
                <p class="md-empty-state-description">
                    This notebook is not yours.
                </p>
            </md-empty-state>
        </md-app-content>
    </md-app>
</template>

<script>
import Vue from 'vue';
import PageTable from './PageTable';

export default {
    components: { PageTable },

    data() {
        return {
            state: 'loading',
            notebook: {
                slug: null,
                pages: [],
            },
            justDeleted: null,
        };
    },

    created() {
        this.getNotebookData();
    },

    methods: {
        getNotebookData() {
            axios.get(`/notebooks/${this.$route.params.id}`).then((response) => {
                this.state = 'loaded';
                Vue.set(this, 'notebook', response.data.data);
            }).catch((error) => {
                const result = error.response.status;
                if (result === 410) {
                    this.state = 'gone';
                }
                else if (result === 404) {
                    this.state = 'missing';
                }
                else if (result === 403) {
                    this.state = 'unauthorized';
                }
            });
        },

        trash() {
            axios.delete(`/notebooks/${this.notebook.id}`).then(() => {
                this.$router.app.$emit('confirmation', {
                    text: `${this.notebook.slug} deleted`,
                    undo: () => {
                        axios.patch(`/trash/${this.notebook.id}`, { deleted_at: null }).then(() => {
                            this.$router.app.$emit('confirmation', {
                                text: `Tag ${this.notebook.slug} restored`,
                            });
                            this.$router.push({name: 'notebook', params: { id: this.notebook.id }});
                        });
                    },
                });
                this.$router.push('/');
            });
        },

        recoverNotebook() {
            axios.patch(`/trash/${this.$route.params.id}`, { deleted_at: null }).then(() => {
                this.getNotebookData();
                this.$router.app.$emit('confirmation', {
                    text: `Tag restored`,
                });
            });
        },
    },
};
</script>

<style scoped>
.md-chip {
    width: 4em;
    text-align: center;
}
</style>

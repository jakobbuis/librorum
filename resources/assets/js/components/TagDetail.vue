<template>
     <md-app>
        <md-app-toolbar class="md-primary">
            <router-link to="/">
                <md-button class="md-icon-button">
                    <md-icon>arrow_back</md-icon>
                </md-button>
            </router-link>

            <span class="md-title">{{ tag.tag }}</span>

            <div class="md-toolbar-section-end">
                <md-button class="md-icon-button" @click="star">
                    <md-icon>{{ starStatus }}</md-icon>
                </md-button>
                <md-button class="md-icon-button" @click="trash">
                    <md-icon>delete</md-icon>
                </md-button>
            </div>
        </md-app-toolbar>

        <md-app-content>
            <md-table v-if="state === 'loaded' && tag.pages.length > 0">
                <md-table-row>
                    <md-table-head>Notebook</md-table-head>
                    <md-table-head md-numeric>Pages</md-table-head>
                    <md-table-head>Notes</md-table-head>
                    <md-table-head>Actions</md-table-head>
                </md-table-row>

                <md-table-row v-for="page in tag.pages" :key="page.identifier">
                    <md-table-cell>
                        <md-chip :style="{'background-color': page.color}">
                            {{ page.notebook }}
                        </md-chip>
                    </md-table-cell>
                    <md-table-cell md-numeric>{{ page.start_number }}&#8210;{{ page.end_number }}</md-table-cell>
                    <md-table-cell>{{ page.description }}</md-table-cell>
                    <md-table-cell>
                        <md-button class="md-icon-button" @click="trashPage(page)">
                            <md-icon>delete</md-icon>
                        </md-button>
                    </md-table-cell>
                </md-table-row>
            </md-table>

            <md-empty-state
                    v-if="tag.pages.length === 0 && state === 'loaded'"
                    md-icon="bookmark_border"
                    md-label="Empty tag">
                    <p class="md-empty-state-description">
                        No pages are associated with this tag, yet. Once you tag
                        some new pages, you'll see them show up here.
                    </p>
                    <router-link to="/add-page">
                        <md-button class="md-primary md-raised">
                            Tag a new page
                        </md-button>
                    </router-link>
                </md-empty-state>

            <md-empty-state v-if="state === 'gone'" md-icon="label_outline" md-label="Tag deleted">
                <p class="md-empty-state-description">
                    This tag has been deleted, but it is still located in the
                    <router-link to="/trash">trash</router-link>. You can restore
                    it, or open the trash to purge it forever.
                </p>
                <md-button class="md-raised md-primary" @click="recoverTag">
                    Recover this tag from trash
                </md-button>
            </md-empty-state>

            <md-empty-state v-if="state === 'missing'" md-icon="label_outline" md-label="Tag not found">
                <p class="md-empty-state-description">
                    This tag does not exist. If there was a tag here in the past,
                    it has now been trashed <em>and</em> purged, and it is most
                    definitely unrecoverable.
                </p>
            </md-empty-state>

            <md-empty-state v-if="state === 'unauthorized'" md-icon="label_outline" md-label="Not yours">
                <p class="md-empty-state-description">
                    This tag is not yours.
                </p>
            </md-empty-state>
        </md-app-content>
    </md-app>
</template>

<script>
import Vue from 'vue';

export default {
    data() {
        return {
            state: 'loading',
            tag: {
                pages: [],
            },
            justDeleted: null,
        };
    },

    created() {
        this.getTagData();
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },

    methods: {
        getTagData() {
            axios.get(`/tags/${this.$route.params.id}`).then((response) => {
                this.state = 'loaded';
                Vue.set(this, 'tag', response.data.data);
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

        star() {
            this.tag.starred = !this.tag.starred;
            axios.patch(`/tags/${this.tag.id}`, {starred: this.tag.starred});
        },

        trash() {
            axios.delete(`/tags/${this.tag.id}`).then(() => {
                this.$router.app.$emit('confirmation', {
                    text: `${this.tag.tag} deleted`,
                    undo: () => {
                        axios.patch(`/trash/${this.tag.id}`, { deleted_at: null }).then(() => {
                            this.$router.app.$emit('confirmation', {
                                text: `Tag ${this.tag.tag} restored`,
                            });
                            this.$router.push({name: 'tag', params: { id: this.tag.id }});
                        });
                    },
                });
                this.$router.push('/');
            });
        },

        undoTrashPage() {
            axios.patch(`/trash/${this.justDeleted.id}`, { deleted_at: null }).then(() => {
                this.tag.pages.push(this.justDeleted);
                this.$router.app.$emit('confirmation', {
                    text: `Page ${this.justDeleted.identifier} restored`,
                });
            });
        },

        trashPage(page) {
            axios.delete(`pages/${page.id}`).then(() => {
                // Remove locally
                const index = this.tag.pages.indexOf(page);
                this.justDeleted = this.tag.pages.splice(index, 1)[0];

                // Emit confirmatiom bar
                this.$router.app.$emit('confirmation', {
                    text: `Page ${page.identifier} deleted`,
                    undo: this.undoTrashPage,
                });
            });
        },

        recoverTag() {
            axios.patch(`/trash/${this.$route.params.id}`, { deleted_at: null }).then(() => {
                this.getTagData();
                this.$router.app.$emit('confirmation', {
                    text: `Tag restored`,
                });
            });
        }
    },
};
</script>

<style scoped>
.md-chip {
    width: 4em;
    text-align: center;
}
</style>

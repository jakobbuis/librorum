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
            <md-table v-if="state === 'loaded'">
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

            <p class="zero" v-if="state === 'gone'">
                This tag has been deleted. It might still be recoverable through
                <router-link to="/trash">your trash</router-link>.
            </p>

            <p class="zero" v-if="state === 'missing'">
                This tag does not exist.
            </p>
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
        const id = this.$route.params.id;
        axios.get(`/tags/${id}`).then((response) => {
            this.state = 'loaded';
            Vue.set(this, 'tag', response.data.data);
        }).catch((error) => {
            this.state = error.response.status === 410 ? 'gone' : 'missing';
        });
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },

    methods: {
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
    },
};
</script>

<style scoped>
.md-chip {
    width: 4em;
    text-align: center;
}
</style>

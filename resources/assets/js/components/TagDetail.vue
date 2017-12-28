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
            <h1>
                {{ tag.tag }}
                <i class="material-icons">{{ starStatus }}</i>
            </h1>

            <md-table>
                <md-table-row>
                    <md-table-head>Notebook</md-table-head>
                    <md-table-head md-numeric>Pages</md-table-head>
                    <md-table-head>Notes</md-table-head>
                </md-table-row>

                <md-table-row v-for="page in tag.pages" :key="page.identifier">
                    <md-table-cell>
                        <md-chip :style="{'background-color': page.color}">
                            {{ page.notebook }}
                        </md-chip>
                    </md-table-cell>
                    <md-table-cell md-numeric>{{ page.start_number }}&#8210;{{ page.end_number }}</md-table-cell>
                    <md-table-cell>{{ page.description }}</md-table-cell>
                </md-table-row>
            </md-table>
        </md-app-content>
    </md-app>
</template>

<script>
import Vue from 'vue';

export default {
    data() {
        return {
            tag: {
                pages: [],
            },
        };
    },

    created() {
        const id = this.$route.params.id;
        axios.get(`/tags/${id}`).then((response) => {
            Vue.set(this, 'tag', response.data.data);
        });
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
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

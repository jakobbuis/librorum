<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <div class="md-toolbar-section-start">
                    <span class="md-title">Librorum</span>
                </div>

                <div class="md-toolbar-section-end">
                    <md-field md-clearable v-if="searching">
                        <label>Search</label>
                        <md-input ref="searchField" v-model="filter"></md-input>
                    </md-field>
                    <md-button class="md-icon-button" @click="searching = true">
                        <md-icon>search</md-icon>
                    </md-button>
                </div>
            </md-app-toolbar>

            <md-app-content>
                <md-list class="md-triple-line">
                    <transition-group tag="div" name="tag-complete" :duration="500">
                        <template v-for="(tag, index) in displayedTags">
                            <tag :tag="tag" :key="tag.id" v-model="displayedTags[index]"></tag>
                            <md-divider :key="index" v-if="index !== displayedTags.length - 1" />
                        </template>
                    </transition-group>
                </md-list>
            </md-app-content>
        </md-app>

        <router-link to="/add-page">
            <md-button class="md-fab md-primary">
                <md-icon>add</md-icon>
            </md-button>
        </router-link>
    </div>
</template>

<script>
import Tag from './Tag';

export default {
    components: { Tag },
    data() {
        return {
            filter: null,
            tags: [],
            searching: false,
        };
    },

    created() {
        axios.get('/tags').then(response => this.tags = response.data.data);
    },

    methods: {
    },

    computed: {
        displayedTags() {
            if (!this.filter) {
                return this.naturalOrderedTags;
            }
            return this.naturalOrderedTags.filter((tag) => {
                return tag.tag.indexOf(this.filter) !== -1;
            });
        },

        naturalOrderedTags(){
            return this.tags.sort((a,b) => {
                const starred = b.starred - a.starred;
                return starred === 0 ? a.tag.localeCompare(b.tag) : starred;
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.tag-complete-move {
  transition: transform 0.5s;
}
.md-list {
    border: 1px solid rgba(#000, .12);
}
.md-fab {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 2;
}
</style>

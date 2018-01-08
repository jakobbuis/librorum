<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <div class="md-toolbar-section-start">
                    <md-button class="md-icon-button" @click="menuVisible = true">
                        <md-icon>menu</md-icon>
                    </md-button>
                    <span class="md-title">Librorum</span>
                </div>

                <div class="md-toolbar-section-end">
                    <md-field md-clearable v-if="searching">
                        <label>Search</label>
                        <md-input ref="searchField" v-model="filter"></md-input>
                    </md-field>
                    <md-button class="md-icon-button" @click="searching = true" v-if="tags.length > 0">
                        <md-icon>search</md-icon>
                    </md-button>
                </div>
            </md-app-toolbar>

            <md-app-content>
                <md-list class="md-triple-line" v-if="displayedTags.length > 0">
                    <transition-group tag="div" name="tag-complete" :duration="500">
                        <template v-for="(tag, index) in displayedTags">
                            <tag :tag="tag" :key="tag.id" v-model="displayedTags[index]"></tag>
                            <md-divider :key="index" v-if="index !== displayedTags.length - 1" />
                        </template>
                    </transition-group>
                </md-list>

                <md-empty-state
                    v-if="tags.length > 0 && displayedTags.length === 0"
                    md-icon="find_in_page"
                    md-label="No results" />

                <md-empty-state
                    v-if="tags.length === 0"
                    md-icon="bookmark_border"
                    md-label="You have no tags">
                    <p class="md-empty-state-description">
                        Tags are like labels you affix to your notebooks. Things like
                        "<em>meeting</em>", "<em>new concept</em>" or "<em>Secret Project X</em>". Get started
                        right now by creating your first tag.
                    </p>
                    <router-link to="/add-tag">
                        <md-button class="md-primary md-raised">
                            Create your first tag
                        </md-button>
                    </router-link>
                </md-empty-state>

            </md-app-content>
        </md-app>

        <main-menu :visible.sync="menuVisible"></main-menu>

        <md-speed-dial md-event="click" md-direction="top" v-if="tags.length > 0">
            <md-speed-dial-target class="md-primary">
                <md-icon class="md-morph-initial">add</md-icon>
                <md-icon class="md-morph-final">close</md-icon>
            </md-speed-dial-target>

            <md-speed-dial-content>
                <router-link to="/add-page">
                    <md-button class="md-icon-button">
                        <md-icon>description</md-icon>
                    </md-button>
                </router-link>

                <router-link to="/add-tag">
                    <md-button class="md-icon-button">
                        <md-icon>label</md-icon>
                    </md-button>
                </router-link>
            </md-speed-dial-content>
        </md-speed-dial>
    </div>
</template>

<script>
import Tag from './Tag';
import MainMenu from './MainMenu';

export default {
    components: { Tag, MainMenu },
    data() {
        return {
            menuVisible: false, // Show the main navigation menu
            filter: null,
            tags: [],
            searching: false,
        };
    },

    created() {
        axios.get('/tags').then(response => this.tags = response.data.data);
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
    padding: 0;
}
.md-speed-dial {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 2;

    .md-button {
        background-color: rgb(150, 150, 150);
    }

    .md-icon {
        color: white;
    }
}
</style>

<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <md-button class="md-icon-button" @click="menuVisible = true">
                    <md-icon>menu</md-icon>
                </md-button>
                <span class="md-title">Notebooks</span>
            </md-app-toolbar>

            <md-app-content>
                <md-list class="md-triple-line">
                    <transition-group tag="div" name="notebook-complete" :duration="500">
                        <template v-for="(notebook, index) in notebooks">
                            <md-list-item :key="notebook.id">
                                <div class="md-list-item-text">
                                    <span>{{ notebook.slug }}</span>
                                    <span class="tagline">{{ notebook.page_count }} pages</span>
                                    <!-- <p class="pages">
                                        <span v-for="page in tag.pages" class="page" :style="{'background-color': page.color}">
                                            {{ page.identifier }}
                                        </span>
                                    </p> -->
                                </div>
                            </md-list-item>
                            <md-divider :key="index" v-if="index !== notebooks.length - 1" />
                        </template>
                    </transition-group>
                </md-list>
            </md-app-content>
        </md-app>

        <main-menu :visible.sync="menuVisible"></main-menu>

        <!-- <md-speed-dial md-event="click" md-direction="top">
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
        </md-speed-dial> -->
    </div>
</template>

<script>
import MainMenu from './MainMenu';

export default {
    components: { MainMenu },

    data() {
        return {
            menuVisible: false, // Show the main navigation menu
            notebooks: [],
        };
    },

    created() {
        axios.get('/notebooks').then(response => this.notebooks = response.data.data);
    },
};
</script>

<style lang="scss" scoped>
.notebook-complete-move {
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

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
                <md-list class="md-triple-line" v-if="notebooks.length > 0">
                    <transition-group tag="div" name="notebook-complete" :duration="500">
                        <template v-for="(notebook, index) in notebooks">
                            <md-list-item :key="notebook.id">
                                <div class="md-list-item-text">
                                    <span>{{ notebook.slug }}</span>
                                    <small class="subtitle">{{ progressDescription(notebook) }}</small>
                                    <md-progress-bar
                                        v-if="notebook.progress"
                                        md-mode="determinate"
                                        :md-value="notebook.progress">
                                    </md-progress-bar>
                                </div>
                            </md-list-item>
                            <md-divider :key="index" v-if="index !== notebooks.length - 1" />
                        </template>
                    </transition-group>
                </md-list>

                <md-empty-state
                    v-if="notebooks.length === 0"
                    md-icon="description"
                    md-label="No notebooks">
                    <p class="md-empty-state-description">
                        You have no notebooks yet. A notebook is any stack of paper
                        that has a consistent numbering, and is used as a single bundle.
                        Get started now and create your first notebook!
                    </p>
                    <router-link to="/add-notebook">
                        <md-button class="md-primary md-raised">
                            Create your first notebook
                        </md-button>
                    </router-link>
                </md-empty-state>
            </md-app-content>
        </md-app>

        <main-menu :visible.sync="menuVisible"></main-menu>

        <router-link to="/add-notebook">
            <md-button class="md-fab md-primary">
                <md-icon>add</md-icon>
            </md-button>
        </router-link>
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

    methods: {
        progressDescription(notebook) {
            let sentence = `${notebook.used_pages} pages tagged`;
            if (notebook.page_count) {
                sentence = sentence.concat(` out of ${notebook.page_count}`);
            }
            return sentence;
        },
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
.md-fab {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 2;
}

.md-progress-bar {
    margin-top: 0.5em;
}

.subtitle {
    font-size: 10px;
    color: #666;
}
</style>

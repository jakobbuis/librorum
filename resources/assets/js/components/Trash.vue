<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <md-button class="md-icon-button" @click="menuVisible = true">
                    <md-icon>menu</md-icon>
                </md-button>
                <span class="md-title">Trash</span>
            </md-app-toolbar>

            <md-app-content>
                <h1>Trash here</h1>
            </md-app-content>
        </md-app>

        <main-menu :visible.sync="menuVisible"></main-menu>
    </div>
</template>

<script>
import MainMenu from './MainMenu';

export default {
    components: { MainMenu },
    data() {
        return {
            menuVisible: false, // Show the main navigation menu
        };
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

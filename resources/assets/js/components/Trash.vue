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
                <md-list class="md-double-line">

                    <template v-for="(item, index) in items">
                        <md-list-item :key="item.id">
                            <md-icon>{{ typeIcon(item) }}</md-icon>
                            <div class="md-list-item-text">
                                <span>{{ item.name }}</span>
                                <span>{{ item.type }}</span>
                            </div>
                            <md-button class="md-icon-button md-list-action" @click="restore(item)">
                                <md-icon>restore_page</md-icon>
                            </md-button>
                        </md-list-item>
                        <md-divider :key="index" v-if="index !== items.length - 1" />
                    </template>
                </md-list>
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
            items: [],
        };
    },

    mounted() {
        axios.get('/trash').then(response => this.items = response.data.data);
    },

    methods: {
        typeIcon(item) {
            if (item.type === 'tag') {
                return 'label';
            }
            else {
                return 'description';
            }
        },

        restore(item) {
            axios.patch(`/trash/${item.id}`, { deleted_at: null }).then(() => {
                this.items.splice(this.items.indexOf(item), 1);
                this.$router.app.$emit('confirmation', {
                    text: `${item.type} ${item.name} restored`,
                });
            });
        }
    },
};
</script>

<style scoped lang="scss">
.md-list {
    border: 1px solid rgba(#000, .12);
    padding: 0;
}
</style>

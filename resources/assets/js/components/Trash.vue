<template>
    <div>
        <md-app>
            <md-app-toolbar class="md-primary">
                <div class="md-toolbar-section-start">
                    <md-button class="md-icon-button" @click="menuVisible = true">
                        <md-icon>menu</md-icon>
                    </md-button>
                    <span class="md-title">Trash</span>
                </div>
                <div class="md-toolbar-section-end">
                    <md-button class="md-icon-button" @click="clearConfirmVisible = true" v-if="!empty">
                        <md-icon>delete_sweep</md-icon>
                    </md-button>
                </div>
            </md-app-toolbar>

            <md-app-content>
                <md-list class="md-double-line" v-if="!empty">
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

                <md-empty-state v-if="empty" md-icon="delete_forever" md-label="Trash is empty">
                    <p class="md-empty-state-description">
                        If you delete notebooks, tags or pages, they show up here
                        for safe-keeping. Until you take the trash out, you can
                        always recover accidentally deleted items.
                    </p>
                </md-empty-state>
            </md-app-content>
        </md-app>

        <md-dialog :md-fullscreen="false" :md-active.sync="clearConfirmVisible">
            <md-dialog-title>Empty trash</md-dialog-title>
            <md-dialog-content>
                <strong>Caution:</strong> This will permanently delete all trashed items. No recovery is possible beyond this point. Are you absolutely sure you want to do this?
            </md-dialog-content>

            <md-dialog-actions>
                <md-button @click="clearConfirmVisible = false">No, I don't</md-button>
                <md-button class="md-raised md-accent" @click="clearAll">Yes, I'm sure. Delete everything</md-button>
            </md-dialog-actions>
        </md-dialog>

        <main-menu :visible.sync="menuVisible"></main-menu>
    </div>
</template>

<script>
import Vue from 'vue';
import MainMenu from './MainMenu';

export default {
    components: { MainMenu },
    data() {
        return {
            menuVisible: false, // Show the main navigation menu
            clearConfirmVisible: false,
            items: [],
        };
    },

    mounted() {
        axios.get('/trash').then(response => this.items = response.data.data);
    },

    computed: {
        empty() {
            return this.items.length === 0;
        },
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
        },

        clearAll() {
            this.clearConfirmVisible = false;
            axios.delete('/trash').then(() => {
                Vue.set(this, 'items', []);
                this.$router.app.$emit('confirmation', {
                    text: 'All trashed items cleared',
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

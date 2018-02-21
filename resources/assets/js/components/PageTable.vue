<template>
    <md-table>
        <md-table-row>
            <md-table-head>Notebook</md-table-head>
            <md-table-head md-numeric>Pages</md-table-head>
            <md-table-head>Notes</md-table-head>
            <md-table-head>Actions</md-table-head>
        </md-table-row>

        <md-table-row v-for="page in pages" :key="page.identifier">
            <md-table-cell>
                <md-chip :style="{'background-color': page.color}">
                    {{ page.notebook }}
                </md-chip>
            </md-table-cell>
            <md-table-cell md-numeric>{{ pageRange(page) }}</md-table-cell>
            <md-table-cell>{{ page.description }}</md-table-cell>
            <md-table-cell>
                <md-button class="md-icon-button" @click="trash(page)">
                    <md-icon>delete</md-icon>
                </md-button>
            </md-table-cell>
        </md-table-row>
    </md-table>
</template>

<script>
export default {
    props: ['pages'],

    data() {
        return {
            lastDeleted: null,
        };
    },

    methods: {
        pageRange(page) {
            if (page.end_number) {
                return `${page.start_number}-${page.end_number}`;
            }
            return `${page.start_number}`;
        },

        trash(page) {
            axios.delete(`pages/${page.id}`).then(() => {
                // Store the removed data locally for easy restore
                this.lastDeleted = page;

                // Signal parent that we have removed this page
                this.$emit('trashed', page);

                // Emit confirmatiom bar
                this.$router.app.$emit('confirmation', {
                    text: `Page ${page.identifier} deleted`,
                    undo: this.undoTrashing,
                });
            });
        },

        undoTrashing() {
            axios.patch(`/trash/${this.lastDeleted.id}`, { deleted_at: null }).then(() => {
                this.$emit('restored', this.lastDeleted);

                this.$router.app.$emit('confirmation', {
                    text: `Page ${this.lastDeleted.identifier} restored`,
                });
            });
        },
    },
};
</script>

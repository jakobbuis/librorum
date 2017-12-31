<template>
    <md-snackbar md-position="center" :md-duration="3000" :md-active="active">
        <span>{{ text }}</span>
        <md-button class="md-primary"
            @click="undoAction" v-show="undoCallback">
            Undo
        </md-button>
    </md-snackbar>
</template>

<script>
export default {
    props: ['text', 'undoCallback'],

    data() {
        return {
            active: false,
        };
    },

    watch: {
        text() {
            this.active = true;
            setTimeout(() => {this.active = false}, 3000);
        },
    },

    methods: {
        undoAction() {
            if (this.undoCallback) {
                this.undoCallback();
            }
        },
    },
};
</script>

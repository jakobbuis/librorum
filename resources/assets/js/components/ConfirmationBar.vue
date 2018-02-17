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
    props: ['active', 'text', 'undoCallback'],

    data() {
        return {
            timer: null,
        };
    },

    watch: {
        text() {
            if (this.timer) {
                // Changing the text resets the timeout
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(() => {
                this.$emit('update:active', false);
                this.timer = null;
            }, 3000);
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

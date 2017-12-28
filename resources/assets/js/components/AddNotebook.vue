<template>

</template>

<script>
export default {
    props: ['active'],
    data() {
        return {
            dialogOpen: this.active,
            slug: null,
        };
    },
    watch: {
        active() {
            this.dialogOpen = this.active;
        }
    },
    methods: {
        addNotebook() {
            alert(this.slug);
            this.closeDialog();
        },
        closeDialog() {
            this.$emit('update:active', false);
        }
    },
};
</script>

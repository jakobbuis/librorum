<template>
    <md-drawer
        :md-active="visible"
        @update:mdActive="activeChanged">

        <md-list>
            <router-link to="/">
                <md-list-item>
                    <md-icon>label</md-icon>
                    <span class="md-list-item-text">Tags</span>
                </md-list-item>
            </router-link>

            <router-link to="/trash">
                <md-list-item>
                    <md-icon>delete</md-icon>
                    <span class="md-list-item-text">Trash</span>
                </md-list-item>
            </router-link>
        </md-list>
      </md-drawer>
</template>

<script>
export default {
    props: ['visible'],
    methods: {
        activeChanged(value) {
            this.$emit('update:visible', value);
        },
    },
};
</script>

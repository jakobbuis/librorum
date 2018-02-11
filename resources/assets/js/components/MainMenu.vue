<template>
    <md-drawer
        :md-active="visible"
        @update:mdActive="activeChanged">

        <md-list>
            <md-list-item @click="() => this.$router.push('/')">
                <md-icon>label</md-icon>
                <span class="md-list-item-text">Tags</span>
            </md-list-item>

            <md-list-item @click="() => this.$router.push('/notebooks')">
                <md-icon>book</md-icon>
                <span class="md-list-item-text">Notebooks</span>
            </md-list-item>

            <md-list-item @click="() => this.$router.push('/trash')">
                <md-icon>delete</md-icon>
                <span class="md-list-item-text">Trash</span>
            </md-list-item>

            <md-list-item @click="logout">
                <md-icon>power_settings_new</md-icon>
                <span class="md-list-item-text">Logout</span>
            </md-list-item>
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

        logout() {
            this.$store.commit('logout');
            this.$router.app.$emit('confirmation', { text: 'Logged out' });
            this.$router.push('/login');
        },
    },
};
</script>

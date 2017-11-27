<template>
    <ul>
        <li v-for="tag in tags">{{ tag }}</li>
    </ul>
</template>

<script>
export default {
    data() {
        return {
            tags: [],
        };
    },

    created() {
        axios.get('/tags').then(response => this.tags = response.data);
    }
};
</script>

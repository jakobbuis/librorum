<template>
    <div>
        <tag v-for="tag in tags" key="tag" :tag="tag"></tag>
    </div>
</template>

<script>
import Tag from './Tag';

export default {
    components: { Tag },
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

<style scoped>
div {
    background-color: #fafafa;
}
</style>

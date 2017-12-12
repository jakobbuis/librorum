<template>
    <div>
        <tag v-for="(tag, index) in naturalOrderedTags" key="tag.tag" :tag="tag" v-model="naturalOrderedTags[index]"></tag>
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
        axios.get('/tags').then(response => this.tags = response.data.data);
    },

    computed: {
        naturalOrderedTags(){
            return this.tags.sort((a,b) => {
                const starred = b.starred - a.starred;
                return starred === 0 ? a.tag.localeCompare(b.tag) : starred;
            });
        },
    },
};
</script>

<style scoped>
div {
    background-color: #fafafa;
}
</style>

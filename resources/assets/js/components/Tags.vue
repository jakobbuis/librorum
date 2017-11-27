<template>
    <ul class="mdl-list">
       <tag v-for="tag in tags" key="tag" :tag="tag"></tag>
    </ul>
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

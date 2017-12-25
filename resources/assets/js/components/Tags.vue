<template>
    <main>
        <form action="#">
            <md-field md-clearable>
                <label>Search</label>
                <md-input v-model="filter"></md-input>
            </md-field>
        </form>
        <transition-group tag="div" name="tag-complete" :duration="500">
            <tag v-for="(tag, index) in displayedTags" v-bind:key="tag.tag" :tag="tag" v-model="displayedTags[index]"></tag>
        </transition-group>
    </main>
</template>

<script>
import Tag from './Tag';

export default {
    components: { Tag },
    data() {
        return {
            filter: null,
            tags: [],
        };
    },

    created() {
        axios.get('/tags').then(response => this.tags = response.data.data);
    },

    methods: {
        clearFilter() {
            this.filter = null;
            this.$el.querySelector('#query').blur();
        },
    },

    computed: {
        displayedTags() {
            if (!this.filter) {
                return this.naturalOrderedTags;
            }
            return this.naturalOrderedTags.filter((tag) => {
                return tag.tag.indexOf(this.filter) !== -1;
            });
        },

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
.tag-complete-move {
  transition: transform 0.5s;
}
</style>

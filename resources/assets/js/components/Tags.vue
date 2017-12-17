<template>
    <div>
        <label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">
            <i class="material-icons">search</i>
        </label>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="query" v-model="filter">
            <label class="mdl-textfield__label" for="query">Search</label>
        </div>
        </form>
        <transition-group tag="div" name="tag-complete" :duration="500">
            <tag v-for="(tag, index) in displayedTags" v-bind:key="tag.tag" :tag="tag" v-model="displayedTags[index]"></tag>
        </transition-group>
    </div>
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
div {
    background-color: #fafafa;
}
.tag-complete-move {
  transition: transform 0.5s;
}
</style>

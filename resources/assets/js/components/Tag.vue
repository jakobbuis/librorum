<template>
    <div>
        <md-list-item @click="openTag">
            <div class="md-list-item-text">
                <span>{{ tag.tag }}</span>
                <span class="tagline">{{ tag.page_count }} pages</span>
                <p class="pages">
                    <span v-for="page in tag.pages" class="page" :style="{'background-color': page.color}">
                        {{ page.identifier }}
                    </span>
                </p>
            </div>

            <md-button class="md-icon-button md-list-action" @click.stop="star">
                <md-icon>{{ starStatus }}</md-icon>
            </md-button>
        </md-list-item>
    </div>
</template>

<script>
export default {
    props: ['tag'],

    methods: {
        openTag() {
            this.$router.push({name: 'tag', params: { id: this.tag.id }});
        },

        star() {
            this.tag.starred = !this.tag.starred;
            axios.patch(`/tags/${this.tag.id}`, {starred: this.tag.starred})
                .then(() => {
                    this.$emit('input', this.tag);
                    if (!this.tag.starred) {
                        this.$router.app.$emit('confirmation', {
                            text: `${this.tag.tag} unstarred`,
                            undo: this.star,
                        });
                    }
                });
        },
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },
};
</script>

<style lang="scss" scoped>
.tagline {
    color: rgba(0, 0, 0, 0.54);
}
.pages {
    margin-top: 0.5em;
}
.page {
    color: rgba(0, 0, 0, 1) !important;
    font-size: 0.75em;
    width: auto;
    display: inline-block;
    background-color: #ccc;
    padding: 0.1em 0.5em;
    border-radius: 1em;
    margin-right: 0.5em;
}
</style>

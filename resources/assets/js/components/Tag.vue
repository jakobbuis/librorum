<template>
    <md-card md-with-hover>
        <md-ripple>
            <md-card-header>
                <div class="md-title">{{ tag.tag }}</div>
                <div class="md-subhead">{{ tag.page_count }} pages</div>
            </md-card-header>

            <md-card-content>
                <md-chip v-for="page in tag.pages" key="page.identifier" :style="{'background-color': page.color}">
                    {{ page.identifier }}
                </md-chip>
                <md-chip v-if="tag.more_pages">
                    &hellip;
                </md-chip>
            </md-card-content>

            <md-card-actions>
                <md-button class="md-icon-button" @click="openTag">
                    <md-icon>bookmark</md-icon>
                </md-button>
                <md-button class="md-icon-button" @click="star">
                    <md-icon>{{ starStatus }}</md-icon>
                </md-button>
            </md-card-actions>
        </md-ripple>
    </md-card>
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
                 .then(() => this.$emit('input', this.tag));
        }
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },
};
</script>

<style lang="scss" scoped>
.md-card {
    margin-bottom: 1em;
}
</style>

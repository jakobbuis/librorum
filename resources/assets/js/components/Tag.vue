<template>
    <div class="demo-card-event mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand">
            <h4>{{ tag.tag }}</h4>
        </div>

        <div class="mdl-card__supporting-text">
            <span class="mdl-chip" v-for="page in tag.pages">
                <span class="mdl-chip__text">{{ page }}</span>
            </span>
            <span class="mdl-chip" v-if="tag.more_pages">
                <span class="mdl-chip__text">&hellip;</span>
            </span>
        </div>

        <div class="mdl-card__actions mdl-card--border">
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" @click="openTag">
                All pages
            </a>
        </div>

        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" @click="star">
                <i class="material-icons">{{ starStatus }}</i>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['tag'],
    data() {
        return {
            expanded: false,
        };
    },
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
        }
    },
};
</script>

<style lang="scss" scoped>
.mdl-card {
    margin-bottom: 1em;

    h4, .mdl-card__title {
        margin-bottom: 0;
    }

    & > .mdl-card__title {
        align-items: flex-start;
    }

    & > .mdl-card__title > h4 {
        margin-top: 0;
    }

    & > .mdl-card__actions {
        display: flex;
        box-sizing:border-box;
        align-items: center;
    }

    & > .mdl-card__actions > .material-icons {
        padding-right: 10px;
    }
}
</style>

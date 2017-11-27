<template>
    <li class="mdl-list__item" @click="expanded = !expanded">
        <span class="mdl-list__item-primary-content">
            {{ tag }}
        </span>
        <a class="mdl-list__item-secondary-action" href="#">
            <i class="material-icons">{{ expansionIcon }}</i>
        </a>
    </li>
</template>

<script>
export default {
    props: ['tag'],
    data() {
        return {
            expanded: false,
        };
    },
    computed: {
        expansionIcon() {
            return this.expanded ? 'expand_less' : 'expand_more';
        },
    },
};
</script>

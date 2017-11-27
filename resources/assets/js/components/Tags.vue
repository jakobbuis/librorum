<template>
    <ul class="mdl-list">
        <li class="mdl-list__item" v-for="tag in tags">
            <span class="mdl-list__item-primary-content">
                {{ tag }}
            </span>
            <a class="mdl-list__item-secondary-action" href="#"><i class="material-icons">expand_more</i></a>
        </li>
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

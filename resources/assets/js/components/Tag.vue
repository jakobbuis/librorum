<template>
    <li class="mdl-list__item">
        <span class="mdl-list__item-primary-content">
            {{ tag }}
        </span>
        <a class="mdl-list__item-secondary-action" href="#"><i class="material-icons">expand_more</i></a>
    </li>
</template>

<script>
export default {
    props: ['tag'],
};
</script>

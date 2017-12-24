<template>
    <div>
        <h1>
            {{ tag.tag }}
            <i class="material-icons">{{ starStatus }}</i>
        </h1>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
            <thead><tr>
                <th class="mdl-data-table__cell--non-numeric">Notebook</th>
                <th>Pages</th>
                <th class="mdl-data-table__cell--non-numeric">Note</th>
            </tr></thead>
            <tbody>
                <tr v-for="page in tag.pages" :style="{'background-color': page.color}">
                    <td class="mdl-data-table__cell--non-numeric">
                        {{ page.notebook }}
                    </td>
                    <td>{{ page.start_number }}&#8210;{{ page.end_number }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ page.description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Vue from 'vue';

export default {
    data() {
        return {
            tag: {
                pages: [],
            },
        };
    },

    created() {
        const id = this.$route.params.id;
        axios.get(`/tags/${id}`).then((response) => {
            Vue.set(this, 'tag', response.data.data);
        });
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },
};
</script>

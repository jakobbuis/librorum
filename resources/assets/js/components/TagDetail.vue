<template>
    <div>
        <h1>
            {{ tag.tag }}
            <i class="material-icons">{{ starStatus }}</i>
        </h1>
        <h2>Pages</h2>
        <table>
            <thead><tr>
                <th>Notebook</th>
                <th>Pages</th>
                <th>Note</th>
            </tr></thead>
            <tbody>
                <tr v-for="page in fullTag.pages">
                    <td>{{ page.notebook }}</td>
                    <td>{{ page.start_number }}&#8210;{{ page.end_number }}</td>
                    <td>{{ page.description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Vue from 'vue';

export default {
    props: ['tag'],

    data() {
        return {
            fullTag: {
                pages: [],
            },
        };
    },

    created() {
        axios.get(`/tags/${this.tag.id}`).then((response) => {
            Vue.set(this, 'fullTag', response.data.data);
        });
    },

    computed: {
        starStatus() {
            return this.tag.starred ? 'star' : 'star_border';
        },
    },
};
</script>

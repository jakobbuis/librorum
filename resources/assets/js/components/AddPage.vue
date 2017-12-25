<template>
    <main>
        <h1>Add page</h1>
        <form action="#">
            <md-field>
                <label for="notebook">Notebook</label>
                <md-select v-model="selectedNotebook" name="notebook" id="notebook">
                    <md-option :value="notebook.id" v-for="notebook in notebooks" :key="notebook.id">
                        {{ notebook.slug }}
                    </md-option>
                </md-select>
            </md-field>

            <md-field>
                <label>Starting page number</label>
                <md-input v-model="start_number" type="number"></md-input>
            </md-field>

            <md-field>
                <label>Last page number</label>
                <md-input v-model="end_number" type="number"></md-input>
            </md-field>

            <md-autocomplete
                v-model="tagInputString" :value="tagInputString"
                :md-options="tagNames"
                :md-open-on-focus="false"
                @md-selected="addTag">
                <label>Tags</label>
            </md-autocomplete>

            <md-chip
                md-deletable
                v-for="(tag, index) in selectedTags"
                :key="tag.tag"
                @md-delete="removeTag(index)">
                {{ tag.tag }}
            </md-chip>
        </form>
    </main>
</template>

<script>
export default {
    data() {
        return {
            notebooks: [],
            tags: [],
            selectedNotebook: null,
            start_number: null,
            end_number: null,
            tagInputString: '',
            selectedTags: [],
        };
    },

    mounted() {
        axios.get('/notebooks').then((response) => {
            this.notebooks = response.data.data;
        });
        axios.get('/tags').then((response) => {
            this.tags = response.data.data;
        });
    },

    computed: {
        tagNames() {
            return this.tags.map(tag => tag.tag);
        }
    },

    methods: {
        addTag() {
            const tag = this.tags.filter((tag) => tag.tag === this.tagInputString)[0];
            this.selectedTags.push(tag);
            this.tagInputString = '';
        },

        removeTag(index) {
            this.selectedTags.splice(index, 1);
        },
    },
};
</script>

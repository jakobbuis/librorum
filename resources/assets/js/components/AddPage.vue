<template>
    <form novalidate class="md-layout-row md-gutter" @submit.prevent="savePage">
        <md-card class="md-flex-50 md-flex-small-100">
            <md-card-header>
                <div class="md-title">Add a page</div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout-row md-gutter md-layout-wrap">
                    <div class="md-flex md-flex-small-100">
                        <md-field>
                            <label for="notebook">Notebook</label>
                            <md-select
                                md-dense
                                name="notebook"
                                id="notebook"
                                v-model="form.notebook">
                                <md-option v-for="notebook in notebooks" :key="notebook.id" :value="notebook.id">{{ notebook.slug }}</md-option>
                            </md-select>
                        </md-field>
                    </div>

                    <div class="md-flex md-flex-small-100">
                        <router-link to="/add-notebook">
                            Start a new notebook
                        </router-link>
                    </div>

                    <div class="md-flex md-flex-small-100">
                        <md-field>
                            <label for="start_number">Starting page number</label>
                            <md-input type="number" id="start_number" name="start_number" autocomplete="start_number" v-model="form.start_number" />
                        </md-field>
                    </div>

                    <div class="md-flex md-flex-small-100">
                        <md-field>
                            <label for="end_number">Last page number</label>
                            <md-input type="number" id="end_number" name="end_number" autocomplete="end_number" v-model="form.end_number" />
                        </md-field>
                    </div>

                    <div class="md-flex md-flex-small-100">
                        <md-autocomplete
                            id="tags" name="tags"
                            ref="tagAutocompleteField"
                            v-model="form.tagInputString" :value="form.tagInputString"
                            :md-options="tagNames"
                            :md-open-on-focus="false"
                            @md-selected="addTag">
                            <label>Tags</label>
                        </md-autocomplete>
                        <md-chip
                            md-deletable
                            v-for="(tag, index) in form.tags"
                            :key="tag.tag"
                            @md-delete="removeTag(index)">
                            {{ tag.tag }}
                        </md-chip>
                    </div>
                </div>
            </md-card-content>

            <md-progress-bar md-mode="indeterminate" v-if="state === 'saving'" />

            <md-card-actions>
                <md-button type="submit" class="md-primary" :disabled="state === 'saving'">Add page</md-button>
            </md-card-actions>
        </md-card>
        <md-snackbar :md-active="state === 'saved'">Page saved!</md-snackbar>
    </form>
</template>

<script>
import addNotebook from './AddNotebook.vue';

export default {
    components: { addNotebook },
    data() {
        return {
            notebooks: [],
            tags: [],
            form: {
                notebook: null,
                start_number: null,
                end_number: null,
                tags: [],
                tagInputString: '', // temporary placeholder for the text in the autocomplete field, not submitted
                description: null,
            },
            state: 'forming', // forming -> saving -> saved
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

    watch: {
        // When you select a notebook, we preselect the probable next page for you
        'form.notebook': function setNextPageAsDefault() {
            if (this.form.start_number) {
                return;
            }

            const notebook = this.notebooks.filter(n => n.id === this.form.notebook)[0];
            if (notebook) {
                this.form.start_number = notebook.highest_end_number + 1;
            }
        },
    },

    methods: {
        addTag() {
            const tag = this.tags.filter((tag) => tag.tag === this.form.tagInputString)[0];
            this.form.tags.push(tag);
            this.form.tagInputString = '';
            this.$refs.tagAutocompleteField.searchTerm = '';
        },

        removeTag(index) {
            this.form.tags.splice(index, 1);
        },

        savePage() {
            this.state = 'saving';
            axios.post('/pages', this.form).then((response) => {
                this.state = 'saved';
            });
        },
    },
};
</script>

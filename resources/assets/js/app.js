import Vue from 'vue';
import axios from 'axios';
import router from './router';
import LayoutHeader from './components/LayoutHeader';

// Configure axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Use CSRF tokens
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Create Vue application
const app = new Vue({
    el: '#app',
    router,
    components: { LayoutHeader },

    created() {
        this.$router.push('tags');
    },

    methods: {
        tagNewPage() {
            alert('Processing a new page!');
        }
    },
});

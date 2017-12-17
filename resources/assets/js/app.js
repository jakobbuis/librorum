import Vue from 'vue';
import axios from 'axios';
import router from './router';
import LayoutHeader from './components/LayoutHeader';

// Configure axios
axios.defaults.baseURL = 'http://librorum.test/api/';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';
window.axios = axios; // Use axios as a global

// Create Vue application
const app = new Vue({
    el: '#app',
    router,
    components: { LayoutHeader },
});

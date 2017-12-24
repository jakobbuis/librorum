import Vue from 'vue';
import VueMaterial from 'vue-material';
import axios from 'axios';
import router from './router';
import LayoutHeader from './components/LayoutHeader';

// Configure axios
axios.defaults.baseURL = window.configuration.api_url;
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';
window.axios = axios; // Use axios as a global

// Create Vue application
Vue.use(VueMaterial);

const app = new Vue({
    el: '#app',
    router,
    components: { LayoutHeader },
});

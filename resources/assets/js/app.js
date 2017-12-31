import Vue from 'vue';
import axios from 'axios';
import VueMaterial from 'vue-material';
import router from './router';
import ConfirmationBar from './components/ConfirmationBar.vue';

// Initialize material UI
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';
Vue.use(VueMaterial);

// Configure axios
axios.defaults.baseURL = window.configuration.api_url;
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';
window.axios = axios; // Use axios as a global

// Initialize global Vue components
Vue.component('confirmation-bar', ConfirmationBar);

// Create Vue application
const app = new Vue({
    el: '#app',
    router,
    data: {
        axiosError: false,
        confirmation: {
            text: null,
            undoCallback: null,
        },
    },

    created() {
        // Use an interceptor to globally handle events
        axios.interceptors.response.use(null, (error) => {
            this.axiosError = true;
            return Promise.reject(error);
        });

        this.$on('deletedTag', (payload) => {
            console.log('deleted tag, show notification');
            this.confirmation.text = `${payload.name} deleted`;
        });
    },
});

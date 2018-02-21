import Vue from 'vue';
import axios from 'axios';
import VueMaterial from 'vue-material';
import router from './router';
import ConfirmationBar from './components/ConfirmationBar.vue';
import store from './store';

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
    store,
    data: {
        errors: {
            server: false,
            mustLogin: false,
        },
        confirmation: {
            active: false,
            text: null,
            undoCallback: null,
        },
    },

    created() {
        // Use an interceptor to globally handle server errors
        axios.interceptors.response.use(function(config) {
            return config;
        }, (error) => {
            const isLoginRequest = error.request.responseURL.indexOf('/api/login') !== -1;
            if (error.response.status == 401 && !isLoginRequest) {
                // Purge the local session
                this.$store.commit('logout');
                this.errors.mustLogin = true;
            }
            if (error.response.status >= 500) {
                this.errors.server = true;
            }
            return Promise.reject(error);
        });

        // Use an interceptor to globally add OAuth 2 tokens
        axios.interceptors.request.use((config) => {
            if (this.$store.getters.loggedIn) {
                const token = this.$store.getters.currentAccessToken;
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        }, function(error) {
            return Promise.reject(error);
        });

        this.$on('confirmation', (payload) => {
            this.confirmation.active = true;
            this.confirmation.text = payload.text;
            this.confirmation.undoCallback = payload.undo ? payload.undo : null;
        });
    },

    methods: {
        toLoginPage() {
            this.errors.mustLogin = false;
            this.$router.push('/login');
        }
    },
});

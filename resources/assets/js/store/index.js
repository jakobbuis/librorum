import Vue from 'vue';
import VueX from 'vuex';
import VuexPersistence from 'vuex-persist';

Vue.use(VueX);

// Configure localStorage-backing for state
const storage = new VuexPersistence({
    storage: window.localStorage,
    key: 'librorum',
});

export default new VueX.Store({
    plugins: [storage.plugin],

    state: {
        oauth: {
            accessToken: null,
        },
    },

    mutations: {
        login(state, token) {
            state.oauth.accessToken = token;
        },

        logout(state) {
            state.oauth.accessToken = null;
        },
    },


    getters: {
        loggedIn(state) {
            return !!state.oauth.accessToken;
        },

        currentAccessToken(state) {
            const token = state.oauth.accessToken;
            return token && token.access_token ? token.access_token : null;
        }
    },
});

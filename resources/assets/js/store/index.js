import Vue from 'vue';
import VueX from 'vuex';

Vue.use(VueX);

export default new VueX.Store({
    state: {
        oauth: {
            accessToken: null,
        },
    },

    mutations: {
        login(state, token) {
            state.oauth.accessToken = token;
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

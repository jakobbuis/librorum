import Vue from 'vue';
import VueRouter from 'vue-router';

import Tags from './components/Tags';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/tags', component: Tags },
    ],
});

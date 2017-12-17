import Vue from 'vue';
import VueRouter from 'vue-router';

import Tags from './components/Tags';
import TagDetail from './components/TagDetail';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'tags', component: Tags },
        { path: '/tag/:id', name: 'tag', component: TagDetail },
    ],
});

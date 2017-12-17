import Vue from 'vue';
import VueRouter from 'vue-router';

import Tags from './components/Tags';
import TagDetail from './components/TagDetail';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/tags', name: 'tags', component: Tags },
        { path: '/tag', name: 'tag', component: TagDetail, props: true },
    ],
});

import Vue from 'vue';
import VueRouter from 'vue-router';

import Tags from './components/Tags';
import Tag from './components/Tag';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/tags', name: 'tags', component: Tags },
        { path: '/tag', name: 'tag', component: Tag, props: true },
    ],
});

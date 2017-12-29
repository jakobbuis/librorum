import Vue from 'vue';
import VueRouter from 'vue-router';

import Tags from './components/Tags';
import TagDetail from './components/TagDetail';
import AddPage from './components/AddPage';
import AddNotebook from './components/AddNotebook';
import AddTag from './components/AddTag';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'tags', component: Tags },
        { path: '/tag/:id', name: 'tag', component: TagDetail },
        { path: '/add-page', component: AddPage },
        { path: '/add-notebook', component: AddNotebook },
        { path: '/add-tag', component: AddTag },
    ],
});

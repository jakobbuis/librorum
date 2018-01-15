import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from './components/Login';
import Tags from './components/Tags';
import TagDetail from './components/TagDetail';
import AddPage from './components/AddPage';
import AddNotebook from './components/AddNotebook';
import AddTag from './components/AddTag';
import Trash from './components/Trash';
import Notebooks from './components/Notebooks';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'tags', component: Tags },
        { path: '/login', name: 'login', component: Login },
        { path: '/tag/:id', name: 'tag', component: TagDetail },
        { path: '/add-page', component: AddPage },
        { path: '/add-notebook', component: AddNotebook },
        { path: '/add-tag', component: AddTag },
        { path: '/trash', component: Trash },
        { path: '/notebooks', component: Notebooks },
    ],
});

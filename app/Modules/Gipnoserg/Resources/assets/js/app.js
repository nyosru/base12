// import vue from "vue";

import { createApp } from "vue";
import App from "./app.vue";



import { createRouter, createWebHistory } from "vue-router";

// import notFound from "./components/didrive/NoFound.vue";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
// window.Vue = require('vue').default;
// import 'bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css'

// require("confetti");
// import 'confetti';
// require('canvas-confetti');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('notFound', require('./components/didrive/NoFound.vue').default);
// Vue. // component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//  import indexPage from "./components/didrive/indexPage.vue";

// import notFound from "./components/didrive/NoFound.vue";

// import ItemsPage from "./components/didrive/ItemsPage.vue";
// import ItemsPage from "./components/didrive/ModItems.vue";


// import ItemsPage from "./components/didrive/ModItems2.vue";


// import PageIndex from './components/didrive/PageIndexComponent.vue'
// import LeftMenu from "./components/didrive/appMenu.vue";
// import ModuleNavigator from "./components/didrive/ModuleNavigator.vue";
// import ModuleNavigator from "./components/didrive/Navigator2Component.vue";


// import PageIndex from    './components/Tehnologii.vue';
import PageIndex from    './pages/index.vue';
import PageTimeline from './pages/timeline.vue';
import PageLern from './pages/lern.vue';
import PageNews from './pages/News.vue';
import PageTests from './pages/Tests.vue';
import PageTorrent from './pages/Torrent.vue';


const routes = [
    {
        path: "/index",
        name: "index",
        //     //   component: Home
        // component: () => import(/* webpackChunkName: "about" */ './components/didrive/ModItems.vue' ),
        //     //         // component: About1,
        // component: PageIndex
        components: {
        //     leftMenu: LeftMenu,
            content: PageIndex
        }
    },

    {
        path: "/timeline/:action?",
        name: "timeline",
        //     //   component: Home
        // component: () => import(/* webpackChunkName: "about" */ './components/didrive/ModItems.vue' ),
        //     //         // component: About1,
        // component: PageIndex
        components: {
        //     leftMenu: LeftMenu,
            content: PageNews
        },
    },

    {
        path: "/tests/:action?",
        name: "tests",
        //     //   component: Home
        // component: () => import(/* webpackChunkName: "about" */ './components/didrive/ModItems.vue' ),
        //     //         // component: About1,
        // component: PageIndex
        components: {
        //     leftMenu: LeftMenu,
            content: PageTests
        }
    },

    {
        path: "/find-torrent/:search?",
        name: "findTorrent",
        //     //   component: Home
        // component: () => import(/* webpackChunkName: "about" */ './components/didrive/ModItems.vue' ),
        //     //         // component: About1,
        // component: PageIndex
        components: {
        //     leftMenu: LeftMenu,
            content: PageTorrent
        }
    },

//     {
//         path: "/modules/:module",
//         name: "mod_start",
//         components: {
//             leftMenu: LeftMenu,
//             // di_content: ModuleNavigator
//             di_content: PageIndex
//             // content: PageIndex
//         }
//     },

//     // {
//     //     path: "/modules/:module/:item_id(\\d+)?/:action?",
//     //     name: "item",
//     //     //     //   component: Home
//     //     // component: () => import(/* webpackChunkName: "about" */ './components/didrive/ModItems.vue' ),
//     //     //     //         // component: About1,
//     //     // component: ItemsPage
//     //     // component: ModuleNavigator
//     //     // component: items
//     //     components: {
//     //         leftMenu: leftMenu,
//     //         content: ModuleNavigator
//     //     }
//     // },

//     //     // {
//     //     //     path: "/closer/routers",
//     //     //     name: "closer-routes",
//     //     //     //   component: Home
//     //     //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
//     //     //     component: About1,
//     //     // },
//     //     // {
//     //     //     path: "/closer/routers/list",
//     //     //     name: "closer-routes-list",
//     //     //     // route level code-splitting
//     //     //     // this generates a separate chunk (about.[hash].js) for this route
//     //     //     // which is lazy-loaded when the route is visited.
//     //     //     //   component: () => import(/* webpackChunkName: "about" */ './views/AboutList.vue')
//     //     //     component: About2,
//     //     // },

//     //     // {
//     //     //     path: "/closer/comission",
//     //     //     name: "comission",
//     //     //     //   component: Home
//     //     //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
//     //     //     component: comission,
//     //     // },

//     //     // {
//     //     //     path: "/closer/opportunities",
//     //     //     name: "opportunities",
//     //     //     //   component: Home
//     //     //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
//     //     //     component: opportunities,
//     //     // },

//     //     // {
//     //     //     path: "/closer/calls",
//     //     //     name: "calls",
//     //     //     //   component: Home
//     //     //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
//     //     //     component: calls,
//     //     // },

//     //     // {
//     //     //     path: "comission",
//     //     //     name: "comission",
//     //     //     //   component: Home
//     //     //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
//     //     //     component: comission,
//     //     // },

    // { path: "/:pathMatch(.*)*", component: notFound }
];

const routers = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    mode: "history",
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
    routes
});



const app = createApp(App);

app.use(routers);

// import CKEditor from "@ckeditor/ckeditor5-vue";
// import CKEditor from "@ckeditor/ckeditor5-vue";
// app.use(CKEditor);

app.mount("#app");

// const app = new Vue({
//     el: '#app',
// });

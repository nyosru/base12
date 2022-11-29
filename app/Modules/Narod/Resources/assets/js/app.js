import { createApp } from "vue";
import App from "./app.vue";

import { createRouter, createWebHistory } from "vue-router";

require("./bootstrap");
import 'bootstrap';








import Vitrin from './Components/Vitrin.vue';
import VitrinTrebs from './Components/VitrinTrebs/BodyComponent.vue';
import VitrinBalance from './Components/VitrinBalance/BodyComponent.vue';
import VitrinParticipation from './Components/VitrinParticipation/BodyComponent.vue';
import formReg from './Components/formReg.vue';
import PageText from './Components/PageText.vue';

const routes = [

    {
        path: "/about",
        name: "about",
        components: {
            bodyContent: PageText
        },
        meta: { page: 'about' }
    },
    {
        path: "/index",
        name: "index",
        components: {
            bodyContent: Vitrin
        }
    },
    {
        path: "/formReg",
        name: "formReg",
        components: {
            bodyContent: formReg
        },
        meta: { page: 'formReg' }

    },
    {
        path: "/documents",
        name: "pageDocuments",
        components: {
            bodyContent: PageText
        },
        meta: { page: 'documents' }
    },

    {
        path: "/trebs",
        name: "pageTrebs",
        components: {
            bodyContent: VitrinTrebs
        },
        meta: { page: 'trebs' }
    },

    {
        path: "/balance",
        name: "balance",
        components: {
            bodyContent: VitrinBalance
        },
        meta: { page: 'balance' }
    },

    {
        path: "/contacts",
        name: "contacts",
        components: {
            bodyContent: PageText
        },
        meta: { page: 'contacts' }
    },


    {
        path: "/participation",
        name: "participation",
        components: {
            bodyContent: VitrinParticipation
        },
        meta: { page: 'participation' }
    },


    { path: "/:pathMatch(.*)*", components: { bodyContent: Vitrin } }

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
app.mount("#app");
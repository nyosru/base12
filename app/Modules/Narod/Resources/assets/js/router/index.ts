import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router"

// import Abc from '@/views/WB/Abc.vue'
// import Analytics from '@/views/WB/Analytics.vue'
// import Delivery from '@/views/WB/Delivery.vue'
// import Logistics from '@/views/WB/Logistics.vue'
// import Storage from '@/views/WB/Storage.vue'
// import LeftMenu from '@/components/Common/Menu/LeftMenu.vue'
// import Profit from '@/views/WB/Profit.vue'
// import Orders from '@/views/WB/Orders.vue'
// import Sales from '@/views/WB/Sales.vue'
// import Returns from '@/views/WB/Returns.vue'
// import Store from "@/store";
// import Price from '@/views/WB/Price.vue'

import Vitrin from './../Components/Vitrin.vue'
import PageText from './../Components/PageText.vue'


const routes:Array<RouteRecordRaw> = [

	// {
	// 	path: process.env.NODE_ENV === "production" ? "/wildberries/vue/" : "/",
	// 	redirect: {name: 'wildberries-analytics'}
	// },
	// {
	// 	path: "/wildberries/",
	// 	redirect: {name: 'wildberries-analytics'}
	// },
	{
		path: "/wildberries/analytics/",
		name: "wildberries-analytics",
		meta: { AnalitickPoApi: true },
		components: {
			leftMenu: LeftMenu,
			pageContent: Analytics,
		},

	// },

	// {
	// 	path: "/wildberries/delivery/",
	// 	name: "wildberries-delivery",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Delivery,
	// 	},
	// },

	// {
	// 	path: "/wildberries/abc/",
	// 	name: "wildberries-abc",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Abc,
	// 	},
	// },
	// {
	// 	path: "/wildberries/orders/",
	// 	name: "wildberries-orders",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Orders,
	// 	},
	// },
	// {
	// 	path: "/wildberries/sales/",
	// 	name: "wildberries-sales",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Sales,
	// 	},
	// },
	// {
	// 	path: "/wildberries/returns/",
	// 	name: "wildberries-returns",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Returns,
	// 	},
	// },
	// {
	// 	path: "/wildberries/logistics/",
	// 	name: "wildberries-logistics",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Logistics,
	// 	},
	// },
	// {
	// 	path: "/wildberries/profit/",
	// 	name: "wildberries-profit",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Profit,
	// 	},
	// },
	// {
	// 	path: "/wildberries/storage/",
	// 	name: "wildberries-storage",
	// 	meta: { AnalitickPoApi: true },
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Storage,
	// 	},
	// },
	// {
	// 	path: "/wildberries/price/",
	// 	name: "wildberries-price",
	// 	components: {
	// 		leftMenu: LeftMenu,
	// 		pageContent: Price,
	// 	},
	// },

	// показ при любой ссылке
	{
		path: "/:pathMatch(.*)*", components: {
            bodyContent: Vitrin,
		}
    },

];


const router = createRouter({
	history: createWebHistory(),
	routes,
	// linkActiveClass: "active",
});

// router.beforeEach(function (to, from, next) {
// 	Store.commit('clearToken', "all") // отменить запрос
// 	next()
// })

export default router;

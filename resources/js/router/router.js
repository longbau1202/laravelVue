import { createRouter, createWebHistory } from "vue-router";

import index from '../components/user/index.vue';
import login from '../components/user/login.vue';
import detail from '../components/product/detail.vue';

const routes = [
	{
		path: '/index',
		name: 'index',
		component: index
	},
	{
		path: '/detail',
		component: detail
	},
	{
		path: '/login',
		name: 'login',
		component: login
	}
]

export default createRouter({
	history: createWebHistory(),
	routes
})
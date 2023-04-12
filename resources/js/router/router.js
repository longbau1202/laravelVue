import { createRouter, createWebHistory} from "vue-router";

import index from '../components/user/index.vue';
import login from '../components/user/login.vue';
import register from '../components/user/register.vue';
import detail from '../components/user/detail.vue';
import addProduct from '../components/product/add.vue';
import listProduct from '../components/product/list.vue';
import editProduct from '../components/product/edit.vue';

const routes = [
	{
		path: '/index',
		name: 'index',
		component: index
	},
	{
		path: '/detail',
		component: detail,
		meta: {
			requiresAuth: true // Thiết lập yêu cầu đăng nhập cho route này
		}
	},
	{
		path: '/login',
		name: 'login',
		component: login,
		meta: {
			loggedAuth: true
		}
	},
	{
		path: '/register',
		name: 'register',
		component: register,
		meta: {
			loggedAuth: true,
		}
	},
	{
		path: '/product/add',
		name: 'addProduct',
		component: addProduct,
		meta: {
			requiresAuth: true,
		}
	},
	{
		path: '/product/list',
		name: 'listProduct',
		component: listProduct,
		meta: {
			requiresAuth: true,
		}
	},
	{
		path: '/product/edit/:id',
		name: 'editProduct',
		component: editProduct,
		meta: {
			requiresAuth: true,
		},
		props: true,
	},
	
]

const router = createRouter({
	history: createWebHistory(),
	routes
});

router.beforeEach((to, from, next) => {
	const isLoggedIn = localStorage.getItem('storedData');
	if (isLoggedIn) {
		if (to.meta.loggedAuth) {
			next({ path: '/index' });
		} else {
			next();
		}
	} else {
		if (to.meta.requiresAuth) {
			// Nếu trang yêu cầu đăng nhập và người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
			next({ path: '/login' });
		} else {
			// Nếu trang không yêu cầu đăng nhập hoặc người dùng đã đăng nhập, cho phép truy cập vào trang
			next();
		}
	}
	
});

export default router;
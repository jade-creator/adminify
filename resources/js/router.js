import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@stores/auth";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('@views/auth/Login.vue'),
            meta: { requiresAuth: false },
        },
        {
            path: '/admin',
            name: 'admin',
            component: () => import('@views/admin/Panel.vue'),
            redirect: { name: 'dashboard' },
            children: [
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: () => import('@views/admin/Dashboard.vue'),
                },
                {
                    path: 'products',
                    name: 'admin.products',
                    component: () => import('@views/admin/products/ProductList.vue'),
                },
                {
                    path: 'products/create',
                    name: 'admin.products.create',
                    component: () => import('@views/admin/products/ProductCreate.vue'),
                },
                {
                    path: 'products/:id/edit',
                    name: 'admin.products.edit',
                    component: () => import('@views/admin/products/ProductEdit.vue'),
                }
            ],
            meta: { requiresAuth: true },
        },
    ],
});

router.beforeEach(async (to, from) => {
    const auth = useAuthStore();

    if (
        !auth.isAuthenticated() &&
        to.meta.requiresAuth
    ) {
        return { path: '/' };
    }

    if (
        auth.isAuthenticated() &&
        !to.meta.requiresAuth
    ) {
        return { path: '/admin' };
    }
});

export default router;

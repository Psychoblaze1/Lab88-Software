import { createRouter, createWebHistory } from "vue-router";
import moment from "moment/moment";
import store from "../store"

import PublicLayout from "../layouts/PublicLayout.vue";
import AuthLayout from "../layouts/AuthLayout.vue";

export const routes = [
    // Public Routes
    {
        name: 'NotFound',
        path: '/:catchAll(.*)',
        component: () => import('../pages/error/NotFound404.vue'),
        meta: {
            layout: PublicLayout,
            requiresAuth: false,
        },
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('../pages/Login.vue'),
        meta: {
            layout: PublicLayout,
            requiresAuth: false,
        },
    },
    // Authenticated Routes
    {
        name: 'home',
        path: '/',
        component: () => import('../pages/Home.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },
    // Accounts
    {
        name: 'accounts',
        path: '/accounts',
        component: () => import('../pages/account/AccountDash.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
        children: [
            {
                name: 'account.create',
                path: '/account/create',
                component: () => import('../pages/account/CreateAccount.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            // Documentation
            {
                name: 'documentation',
                path: '/account/documentation',
                component: () => import('../pages/Documentation.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            {
                name: 'users',
                path: '/account/users',
                component: () => import('../pages/account/UsersDash.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            // Roles
            {
                path: '/account/roles',
                name: 'role',
                component: () => import('../pages/RolePermission.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            // Support
            {
                name: 'support',
                path: '/account/support',
                component: () => import('../pages/Support.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
        ]
    },

    // Assets
    {
        name: 'asset',
        path: '/assets/:id?',
        component: () => import('../pages/asset/AssetDash.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },
    {
        name: 'assetCreate',
        path: '/asset/create',
        component: () => import('../pages/asset/CreateAsset.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },

    // Lab
    {
        name: 'lab',
        path: '/lab',
        component: () => import('../pages/lab/LabDash.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
        children: [
            {
                path: '/lab/instruments',
                name: 'instruments',
                component: () => import('../pages/lab/Instrument.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            {
                path: '/lab/test-suites',
                name: 'test-suites',
                component: () => import('../pages/lab/TestSuite.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            {
                path: '/lab/test-standards',
                name: 'test-standards',
                component: () => import('../pages/lab/TestStandards.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
            {
                path: '/lab/test-parameters',
                name: 'test-parameters',
                component: () => import('../pages/lab/TestParameters.vue'),
                meta: {
                    layout: AuthLayout,
                    requiresAuth: true,
                },
            },
        ]
    },

    // Samples
    {
        path: '/samples/',
        name: 'sample-dash',
        component: () => import('../pages/sample/SampleDash.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },
    {
        path: '/sample/:id?',
        name: 'sample-stepper',
        component: () => import('../pages/sample/SampleStepper.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },
    // Scanner
    {
        path: '/scanner',
        name: 'scanner',
        component: () => import('../pages/Scanner.vue'),
        meta: {
            layout: AuthLayout,
            requiresAuth: true,
        },
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if (to.name !== 'login') {
        if (!store.getters['auth/authenticated']) {
            next({ name: 'login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;

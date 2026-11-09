import { createRouter, createWebHistory } from 'vue-router';
import { useAuth } from './auth';

// Layouts
import AdminLayout from './layouts/AdminLayout.vue';
import VendorLayout from './layouts/VendorLayout.vue';
import CustomerLayout from './layouts/CustomerLayout.vue';

// Auth Views
import Login from './views/auth/Login.vue';

// Admin Views
import AdminDashboard from './views/admin/Dashboard.vue';
import AdminShops from './views/admin/Shops.vue';
import AdminProducts from './views/admin/Products.vue';
import AdminOwners from './views/admin/Owners.vue';

// Vendor Views
import VendorDashboard from './views/vendor/Dashboard.vue';
import VendorMyProducts from './views/vendor/MyProducts.vue';
import VendorCatalog from './views/vendor/Catalog.vue';
import VendorCreateProduct from './views/vendor/CreateProduct.vue';
import VendorSettings from './views/vendor/Settings.vue';

// Customer Views
import CustomerHome from './views/customer/Home.vue';
import ShopStorefront from './views/customer/ShopStorefront.vue';
import ProductDetail from './views/customer/ProductDetail.vue';

const routes = [
    // Customer Routes (Public)
    {
        path: '/',
        component: CustomerLayout,
        children: [
            { path: '', name: 'customer.home', component: CustomerHome },
            { path: 'shop/:slug', name: 'customer.shop', component: ShopStorefront },
            { path: 'shop/:slug/product/:productId', name: 'customer.product', component: ProductDetail },
        ]
    },

    // Auth
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guestOnly: true }
    },

    // Admin Panel (Protected, Dark Mode)
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true, role: 'admin' },
        children: [
            { path: '', name: 'admin.dashboard', component: AdminDashboard },
            { path: 'shops', name: 'admin.shops', component: AdminShops },
            { path: 'products', name: 'admin.products', component: AdminProducts },
            { path: 'owners', name: 'admin.owners', component: AdminOwners },
        ]
    },

    // Shop Owner / Vendor Panel (Protected)
    {
        path: '/vendor',
        component: VendorLayout,
        meta: { requiresAuth: true, role: 'shop_owner' },
        children: [
            { path: '', name: 'vendor.dashboard', component: VendorDashboard },
            { path: 'my-products', name: 'vendor.my-products', component: VendorMyProducts },
            { path: 'catalog', name: 'vendor.catalog', component: VendorCatalog },
            { path: 'create-product', name: 'vendor.create-product', component: VendorCreateProduct },
            { path: 'settings', name: 'vendor.settings', component: VendorSettings },
        ]
    },

    // Catch-all 404 redirect to home
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    }
});

router.beforeEach((to, from, next) => {
    const { isAuthenticated, isAdmin, isShopOwner, user } = useAuth();

    if (to.meta.guestOnly && isAuthenticated.value) {
        if (isAdmin.value) return next('/admin');
        if (isShopOwner.value) return next('/vendor');
        return next('/');
    }

    if (to.meta.requiresAuth) {
        if (!isAuthenticated.value) {
            return next({ name: 'login', query: { redirect: to.fullPath } });
        }

        if (to.meta.role === 'admin' && !isAdmin.value) {
            return next('/vendor');
        }

        if (to.meta.role === 'shop_owner' && !isShopOwner.value && !isAdmin.value) {
            return next('/admin');
        }
    }

    next();
});

export default router;


<template>
  <div class="min-h-screen bg-slate-50 flex flex-col antialiased">
    <!-- Top announcement bar -->
    <div class="bg-indigo-900 text-indigo-100 text-xs py-2 px-4 text-center font-medium">
      ✨ Multi-Shop Platform with Shared Catalog & Shop-Specific Customizations
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo -->
        <router-link to="/" class="flex items-center gap-3 group">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-500/20 group-hover:scale-105 transition">
            M
          </div>
          <div>
            <span class="text-lg font-extrabold text-slate-900 tracking-tight">Market<span class="text-indigo-600">Hub</span></span>
            <span class="text-[10px] block font-medium text-slate-500 -mt-1">Multi-Vendor Storefront</span>
          </div>
        </router-link>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center gap-6">
          <router-link
            to="/"
            class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition"
          >
            All Shops
          </router-link>
        </nav>

        <!-- Auth / Dashboards Buttons -->
        <div class="flex items-center gap-3">
          <template v-if="isAuthenticated">
            <router-link
              v-if="isAdmin"
              to="/admin"
              class="text-xs font-semibold bg-slate-900 text-white px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-1.5 shadow"
            >
              <span>Admin Panel (Dark)</span>
            </router-link>
            <router-link
              v-else-if="isShopOwner"
              to="/vendor"
              class="text-xs font-semibold bg-emerald-600 text-white px-3.5 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1.5 shadow"
            >
              <span>Shop Dashboard</span>
            </router-link>
            <button
              @click="logout"
              class="text-xs font-semibold text-rose-600 hover:text-rose-700 px-2 py-1 transition"
            >
              Log Out
            </button>
          </template>

          <template v-else>
            <router-link
              to="/login"
              class="text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-sm"
            >
              Sign In (Admin / Shop Owner)
            </router-link>
          </template>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1">
      <router-view></router-view>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16 py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500 space-y-2">
        <p class="font-medium text-slate-700">E-Commerce Management System • Laravel + Vue.js SPA</p>
        <p>Products in this customer view are scoped strictly to individual active shops. Products not assigned to any shop remain hidden.</p>
        <p class="text-slate-400">© 2026 MarketHub System. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { useAuth } from '../auth';

const { isAuthenticated, isAdmin, isShopOwner, logout } = useAuth();
</script>


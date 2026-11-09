<template>
  <div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Overview Dashboard</h1>
        <p class="text-sm text-slate-400 mt-1">Platform management, shops directory, and shared product catalog metrics.</p>
      </div>

      <div class="flex items-center gap-3">
        <router-link
          to="/admin/shops"
          class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20"
        >
          + Add New Shop
        </router-link>
        <router-link
          to="/admin/products"
          class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold border border-slate-700 transition"
        >
          + Add Catalog Product
        </router-link>
      </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <!-- Total Shops -->
      <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl relative overflow-hidden group hover:border-slate-700 transition">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Shops</span>
          <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-black text-white">{{ stats.total_shops || 0 }}</span>
          <span class="text-xs text-emerald-400 font-medium">Active Stores</span>
        </div>
        <router-link to="/admin/shops" class="mt-3 inline-block text-xs text-indigo-400 hover:text-indigo-300 font-medium">
          Manage Shops &rarr;
        </router-link>
      </div>

      <!-- Catalog Products -->
      <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl relative overflow-hidden group hover:border-slate-700 transition">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Shared Catalog</span>
          <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-black text-white">{{ stats.total_products || 0 }}</span>
          <span class="text-xs text-purple-400 font-medium">Master Items</span>
        </div>
        <router-link to="/admin/products" class="mt-3 inline-block text-xs text-purple-400 hover:text-purple-300 font-medium">
          Manage Catalog &rarr;
        </router-link>
      </div>

      <!-- Shop Owners -->
      <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl relative overflow-hidden group hover:border-slate-700 transition">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Shop Owners</span>
          <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-black text-white">{{ stats.total_owners || 0 }}</span>
          <span class="text-xs text-emerald-400 font-medium">Registered</span>
        </div>
        <router-link to="/admin/owners" class="mt-3 inline-block text-xs text-emerald-400 hover:text-emerald-300 font-medium">
          Manage Accounts &rarr;
        </router-link>
      </div>

      <!-- Active Shop Listings -->
      <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl relative overflow-hidden group hover:border-slate-700 transition">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Shop Listings</span>
          <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-black text-white">{{ stats.total_shop_listings || 0 }}</span>
          <span class="text-xs text-amber-400 font-medium">Customer-Visible</span>
        </div>
        <p class="mt-3 text-xs text-slate-400">Assigned products across all shops</p>
      </div>
    </div>

    <!-- Recent Shops & Recent Products Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Recent Shops -->
      <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-5">
          <h2 class="text-base font-bold text-white flex items-center gap-2">
            <span>Recent Shops</span>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 border border-slate-700">Top 5</span>
          </h2>
          <router-link to="/admin/shops" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">
            View All &rarr;
          </router-link>
        </div>

        <div class="divide-y divide-slate-800/80">
          <div
            v-for="shop in stats.recent_shops"
            :key="shop.id"
            class="py-3.5 flex items-center justify-between hover:bg-slate-800/40 px-2 rounded-xl transition"
          >
            <div class="flex items-center gap-3">
              <img
                :src="shop.logo || 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=100'"
                class="w-10 h-10 rounded-xl object-cover bg-slate-800 border border-slate-700"
                alt="logo"
              />
              <div>
                <p class="text-sm font-semibold text-white">{{ shop.name }}</p>
                <p class="text-xs text-slate-400">Owner: {{ shop.owner?.name || 'Unassigned' }}</p>
              </div>
            </div>
            <div class="text-right">
              <span
                class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold"
                :class="shop.status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'"
              >
                {{ shop.status }}
              </span>
              <p class="text-[11px] text-slate-400 mt-1">/shop/{{ shop.slug }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Shared Catalog Products -->
      <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-5">
          <h2 class="text-base font-bold text-white flex items-center gap-2">
            <span>Catalog Items</span>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-800 text-slate-400 border border-slate-700">Recent</span>
          </h2>
          <router-link to="/admin/products" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">
            View All &rarr;
          </router-link>
        </div>

        <div class="divide-y divide-slate-800/80">
          <div
            v-for="product in stats.recent_products"
            :key="product.id"
            class="py-3.5 flex items-center justify-between hover:bg-slate-800/40 px-2 rounded-xl transition"
          >
            <div class="flex items-center gap-3">
              <img
                :src="product.default_thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'"
                class="w-10 h-10 rounded-xl object-cover bg-slate-800 border border-slate-700"
                alt="thumb"
              />
              <div class="max-w-[200px] truncate">
                <p class="text-sm font-semibold text-white truncate">{{ product.title }}</p>
                <p class="text-xs text-slate-400 flex items-center gap-1.5">
                  <span>{{ product.category || 'General' }}</span>
                  <span>•</span>
                  <span class="text-indigo-400 font-medium">By: {{ product.creator?.name || 'Admin' }}</span>
                </p>
              </div>
            </div>
            <div class="text-right">
              <span class="text-sm font-bold text-white">${{ parseFloat(product.default_price).toFixed(2) }}</span>
              <p class="text-[11px] text-slate-400 mt-0.5">{{ product.sku || 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const stats = ref({
    total_shops: 0,
    total_products: 0,
    total_owners: 0,
    total_shop_listings: 0,
    recent_shops: [],
    recent_products: [],
});

const loadStats = async () => {
    try {
        const res = await api.get('/admin/stats');
        stats.value = res.data;
    } catch (err) {
        console.error('Failed to load admin stats:', err);
    }
};

onMounted(() => {
    loadStats();
});
</script>


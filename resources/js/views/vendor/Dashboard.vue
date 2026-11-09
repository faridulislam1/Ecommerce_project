<template>
  <div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
          {{ shopData.shop?.name || 'My Shop' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
          Manage your shop's inventory from the shared catalog or introduce your own custom creations.
        </p>
      </div>

      <div class="flex items-center gap-3">
        <router-link
          to="/vendor/catalog"
          class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-emerald-600/20 flex items-center gap-2"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Browse Shared Catalog
        </router-link>

        <router-link
          v-if="shopData.shop?.slug"
          :to="'/shop/' + shopData.shop.slug"
          target="_blank"
          class="px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5"
        >
          <span>Live Customer View</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
        </router-link>
      </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-500">My Listed Products</span>
          <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-slate-900">{{ shopData.stats?.total_listings || 0 }}</span>
          <span class="text-xs text-slate-500">Active in Store</span>
        </div>
        <router-link to="/vendor/my-products" class="mt-3 inline-block text-xs text-emerald-600 font-semibold hover:underline">
          Manage listings & custom prices &rarr;
        </router-link>
      </div>

      <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Customer Visible</span>
          <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-slate-900">{{ shopData.stats?.active_listings || 0 }}</span>
          <span class="text-xs text-emerald-600 font-medium">In Stock & Ready</span>
        </div>
        <p class="mt-3 text-xs text-slate-500">Only assigned products appear to customers</p>
      </div>

      <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Shared Catalog Pool</span>
          <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
          </div>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-slate-900">{{ shopData.stats?.available_in_catalog || 0 }}</span>
          <span class="text-xs text-slate-500">Available Products</span>
        </div>
        <router-link to="/vendor/catalog" class="mt-3 inline-block text-xs text-purple-600 font-semibold hover:underline">
          Explore products to sell &rarr;
        </router-link>
      </div>
    </div>

    <!-- Quick action banner -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="space-y-1">
        <h3 class="text-lg font-bold">Have a unique product to sell?</h3>
        <p class="text-xs text-emerald-100 max-w-xl">
          When you create a new product, it will automatically list inside your shop AND become available in the Shared Catalog for other merchants to discover!
        </p>
      </div>
      <router-link
        to="/vendor/create-product"
        class="shrink-0 px-5 py-2.5 bg-white text-emerald-800 hover:bg-emerald-50 rounded-xl font-bold text-xs transition shadow"
      >
        + Create New Product
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const shopData = ref({
    shop: null,
    stats: {
        total_listings: 0,
        active_listings: 0,
        available_in_catalog: 0,
    }
});

const loadShop = async () => {
    try {
        const res = await api.get('/vendor/shop');
        shopData.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

onMounted(() => {
    loadShop();
});
</script>


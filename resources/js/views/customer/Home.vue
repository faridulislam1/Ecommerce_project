<template>
  <div class="space-y-12">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
      
      <div class="max-w-4xl mx-auto text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          Multi-Vendor E-Commerce Platform
        </span>

        <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight">
          Discover Verified Independent Shops & Curated Products
        </h1>

        <p class="text-base text-indigo-200 max-w-2xl mx-auto">
          Explore individual shop storefronts powered by our shared product catalog. Each merchant tailors prices, product details, and exclusive deals for their store.
        </p>

        <!-- Search Shops -->
        <div class="max-w-xl mx-auto pt-4">
          <div class="relative">
            <input
              v-model="searchQuery"
              @input="loadShops"
              type="text"
              placeholder="Search shops by name, category, or city..."
              class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-indigo-200/70 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:bg-white/20"
            />
            <svg class="w-5 h-5 text-indigo-300 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Overview Banner -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
          <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div>
            <h2 class="text-sm font-bold text-slate-900">Shop-Centric Storefronts</h2>
            <p class="text-xs text-slate-500 mt-0.5">Customers browse specifically by shop. Only items assigned to that shop are displayed.</p>
          </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
          <div>
            <h2 class="text-sm font-bold text-slate-900">Shared Catalog Architecture</h2>
            <p class="text-xs text-slate-500 mt-0.5">Products created by admins or any shop owner become available across the entire network.</p>
          </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
          <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-sm font-bold text-slate-900">Shop-Specific Pricing & Photos</h2>
            <p class="text-xs text-slate-500 mt-0.5">Each merchant sets their own prices, custom thumbnails, and descriptions for their listings.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Shops Directory -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
      <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
          <h2 class="text-2xl font-extrabold text-slate-900">Explore Active Shops</h2>
          <p class="text-xs text-slate-500 mt-0.5">Select a shop below to enter its storefront and view its specific product catalog.</p>
        </div>
        <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
          {{ shops.length }} shops ready
        </span>
      </div>

      <!-- Shops Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="shop in shops"
          :key="shop.id"
          class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
        >
          <!-- Banner -->
          <div class="relative h-36 bg-slate-200 overflow-hidden">
            <img
              :src="shop.banner || 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600'"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
              alt="Shop Banner"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

            <div class="absolute top-3 right-3">
              <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/95 text-emerald-700 shadow flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                {{ shop.shop_products_count || 0 }} products
              </span>
            </div>
          </div>

          <!-- Body with overlapping Logo -->
          <div class="p-6 pt-0 flex-1 flex flex-col justify-between relative">
            <div class="-mt-10 mb-4 flex items-end justify-between">
              <img
                :src="shop.logo || 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=100'"
                class="w-16 h-16 rounded-2xl object-cover bg-white p-1 border-2 border-white shadow-md"
                alt="Shop Logo"
              />
            </div>

            <div class="space-y-2">
              <h3 class="text-lg font-black text-slate-900 group-hover:text-indigo-600 transition">
                {{ shop.name }}
              </h3>
              <p class="text-xs text-slate-500 line-clamp-2">
                {{ shop.description || 'Welcome to our shop! Discover high quality products.' }}
              </p>

              <div v-if="shop.address" class="text-[11px] text-slate-400 flex items-center gap-1 pt-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate">{{ shop.address }}</span>
              </div>
            </div>

            <!-- Footer Action -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
              <span class="text-xs font-semibold text-indigo-600 group-hover:underline">
                Browse Shop Catalog &rarr;
              </span>

              <router-link
                :to="'/shop/' + shop.slug"
                class="px-4 py-2 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl text-xs font-bold transition shadow-sm"
              >
                Enter Shop
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="shops.length === 0" class="py-16 text-center text-slate-500 bg-white rounded-3xl border border-slate-200">
        <p class="text-base font-semibold text-slate-700">No shops found matching your search.</p>
        <p class="text-xs text-slate-400 mt-1">Try searching with a different term.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const shops = ref([]);
const searchQuery = ref('');

const loadShops = async () => {
    try {
        const res = await api.get('/customer/shops', { params: { search: searchQuery.value } });
        shops.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

onMounted(() => {
    loadShops();
});
</script>


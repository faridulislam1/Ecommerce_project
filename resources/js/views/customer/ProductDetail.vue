<template>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-slate-500">
      <router-link to="/" class="hover:text-indigo-600 transition">All Shops</router-link>
      <span>&rsaquo;</span>
      <router-link :to="'/shop/' + (shop?.slug || '')" class="hover:text-indigo-600 transition font-semibold text-slate-700">
        {{ shop?.name || 'Shop' }}
      </router-link>
      <span>&rsaquo;</span>
      <span class="text-slate-900 font-bold truncate max-w-xs">{{ product?.title }}</span>
    </nav>

    <!-- Loading State -->
    <div v-if="isLoading" class="py-24 text-center">
      <div class="inline-block w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
      <p class="text-xs text-slate-500 mt-3">Loading product details...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="errorMessage" class="p-8 bg-white border border-rose-200 rounded-3xl text-center space-y-4">
      <h2 class="text-xl font-bold text-slate-900">Product Unavailable</h2>
      <p class="text-xs text-slate-500">{{ errorMessage }}</p>
      <router-link :to="'/shop/' + (shop?.slug || '')" class="inline-block px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md">
        Return to Shop Storefront
      </router-link>
    </div>

    <!-- Main Product Section -->
    <div v-else class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 p-6 sm:p-10">
      <!-- Image Column -->
      <div class="space-y-4">
        <div class="h-96 sm:h-[450px] bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 relative">
          <img
            :src="product.thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800'"
            class="w-full h-full object-cover"
            alt="Product image"
          />

          <div v-if="product.has_custom_price && product.price < product.default_price" class="absolute top-4 left-4">
            <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-500 text-white shadow-lg">
              SPECIAL DEAL
            </span>
          </div>
        </div>

        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between text-xs text-slate-500">
          <span>SKU: <strong class="font-mono text-slate-700">{{ product.sku || 'N/A' }}</strong></span>
          <span>Category: <strong class="text-slate-700">{{ product.category }}</strong></span>
          <span>Stock: <strong class="text-emerald-700">{{ product.stock }} units</strong></span>
        </div>
      </div>

      <!-- Information Column -->
      <div class="flex flex-col justify-between space-y-6">
        <div class="space-y-4">
          <!-- Shop Badge -->
          <router-link
            :to="'/shop/' + shop.slug"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold hover:bg-indigo-100 transition"
          >
            <img :src="shop.logo" class="w-4 h-4 rounded-full object-cover" alt="Shop logo"/>
            <span>Sold by {{ shop.name }}</span>
            <span class="text-indigo-400">&rarr;</span>
          </router-link>

          <!-- Title -->
          <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
            {{ product.title }}
          </h1>

          <!-- Price -->
          <div class="flex items-baseline gap-3 pt-2">
            <span class="text-3xl font-black text-slate-900">
              ${{ product.price.toFixed(2) }}
            </span>
            <span
              v-if="product.has_custom_price && product.price !== product.default_price"
              class="line-through text-sm text-slate-400 font-semibold"
            >
              Master Catalog: ${{ product.default_price.toFixed(2) }}
            </span>
          </div>

          <!-- Description -->
          <div class="pt-4 border-t border-slate-100">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Product Overview & Details</h2>
            <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
              {{ product.description }}
            </p>
          </div>

          <!-- Merchant Info Card -->
          <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 text-xs">
            <div class="font-bold text-slate-900 flex items-center justify-between">
              <span>Merchant Guarantee</span>
              <span class="text-emerald-600 font-semibold">In Stock & Verified</span>
            </div>
            <p class="text-slate-500">
              This listing is maintained directly by <strong>{{ shop.name }}</strong>. Contact merchant at <strong>{{ shop.phone || 'Email in profile' }}</strong> for inquiries.
            </p>
          </div>
        </div>

        <!-- Back to Storefront button -->
        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
          <router-link
            :to="'/shop/' + shop.slug"
            class="px-6 py-3 bg-slate-900 hover:bg-indigo-600 text-white rounded-xl text-xs font-bold transition shadow-sm inline-flex items-center gap-2"
          >
            <span>&larr; Back to {{ shop.name }} Catalog</span>
          </router-link>

          <router-link
            to="/"
            class="text-xs text-slate-500 hover:text-slate-800 font-semibold transition"
          >
            Browse Other Shops
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../api';

const route = useRoute();
const isLoading = ref(true);
const errorMessage = ref('');

const shop = ref(null);
const product = ref(null);

const loadProduct = async () => {
    isLoading.value = true;
    errorMessage.value = '';
    try {
        const slug = route.params.slug;
        const productId = route.params.productId;
        const res = await api.get(`/customer/shops/${slug}/products/${productId}`);
        shop.value = res.data.shop;
        product.value = res.data.product;
    } catch (err) {
        errorMessage.value = err.response?.data?.message || 'This product is not currently available in this shop.';
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    loadProduct();
});
</script>


<template>
  <div class="space-y-8">
    <!-- Loading State -->
    <div v-if="isLoading" class="max-w-7xl mx-auto px-4 py-20 text-center">
      <div class="inline-block w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
      <p class="text-xs text-slate-500 mt-3">Loading shop storefront...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="errorMessage" class="max-w-xl mx-auto my-16 p-8 bg-white border border-rose-200 rounded-3xl text-center space-y-4">
      <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">!</div>
      <h2 class="text-xl font-bold text-slate-900">Shop Not Found</h2>
      <p class="text-xs text-slate-500">{{ errorMessage }}</p>
      <router-link to="/" class="inline-block px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md">
        Browse All Shops &rarr;
      </router-link>
    </div>

    <!-- Main Storefront -->
    <div v-else class="space-y-8">
      <!-- Shop Banner & Header Profile -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
          <!-- Banner Image -->
          <div class="h-48 sm:h-64 bg-slate-200 relative overflow-hidden">
            <img
              :src="shop.banner || 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1200'"
              class="w-full h-full object-cover"
              alt="Shop Banner"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
          </div>

          <!-- Shop Info Row -->
          <div class="px-6 sm:px-10 pb-8 pt-0 relative bg-white">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
              <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                <!-- Floating Logo Only -->
                <div class="-mt-14 sm:-mt-16 shrink-0 relative z-10">
                  <img
                    :src="shop.logo || 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=150'"
                    class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl object-cover bg-white p-1.5 border-4 border-white shadow-xl"
                    alt="Shop Logo"
                  />
                </div>

                <!-- Shop Titles & Meta (Comfortably placed on solid white background) -->
                <div class="space-y-1.5 pt-2 sm:pt-4">
                  <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ shop.name }}</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                      Verified Merchant
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">{{ shop.description || 'Welcome to our verified online shop storefront.' }}</p>
                  <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-2">
                    <span v-if="shop.phone" class="flex items-center gap-1.5 font-medium">
                      <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                      {{ shop.phone }}
                    </span>
                    <span v-if="shop.address" class="flex items-center gap-1.5 font-medium">
                      <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                      {{ shop.address }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Switch Shop Button -->
              <div class="shrink-0 pt-2 sm:pt-4">
                <router-link
                  to="/"
                  class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition shadow-sm border border-slate-200"
                >
                  <span>&larr; Switch Shop</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Scope Notice Card -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-indigo-50/70 border border-indigo-200/60 rounded-2xl p-4 flex items-center justify-between gap-4 text-xs">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div>
              <span class="font-bold text-indigo-900">Shop Scoped Catalog:</span>
              <span class="text-indigo-800 ml-1">
                Showing <strong>{{ products.length }}</strong> products currently assigned to <strong>{{ shop.name }}</strong>. 
                Prices, details, and thumbnails below reflect this merchant's customized settings. Unassigned products are not shown.
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter & Search Controls -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white border border-slate-200 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
          <!-- Search in this shop -->
          <div class="relative flex-1 w-full sm:max-w-md">
            <input
              v-model="searchQuery"
              @input="loadStorefront"
              type="text"
              :placeholder="'Search products inside ' + shop.name + '...'"
              class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>

          <!-- Category Chips -->
          <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
            <button
              @click="setCategory('all')"
              class="px-3 py-1.5 rounded-xl text-xs font-semibold transition shrink-0"
              :class="selectedCategory === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
              All ({{ totalProducts }})
            </button>
            <button
              v-for="cat in categories"
              :key="cat"
              @click="setCategory(cat)"
              class="px-3 py-1.5 rounded-xl text-xs font-semibold transition shrink-0"
              :class="selectedCategory === cat ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
              {{ cat }}
            </button>
          </div>
        </div>

        <!-- Products Grid (ONLY ASSIGNED PRODUCTS FOR THIS SHOP) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div
            v-for="product in products"
            :key="product.shop_product_id"
            class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
          >
            <!-- Product Thumbnail (Shop-Specific) -->
            <div class="relative h-52 bg-slate-100 overflow-hidden cursor-pointer" @click="openQuickView(product)">
              <img
                :src="product.thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                alt="Product thumbnail"
              />

              <!-- Custom Price Discount Badge -->
              <div v-if="product.has_custom_price && product.price < product.default_price" class="absolute top-3 left-3">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-rose-500 text-white shadow-md">
                  SAVE ${{ (product.default_price - product.price).toFixed(2) }}
                </span>
              </div>

              <!-- Shop Exclusive Badge -->
              <div v-if="product.has_custom_price || product.title !== product.default_title" class="absolute top-3 right-3">
                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/90 backdrop-blur-sm text-indigo-700 shadow-sm border border-indigo-100">
                  Shop Special
                </span>
              </div>

              <!-- Stock Tag -->
              <div class="absolute bottom-3 left-3">
                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-black/60 text-white backdrop-blur-sm">
                  {{ product.stock > 0 ? `${product.stock} in stock` : 'Out of stock' }}
                </span>
              </div>
            </div>

            <!-- Body -->
            <div class="p-5 flex-1 flex flex-col justify-between">
              <div>
                <span class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wider block mb-1">
                  {{ product.category }}
                </span>

                <!-- Display Shop-Specific Title -->
                <h3
                  @click="openQuickView(product)"
                  class="font-bold text-slate-900 text-sm line-clamp-1 group-hover:text-indigo-600 transition cursor-pointer"
                  :title="product.title"
                >
                  {{ product.title }}
                </h3>

                <!-- Display Shop-Specific Description -->
                <p class="text-xs text-slate-500 line-clamp-2 mt-1.5">
                  {{ product.description || 'Quality product available in this shop.' }}
                </p>
              </div>

              <!-- Pricing & Action Row -->
              <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                  <!-- Strikethrough if custom price is different -->
                  <span
                    v-if="product.has_custom_price && product.price !== product.default_price"
                    class="line-through text-xs text-slate-400 block"
                  >
                    ${{ product.default_price.toFixed(2) }}
                  </span>

                  <!-- Display Shop-Specific Price -->
                  <span class="text-lg font-black text-slate-900">
                    ${{ product.price.toFixed(2) }}
                  </span>
                </div>

                <button
                  @click="openQuickView(product)"
                  class="px-3.5 py-1.5 bg-slate-900 group-hover:bg-indigo-600 text-white rounded-xl text-xs font-bold transition shadow-sm"
                >
                  View Item
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty Products for this Shop -->
        <div v-if="products.length === 0" class="py-16 text-center text-slate-500 bg-white rounded-3xl border border-slate-200">
          <p class="text-base font-semibold text-slate-700">No products match your criteria in this shop.</p>
          <p class="text-xs text-slate-400 mt-1">Try clearing your search query or selecting a different category.</p>
        </div>
      </div>
    </div>

    <!-- Quick View Modal -->
    <div v-if="selectedProduct" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl relative border border-slate-200">
        <button
          @click="selectedProduct = null"
          class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white/90 text-slate-700 hover:text-black flex items-center justify-center text-xl font-bold shadow"
        >
          &times;
        </button>

        <div class="grid grid-cols-1 sm:grid-cols-2">
          <!-- Image -->
          <div class="h-64 sm:h-full bg-slate-100 relative">
            <img
              :src="selectedProduct.thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600'"
              class="w-full h-full object-cover"
              alt="Product thumbnail"
            />
          </div>

          <!-- Content -->
          <div class="p-6 sm:p-8 flex flex-col justify-between space-y-4">
            <div>
              <div class="flex items-center gap-2 text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                <span>{{ selectedProduct.category }}</span>
                <span>•</span>
                <span class="text-slate-400 font-mono">{{ selectedProduct.sku || '' }}</span>
              </div>

              <h2 class="text-xl font-black text-slate-900 mt-1">
                {{ selectedProduct.title }}
              </h2>

              <p class="text-xs text-slate-600 leading-relaxed mt-3">
                {{ selectedProduct.description }}
              </p>

              <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 space-y-1">
                <div>Sold exclusively by: <strong class="text-slate-800">{{ shop.name }}</strong></div>
                <div>Availability: <strong class="text-emerald-700">{{ selectedProduct.stock }} in stock</strong></div>
              </div>
            </div>

            <!-- Price & Button -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
              <div>
                <span v-if="selectedProduct.has_custom_price && selectedProduct.price !== selectedProduct.default_price" class="text-xs line-through text-slate-400 block">
                  Catalog: ${{ selectedProduct.default_price.toFixed(2) }}
                </span>
                <span class="text-2xl font-black text-slate-900">
                  ${{ selectedProduct.price.toFixed(2) }}
                </span>
              </div>

              <router-link
                :to="'/shop/' + shop.slug + '/product/' + selectedProduct.shop_product_id"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-indigo-600/20"
              >
                Full Product Page &rarr;
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../api';

const route = useRoute();
const isLoading = ref(true);
const errorMessage = ref('');

const shop = ref({});
const products = ref([]);
const categories = ref([]);
const totalProducts = ref(0);

const searchQuery = ref('');
const selectedCategory = ref('all');
const selectedProduct = ref(null);

const loadStorefront = async () => {
    isLoading.value = true;
    errorMessage.value = '';
    try {
        const slug = route.params.slug;
        const res = await api.get(`/customer/shops/${slug}`, {
            params: {
                search: searchQuery.value,
                category: selectedCategory.value,
            }
        });

        shop.value = res.data.shop;
        products.value = res.data.products;
        categories.value = res.data.categories;
        totalProducts.value = res.data.total_products;
    } catch (err) {
        errorMessage.value = err.response?.data?.message || 'This shop does not exist or has been deactivated.';
    } finally {
        isLoading.value = false;
    }
};

const setCategory = (cat) => {
    selectedCategory.value = cat;
    loadStorefront();
};

const openQuickView = (product) => {
    selectedProduct.value = product;
};

watch(() => route.params.slug, () => {
    loadStorefront();
});

onMounted(() => {
    loadStorefront();
});
</script>


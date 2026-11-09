<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Shared Product Catalog</h1>
        <p class="text-sm text-slate-500 mt-1">
          Browse items created by administrators and other shop owners. Select any item to list in your shop!
        </p>
      </div>

      <router-link
        to="/vendor/create-product"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-emerald-600/20"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Create My Own Product</span>
      </router-link>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
      <div class="relative flex-1 w-full sm:max-w-md">
        <input
          v-model="searchQuery"
          @input="loadCatalog"
          type="text"
          placeholder="Search catalog by title, SKU, or keywords..."
          class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500"
        />
        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
        <span class="text-xs text-slate-500 font-medium">{{ catalog.length }} master items available</span>
      </div>
    </div>

    <!-- Product Catalog Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div
        v-for="product in catalog"
        :key="product.id"
        class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group"
      >
        <!-- Product Image & Badges -->
        <div class="relative h-48 bg-slate-100 overflow-hidden">
          <img
            :src="product.default_thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            alt="Product"
          />

          <!-- Status / In Shop Badge -->
          <div class="absolute top-3 right-3 flex flex-col gap-1.5 items-end">
            <span
              v-if="product.is_added_to_shop"
              class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-600 text-white shadow-md flex items-center gap-1"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
              </svg>
              In Your Shop
            </span>
          </div>

          <!-- Creator Badge -->
          <div class="absolute bottom-3 left-3">
            <span
              class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-white/90 backdrop-blur-sm text-slate-700 shadow-sm border border-slate-200"
            >
              By: {{ product.creator?.name || 'Platform Admin' }}
            </span>
          </div>
        </div>

        <!-- Body -->
        <div class="p-5 flex-1 flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
              <span>{{ product.category || 'General' }}</span>
              <span class="font-mono text-[11px]">{{ product.sku || '' }}</span>
            </div>

            <h3 class="font-bold text-slate-900 text-sm line-clamp-1 group-hover:text-emerald-600 transition">
              {{ product.title }}
            </h3>

            <p class="text-xs text-slate-500 line-clamp-2 mt-1.5">
              {{ product.description || 'No description provided.' }}
            </p>
          </div>

          <!-- Price & Action Button -->
          <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
            <div>
              <span class="text-[10px] text-slate-400 block uppercase font-medium">Catalog Price</span>
              <span class="text-base font-extrabold text-slate-900">
                ${{ parseFloat(product.default_price).toFixed(2) }}
              </span>
            </div>

            <button
              v-if="!product.is_added_to_shop"
              @click="openAddModal(product)"
              class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5"
            >
              <span>+ Add to Shop</span>
            </button>

            <router-link
              v-else
              to="/vendor/my-products"
              class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition"
            >
              Edit in My Shop
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="catalog.length === 0" class="py-16 text-center text-slate-500 bg-white rounded-2xl border border-slate-200">
      <p class="text-base font-semibold text-slate-700">No catalog products match your search.</p>
      <p class="text-xs text-slate-400 mt-1">Try clearing your filters or create a new product from scratch.</p>
    </div>

    <!-- Add to Shop Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-lg p-6 shadow-2xl space-y-5 text-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
          <div>
            <h3 class="text-base font-bold text-slate-900">Add Product to My Shop</h3>
            <p class="text-xs text-slate-500 truncate max-w-sm">{{ selectedProduct?.title }}</p>
          </div>
          <button @click="showModal = false" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 flex items-center gap-3">
          <img
            :src="selectedProduct?.default_thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'"
            class="w-12 h-12 rounded-lg object-cover border border-slate-200"
            alt="product"
          />
          <div class="text-xs">
            <span class="font-bold text-slate-900">{{ selectedProduct?.title }}</span>
            <span class="block text-slate-500">Catalog Default Price: <strong class="text-slate-800">${{ parseFloat(selectedProduct?.default_price || 0).toFixed(2) }}</strong></span>
          </div>
        </div>

        <form @submit.prevent="submitAddToShop" class="space-y-4 text-xs">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
                My Shop Price ($)
              </label>
              <input
                v-model="form.custom_price"
                type="number"
                step="0.01"
                class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                :placeholder="'Default: $' + parseFloat(selectedProduct?.default_price || 0).toFixed(2)"
              />
              <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to use catalog default price.</span>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
                Stock Quantity *
              </label>
              <input
                v-model="form.stock"
                type="number"
                required
                min="0"
                class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              />
            </div>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Title (Optional)
            </label>
            <input
              v-model="form.custom_title"
              type="text"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              placeholder="Leave blank to use master title"
            />
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Description / Shop Details (Optional)
            </label>
            <textarea
              v-model="form.custom_description"
              rows="2"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              placeholder="Leave blank to use master description"
            ></textarea>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Thumbnail URL (Optional)
            </label>
            <input
              v-model="form.custom_thumbnail"
              type="text"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              placeholder="Leave blank to use catalog image"
            />
          </div>

          <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
            <button @click="showModal = false" type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
              Cancel
            </button>
            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition">
              Confirm & Add to My Shop
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const catalog = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const selectedProduct = ref(null);

const form = ref({
    product_id: null,
    custom_price: '',
    custom_title: '',
    custom_description: '',
    custom_thumbnail: '',
    stock: 50,
});

const loadCatalog = async () => {
    try {
        const res = await api.get('/vendor/catalog', { params: { search: searchQuery.value } });
        catalog.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const openAddModal = (product) => {
    selectedProduct.value = product;
    form.value = {
        product_id: product.id,
        custom_price: '',
        custom_title: '',
        custom_description: '',
        custom_thumbnail: '',
        stock: 50,
    };
    showModal.value = true;
};

const submitAddToShop = async () => {
    try {
        await api.post('/vendor/add-to-shop', {
            ...form.value,
            custom_price: form.value.custom_price !== '' ? form.value.custom_price : null,
        });
        showModal.value = false;
        loadCatalog();
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to add product to shop.');
    }
};

onMounted(() => {
    loadCatalog();
});
</script>


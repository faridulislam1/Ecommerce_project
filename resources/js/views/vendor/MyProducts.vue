<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">My Shop's Product Listings</h1>
        <p class="text-sm text-slate-500 mt-1">
          Customize prices, descriptions, and thumbnails specifically for your shop. Customers only see these assigned products!
        </p>
      </div>

      <router-link
        to="/vendor/catalog"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-emerald-600/20"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Add from Catalog</span>
      </router-link>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white border border-slate-200 p-4 rounded-2xl flex items-center justify-between gap-4 shadow-sm">
      <div class="relative flex-1 max-w-md">
        <input
          v-model="searchQuery"
          @input="loadListings"
          type="text"
          placeholder="Search by product title or SKU..."
          class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500"
        />
        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <span class="text-xs text-slate-500 font-medium">Total: {{ listings.length }} products</span>
    </div>

    <!-- Listings Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-600">
          <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200 tracking-wider">
            <tr>
              <th class="py-3.5 px-4">Product Details (Customer View)</th>
              <th class="py-3.5 px-4">Catalog Default</th>
              <th class="py-3.5 px-4">My Custom Price</th>
              <th class="py-3.5 px-4 text-center">Stock</th>
              <th class="py-3.5 px-4 text-center">Custom Overrides</th>
              <th class="py-3.5 px-4 text-center">Status</th>
              <th class="py-3.5 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="item in listings" :key="item.id" class="hover:bg-slate-50/80 transition">
              <!-- Thumbnail & Title -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <div class="relative shrink-0">
                    <img
                      :src="item.display_thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'"
                      class="w-12 h-12 rounded-xl object-cover bg-slate-100 border border-slate-200 shadow-sm"
                      alt="thumbnail"
                    />
                    <span
                      v-if="item.custom_thumbnail"
                      title="Custom Thumbnail Active"
                      class="absolute -top-1 -right-1 w-3 h-3 bg-indigo-500 border-2 border-white rounded-full"
                    ></span>
                  </div>

                  <div class="max-w-xs">
                    <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                      <span>{{ item.display_title }}</span>
                      <span v-if="item.custom_title" class="text-[10px] bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded border border-indigo-200 font-normal">Custom Title</span>
                    </div>
                    <div class="text-[11px] text-slate-500 truncate mt-0.5">
                      {{ item.display_description || item.product?.description || 'No description' }}
                    </div>
                  </div>
                </div>
              </td>

              <!-- Catalog Default Price -->
              <td class="py-3.5 px-4 text-slate-500">
                <span class="line-through">${{ parseFloat(item.product?.default_price || 0).toFixed(2) }}</span>
                <span class="block text-[10px] text-slate-400">Master price</span>
              </td>

              <!-- Shop Custom Price -->
              <td class="py-3.5 px-4">
                <div v-if="item.custom_price !== null && item.custom_price !== ''">
                  <span class="font-bold text-emerald-700 text-sm">${{ parseFloat(item.custom_price).toFixed(2) }}</span>
                  <span class="block text-[10px] text-emerald-600 font-semibold">Custom Price</span>
                </div>
                <div v-else>
                  <span class="font-bold text-slate-700 text-sm">${{ parseFloat(item.product?.default_price || 0).toFixed(2) }}</span>
                  <span class="block text-[10px] text-slate-400">Using Default</span>
                </div>
              </td>

              <!-- Stock -->
              <td class="py-3.5 px-4 text-center">
                <span class="font-semibold text-slate-700">{{ item.stock }} in stock</span>
              </td>

              <!-- Overrides Badge -->
              <td class="py-3.5 px-4 text-center">
                <div class="inline-flex flex-col gap-1 text-[10px]">
                  <span v-if="item.custom_price !== null" class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-semibold border border-emerald-200">Price Overridden</span>
                  <span v-if="item.custom_title" class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full font-semibold border border-indigo-200">Title Overridden</span>
                  <span v-if="item.custom_thumbnail" class="bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full font-semibold border border-purple-200">Image Overridden</span>
                  <span v-if="item.custom_price === null && !item.custom_title && !item.custom_thumbnail" class="text-slate-400">None (Defaults)</span>
                </div>
              </td>

              <!-- Availability -->
              <td class="py-3.5 px-4 text-center">
                <span
                  class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold"
                  :class="item.is_available ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'"
                >
                  {{ item.is_available ? 'Live in Shop' : 'Hidden' }}
                </span>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEditModal(item)"
                    class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-slate-100 rounded-lg transition"
                    title="Customize Details"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button
                    @click="removeProduct(item.id)"
                    class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition"
                    title="Remove from My Shop"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="listings.length === 0">
              <td colspan="7" class="py-12 text-center text-slate-500">
                <p class="font-semibold text-slate-700">No products listed in your shop yet.</p>
                <p class="text-xs text-slate-400 mt-1">Browse the Shared Catalog to add products with your own custom prices!</p>
                <router-link to="/vendor/catalog" class="inline-block mt-3 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-sm">
                  Browse Shared Catalog &rarr;
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-xl p-6 shadow-2xl space-y-5 text-slate-800">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
          <div>
            <h3 class="text-base font-bold text-slate-900">Customize Shop Listing</h3>
            <p class="text-xs text-slate-500">Catalog Default: ${{ parseFloat(editingItem?.product?.default_price || 0).toFixed(2) }}</p>
          </div>
          <button @click="showModal = false" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <form @submit.prevent="saveCustomizations" class="space-y-4 text-xs">
          <!-- Price & Stock -->
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
                :placeholder="'Catalog default: $' + parseFloat(editingItem?.product?.default_price || 0).toFixed(2)"
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

          <!-- Custom Title -->
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Product Title (Optional)
            </label>
            <input
              v-model="form.custom_title"
              type="text"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              :placeholder="editingItem?.product?.title"
            />
            <span class="text-[10px] text-slate-400 mt-1 block">Customize how this product title displays in your shop.</span>
          </div>

          <!-- Custom Description -->
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Product Description (Optional)
            </label>
            <textarea
              v-model="form.custom_description"
              rows="3"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              :placeholder="editingItem?.product?.description"
            ></textarea>
            <span class="text-[10px] text-slate-400 mt-1 block">Add shop-exclusive guarantees, warranty, or bundle details.</span>
          </div>

          <!-- Custom Thumbnail -->
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1">
              Custom Thumbnail Image URL (Optional)
            </label>
            <input
              v-model="form.custom_thumbnail"
              type="text"
              class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              placeholder="https://images.unsplash.com/..."
            />
            <span class="text-[10px] text-slate-400 mt-1 block">Provide your own custom product photo for your storefront.</span>
          </div>

          <!-- Visibility -->
          <div>
            <label class="flex items-center gap-2 cursor-pointer pt-2">
              <input v-model="form.is_available" type="checkbox" class="rounded text-emerald-600 focus:ring-emerald-500"/>
              <span class="text-xs font-semibold text-slate-700">Make visible to customers on my shop storefront</span>
            </label>
          </div>

          <!-- Buttons -->
          <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200">
            <button @click="showModal = false" type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">
              Cancel
            </button>
            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition">
              Save Customizations
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

const listings = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const editingItem = ref(null);

const form = ref({
    custom_price: '',
    custom_title: '',
    custom_description: '',
    custom_thumbnail: '',
    stock: 50,
    is_available: true,
});

const loadListings = async () => {
    try {
        const res = await api.get('/vendor/my-products', { params: { search: searchQuery.value } });
        listings.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.value = {
        custom_price: item.custom_price !== null ? item.custom_price : '',
        custom_title: item.custom_title || '',
        custom_description: item.custom_description || '',
        custom_thumbnail: item.custom_thumbnail || '',
        stock: item.stock,
        is_available: !!item.is_available,
    };
    showModal.value = true;
};

const saveCustomizations = async () => {
    try {
        await api.put(`/vendor/my-products/${editingItem.value.id}`, {
            ...form.value,
            custom_price: form.value.custom_price !== '' ? form.value.custom_price : null,
        });
        showModal.value = false;
        loadListings();
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to update product details.');
    }
};

const removeProduct = async (id) => {
    if (!confirm('Remove this product from your shop listing? (It will remain in the shared catalog)')) return;
    try {
        await api.delete(`/vendor/my-products/${id}`);
        loadListings();
    } catch (err) {
        alert('Failed to remove product from shop.');
    }
};

onMounted(() => {
    loadListings();
});
</script>


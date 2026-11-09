<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Shared Product Catalog</h1>
        <p class="text-sm text-slate-400 mt-1">Master catalog products available for all shop owners to list in their shops.</p>
      </div>

      <button
        @click="openModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Add Catalog Product</span>
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl flex items-center justify-between gap-4">
      <div class="relative flex-1 max-w-md">
        <input
          v-model="searchQuery"
          @input="loadProducts"
          type="text"
          placeholder="Search catalog by title, SKU, or category..."
          class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <span class="text-xs text-slate-400 font-medium">Total: {{ products.length }} items</span>
    </div>

    <!-- Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-950 text-slate-400 uppercase font-semibold border-b border-slate-800 tracking-wider">
            <tr>
              <th class="py-3.5 px-4">Product</th>
              <th class="py-3.5 px-4">SKU & Category</th>
              <th class="py-3.5 px-4">Catalog Default Price</th>
              <th class="py-3.5 px-4">Created By</th>
              <th class="py-3.5 px-4 text-center">Listed In Shops</th>
              <th class="py-3.5 px-4 text-center">Status</th>
              <th class="py-3.5 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr v-for="product in products" :key="product.id" class="hover:bg-slate-800/40 transition">
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <img
                    :src="product.default_thumbnail || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'"
                    class="w-12 h-12 rounded-xl object-cover bg-slate-800 border border-slate-700 shrink-0"
                    alt="thumb"
                  />
                  <div>
                    <div class="font-bold text-white text-sm">{{ product.title }}</div>
                    <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ product.description || 'No description' }}</div>
                  </div>
                </div>
              </td>

              <td class="py-3.5 px-4">
                <div class="font-mono text-slate-300">{{ product.sku || 'N/A' }}</div>
                <div class="text-[11px] text-slate-400">{{ product.category || 'General' }}</div>
              </td>

              <td class="py-3.5 px-4 font-bold text-white text-sm">
                ${{ parseFloat(product.default_price).toFixed(2) }}
              </td>

              <td class="py-3.5 px-4">
                <span v-if="product.creator?.role === 'admin'" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                  <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                  Admin
                </span>
                <span v-else class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                  {{ product.creator?.name || 'Shop Owner' }}
                </span>
              </td>

              <td class="py-3.5 px-4 text-center">
                <span
                  class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold"
                  :class="product.shop_products_count > 0 ? 'bg-slate-800 text-slate-200 border border-slate-700' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'"
                >
                  {{ product.shop_products_count }} {{ product.shop_products_count === 1 ? 'shop' : 'shops' }}
                </span>
              </td>

              <td class="py-3.5 px-4 text-center">
                <span
                  class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold"
                  :class="product.status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'"
                >
                  {{ product.status }}
                </span>
              </td>

              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openModal(product)"
                    class="p-1.5 text-slate-400 hover:text-indigo-400 hover:bg-slate-800 rounded-lg transition"
                    title="Edit Product"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button
                    @click="deleteProduct(product.id)"
                    class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition"
                    title="Delete Product"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="products.length === 0">
              <td colspan="7" class="py-8 text-center text-slate-500">
                No catalog products found. Click "Add Catalog Product" to add one.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Create / Edit -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-xl p-6 shadow-2xl space-y-5 text-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
          <h3 class="text-base font-bold text-white">{{ isEditing ? 'Edit Catalog Product' : 'Add Catalog Product' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">&times;</button>
        </div>

        <form @submit.prevent="saveProduct" class="space-y-4 text-xs">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Product Title *</label>
            <input v-model="form.title" required type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Wireless Noise-Cancelling Headphones"/>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">SKU</label>
              <input v-model="form.sku" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="CAT-SKU-001"/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Category</label>
              <input v-model="form.category" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Electronics, Apparel..."/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Default Price ($) *</label>
              <input v-model="form.default_price" required type="number" step="0.01" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="99.99"/>
            </div>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Description</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Product specifications, features..."></textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Default Thumbnail URL</label>
              <input v-model="form.default_thumbnail" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://..."/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Status</label>
              <select v-model="form.status" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="active">Active (Available in Catalog)</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
            <button @click="showModal = false" type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition">
              Cancel
            </button>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition">
              {{ isEditing ? 'Save Changes' : 'Add to Catalog' }}
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

const products = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = ref({
    title: '',
    sku: '',
    category: '',
    default_price: '',
    description: '',
    default_thumbnail: '',
    status: 'active',
});

const loadProducts = async () => {
    try {
        const res = await api.get('/admin/products', { params: { search: searchQuery.value } });
        products.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const openModal = (product = null) => {
    if (product) {
        isEditing.value = true;
        editingId.value = product.id;
        form.value = {
            title: product.title,
            sku: product.sku || '',
            category: product.category || '',
            default_price: product.default_price,
            description: product.description || '',
            default_thumbnail: product.default_thumbnail || '',
            status: product.status,
        };
    } else {
        isEditing.value = false;
        editingId.value = null;
        form.value = {
            title: '',
            sku: '',
            category: '',
            default_price: '',
            description: '',
            default_thumbnail: '',
            status: 'active',
        };
    }
    showModal.value = true;
};

const saveProduct = async () => {
    try {
        if (isEditing.value) {
            await api.put(`/admin/products/${editingId.value}`, form.value);
        } else {
            await api.post('/admin/products', form.value);
        }
        showModal.value = false;
        loadProducts();
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to save catalog product.');
    }
};

const deleteProduct = async (id) => {
    if (!confirm('Are you sure you want to remove this product from the shared catalog?')) return;
    try {
        await api.delete(`/admin/products/${id}`);
        loadProducts();
    } catch (err) {
        alert('Failed to delete product.');
    }
};

onMounted(() => {
    loadProducts();
});
</script>


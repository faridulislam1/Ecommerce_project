<template>
  <div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Create New Product</h1>
      <p class="text-sm text-slate-500 mt-1">
        This product will immediately appear in your shop listing and will also enter the <strong>Shared Catalog</strong> for other shop owners to browse!
      </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
      <form @submit.prevent="submitProduct" class="space-y-5 text-xs text-slate-700">
        <!-- Title -->
        <div>
          <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
            Product Title *
          </label>
          <input
            v-model="form.title"
            required
            type="text"
            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm"
            placeholder="e.g. Ergonomic Bluetooth Mouse"
          />
        </div>

        <!-- Category & SKU -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
              Category
            </label>
            <input
              v-model="form.category"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
              placeholder="Electronics, Fashion, Home..."
            />
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
              SKU (Stock Keeping Unit)
            </label>
            <input
              v-model="form.sku"
              type="text"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono"
              placeholder="Leave empty for auto-generated SKU"
            />
          </div>
        </div>

        <!-- Pricing Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
              Shared Catalog Default Price ($) *
            </label>
            <input
              v-model="form.default_price"
              required
              type="number"
              step="0.01"
              min="0"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-bold"
              placeholder="79.99"
            />
            <span class="text-[11px] text-slate-400 mt-1 block">Default suggested retail price for other shops.</span>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
              Initial Stock in My Shop
            </label>
            <input
              v-model="form.stock"
              type="number"
              min="0"
              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-bold"
              placeholder="50"
            />
            <span class="text-[11px] text-slate-400 mt-1 block">Available quantity in your store.</span>
          </div>
        </div>

        <!-- Description -->
        <div>
          <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
            Product Description
          </label>
          <textarea
            v-model="form.description"
            rows="4"
            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            placeholder="Highlight key specifications, dimensions, materials, and benefits..."
          ></textarea>
        </div>

        <!-- Thumbnail Image -->
        <div>
          <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
            Product Image / Thumbnail URL
          </label>
          <input
            v-model="form.default_thumbnail"
            type="text"
            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            placeholder="https://images.unsplash.com/..."
          />
          <span class="text-[11px] text-slate-400 mt-1 block">Enter a high resolution product image link.</span>
        </div>

        <!-- Image Preview if entered -->
        <div v-if="form.default_thumbnail" class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center gap-4">
          <img :src="form.default_thumbnail" class="w-16 h-16 rounded-lg object-cover border border-slate-300" alt="Preview"/>
          <span class="text-xs text-slate-500">Image preview confirmed</span>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
          <router-link
            to="/vendor/my-products"
            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition"
          >
            Cancel
          </router-link>
          <button
            type="submit"
            :disabled="isSubmitting"
            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-md shadow-emerald-600/20 transition disabled:opacity-50"
          >
            <span v-if="isSubmitting">Publishing...</span>
            <span v-else>Publish to Catalog & My Shop</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../api';

const router = useRouter();
const isSubmitting = ref(false);

const form = ref({
    title: '',
    category: '',
    sku: '',
    default_price: '',
    stock: 50,
    description: '',
    default_thumbnail: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80',
});

const submitProduct = async () => {
    isSubmitting.value = true;
    try {
        await api.post('/vendor/create-product', form.value);
        router.push('/vendor/my-products');
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to create product.');
    } finally {
        isSubmitting.value = false;
    }
};
</script>


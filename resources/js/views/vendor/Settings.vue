<template>
  <div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Shop Settings</h1>
      <p class="text-sm text-slate-500 mt-1">Configure your storefront branding, description, and contact info.</p>
    </div>

    <!-- Feedback alert -->
    <div v-if="successMsg" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
      {{ successMsg }}
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
      <form @submit.prevent="saveSettings" class="space-y-5 text-xs text-slate-700">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Shop Name *</label>
            <input v-model="form.name" required type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Slug URL *</label>
            <input v-model="form.slug" required type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono"/>
          </div>
        </div>

        <div>
          <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">About Shop / Description</label>
          <textarea v-model="form.description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Logo URL</label>
            <input v-model="form.logo" type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="https://..."/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Banner Image URL</label>
            <input v-model="form.banner" type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="https://..."/>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Contact Phone</label>
            <input v-model="form.phone" type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="+1 555 0199"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Physical Address / City</label>
            <input v-model="form.address" type="text" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Street, City, Country"/>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
          <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-md shadow-emerald-600/20 transition">
            Save Shop Settings
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const successMsg = ref('');
const form = ref({
    name: '',
    slug: '',
    description: '',
    logo: '',
    banner: '',
    phone: '',
    address: '',
});

const loadSettings = async () => {
    try {
        const res = await api.get('/vendor/shop');
        const shop = res.data.shop;
        if (shop) {
            form.value = {
                name: shop.name,
                slug: shop.slug,
                description: shop.description || '',
                logo: shop.logo || '',
                banner: shop.banner || '',
                phone: shop.phone || '',
                address: shop.address || '',
            };
        }
    } catch (err) {
        console.error(err);
    }
};

const saveSettings = async () => {
    successMsg.value = '';
    try {
        await api.put('/vendor/shop', form.value);
        successMsg.value = 'Shop profile updated successfully!';
        setTimeout(() => successMsg.value = '', 4000);
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to update shop.');
    }
};

onMounted(() => {
    loadSettings();
});
</script>


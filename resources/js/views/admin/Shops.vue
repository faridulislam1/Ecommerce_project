<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Shop Management</h1>
        <p class="text-sm text-slate-400 mt-1">Create, update, monitor, and assign shop owners to shops.</p>
      </div>

      <button
        @click="openModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Create New Shop</span>
      </button>
    </div>

    <!-- Search Bar -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl flex items-center justify-between gap-4">
      <div class="relative flex-1 max-w-md">
        <input
          v-model="searchQuery"
          @input="loadShops"
          type="text"
          placeholder="Search shops by name, slug, or phone..."
          class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <span class="text-xs text-slate-400 font-medium">Total: {{ shops.length }} shops</span>
    </div>

    <!-- Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-950 text-slate-400 uppercase font-semibold border-b border-slate-800 tracking-wider">
            <tr>
              <th class="py-3.5 px-4">Shop</th>
              <th class="py-3.5 px-4">Slug / Link</th>
              <th class="py-3.5 px-4">Assigned Owner</th>
              <th class="py-3.5 px-4 text-center">Listed Products</th>
              <th class="py-3.5 px-4 text-center">Status</th>
              <th class="py-3.5 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr v-for="shop in shops" :key="shop.id" class="hover:bg-slate-800/40 transition">
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <img
                    :src="shop.logo || 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=100'"
                    class="w-10 h-10 rounded-xl object-cover bg-slate-800 border border-slate-700 shrink-0"
                    alt="logo"
                  />
                  <div>
                    <div class="font-bold text-white text-sm">{{ shop.name }}</div>
                    <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ shop.description || 'No description' }}</div>
                  </div>
                </div>
              </td>

              <td class="py-3.5 px-4 font-mono text-slate-400">
                <router-link :to="'/shop/' + shop.slug" target="_blank" class="text-indigo-400 hover:underline flex items-center gap-1">
                  <span>/shop/{{ shop.slug }}</span>
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                  </svg>
                </router-link>
              </td>

              <td class="py-3.5 px-4">
                <span v-if="shop.owner" class="text-slate-200 font-medium">
                  {{ shop.owner.name }} <span class="text-slate-400">({{ shop.owner.email }})</span>
                </span>
                <span v-else class="text-amber-400 text-[11px] font-semibold bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-500/20">
                  Unassigned
                </span>
              </td>

              <td class="py-3.5 px-4 text-center">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700">
                  {{ shop.shop_products_count || 0 }} items
                </span>
              </td>

              <td class="py-3.5 px-4 text-center">
                <span
                  class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold"
                  :class="shop.status === 'active' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'"
                >
                  {{ shop.status }}
                </span>
              </td>

              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openModal(shop)"
                    class="p-1.5 text-slate-400 hover:text-indigo-400 hover:bg-slate-800 rounded-lg transition"
                    title="Edit Shop"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button
                    @click="deleteShop(shop.id)"
                    class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition"
                    title="Delete Shop"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="shops.length === 0">
              <td colspan="6" class="py-8 text-center text-slate-500">
                No shops found. Click "Create New Shop" to get started.
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
          <h3 class="text-base font-bold text-white">{{ isEditing ? 'Edit Shop' : 'Create New Shop' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">&times;</button>
        </div>

        <form @submit.prevent="saveShop" class="space-y-4 text-xs">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Shop Name *</label>
              <input v-model="form.name" required type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Apex Electronics"/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Slug URL</label>
              <input v-model="form.slug" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="auto-generated if empty"/>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Assign Shop Owner</label>
              <select v-model="form.user_id" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option :value="null">-- No Owner (Unassigned) --</option>
                <option v-for="owner in owners" :key="owner.id" :value="owner.id">
                  {{ owner.name }} ({{ owner.email }})
                </option>
              </select>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Status</label>
              <select v-model="form.status" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Description</label>
            <textarea v-model="form.description" rows="2" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Shop intro and specialties..."></textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Logo URL</label>
              <input v-model="form.logo" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://..."/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Banner URL</label>
              <input v-model="form.banner" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://..."/>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Phone</label>
              <input v-model="form.phone" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+1 555 0100"/>
            </div>

            <div>
              <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Address</label>
              <input v-model="form.address" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="City, State"/>
            </div>
          </div>

          <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
            <button @click="showModal = false" type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition">
              Cancel
            </button>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition">
              {{ isEditing ? 'Save Changes' : 'Create Shop' }}
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

const shops = ref([]);
const owners = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = ref({
    name: '',
    slug: '',
    user_id: null,
    description: '',
    logo: '',
    banner: '',
    phone: '',
    address: '',
    status: 'active',
});

const loadShops = async () => {
    try {
        const res = await api.get('/admin/shops', { params: { search: searchQuery.value } });
        shops.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const loadOwners = async () => {
    try {
        const res = await api.get('/admin/owners');
        owners.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const openModal = (shop = null) => {
    if (shop) {
        isEditing.value = true;
        editingId.value = shop.id;
        form.value = {
            name: shop.name,
            slug: shop.slug,
            user_id: shop.user_id,
            description: shop.description || '',
            logo: shop.logo || '',
            banner: shop.banner || '',
            phone: shop.phone || '',
            address: shop.address || '',
            status: shop.status,
        };
    } else {
        isEditing.value = false;
        editingId.value = null;
        form.value = {
            name: '',
            slug: '',
            user_id: null,
            description: '',
            logo: '',
            banner: '',
            phone: '',
            address: '',
            status: 'active',
        };
    }
    showModal.value = true;
};

const saveShop = async () => {
    try {
        if (isEditing.value) {
            await api.put(`/admin/shops/${editingId.value}`, form.value);
        } else {
            await api.post('/admin/shops', form.value);
        }
        showModal.value = false;
        loadShops();
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to save shop.');
    }
};

const deleteShop = async (id) => {
    if (!confirm('Are you sure you want to delete this shop?')) return;
    try {
        await api.delete(`/admin/shops/${id}`);
        loadShops();
    } catch (err) {
        alert('Failed to delete shop.');
    }
};

onMounted(() => {
    loadShops();
    loadOwners();
});
</script>


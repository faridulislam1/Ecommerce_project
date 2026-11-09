<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Shop Owner Accounts</h1>
        <p class="text-sm text-slate-400 mt-1">Create and manage merchant accounts and their assigned shops.</p>
      </div>

      <button
        @click="openModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        <span>Create Shop Owner</span>
      </button>
    </div>

    <!-- Search Bar -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl flex items-center justify-between gap-4">
      <div class="relative flex-1 max-w-md">
        <input
          v-model="searchQuery"
          @input="loadOwners"
          type="text"
          placeholder="Search by name, email, or phone..."
          class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </div>

      <span class="text-xs text-slate-400 font-medium">Total: {{ owners.length }} owners</span>
    </div>

    <!-- Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-950 text-slate-400 uppercase font-semibold border-b border-slate-800 tracking-wider">
            <tr>
              <th class="py-3.5 px-4">Owner Name</th>
              <th class="py-3.5 px-4">Email</th>
              <th class="py-3.5 px-4">Phone</th>
              <th class="py-3.5 px-4">Assigned Shop</th>
              <th class="py-3.5 px-4">Registered Date</th>
              <th class="py-3.5 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr v-for="owner in owners" :key="owner.id" class="hover:bg-slate-800/40 transition">
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ owner.name?.charAt(0) || 'O' }}
                  </div>
                  <div>
                    <span class="font-bold text-white text-sm">{{ owner.name }}</span>
                    <span class="block text-[10px] text-slate-400">ID #{{ owner.id }}</span>
                  </div>
                </div>
              </td>

              <td class="py-3.5 px-4 font-mono text-slate-300">
                {{ owner.email }}
              </td>

              <td class="py-3.5 px-4 text-slate-400">
                {{ owner.phone || 'N/A' }}
              </td>

              <td class="py-3.5 px-4">
                <span v-if="owner.shop" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                  <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                  {{ owner.shop.name }}
                </span>
                <span v-else class="text-amber-400 text-[11px] font-semibold bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-500/20">
                  None assigned
                </span>
              </td>

              <td class="py-3.5 px-4 text-slate-400">
                {{ new Date(owner.created_at).toLocaleDateString() }}
              </td>

              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openModal(owner)"
                    class="p-1.5 text-slate-400 hover:text-indigo-400 hover:bg-slate-800 rounded-lg transition"
                    title="Edit Owner"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button
                    @click="deleteOwner(owner.id)"
                    class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition"
                    title="Delete Account"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="owners.length === 0">
              <td colspan="6" class="py-8 text-center text-slate-500">
                No shop owners found. Click "Create Shop Owner" to add one.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Create / Edit -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
      <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md p-6 shadow-2xl space-y-5 text-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
          <h3 class="text-base font-bold text-white">{{ isEditing ? 'Edit Shop Owner' : 'Create Shop Owner' }}</h3>
          <button @click="showModal = false" class="text-slate-400 hover:text-white">&times;</button>
        </div>

        <form @submit.prevent="saveOwner" class="space-y-4 text-xs">
          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Full Name *</label>
            <input v-model="form.name" required type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Alex Morgan"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Email Address *</label>
            <input v-model="form.email" required type="email" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="alex@shop.com"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">
              {{ isEditing ? 'Password (Leave blank to keep unchanged)' : 'Password *' }}
            </label>
            <input v-model="form.password" :required="!isEditing" type="password" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Phone Number</label>
            <input v-model="form.phone" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+1 555 0199"/>
          </div>

          <div>
            <label class="block font-semibold uppercase tracking-wider text-slate-400 mb-1">Assign to Shop</label>
            <select v-model="form.shop_id" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option :value="null">-- No Shop Assigned --</option>
              <option v-for="shop in shops" :key="shop.id" :value="shop.id">
                {{ shop.name }}
              </option>
            </select>
          </div>

          <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
            <button @click="showModal = false" type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition">
              Cancel
            </button>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition">
              {{ isEditing ? 'Save Changes' : 'Create Owner' }}
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

const owners = ref([]);
const shops = ref([]);
const searchQuery = ref('');
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = ref({
    name: '',
    email: '',
    password: '',
    phone: '',
    shop_id: null,
});

const loadOwners = async () => {
    try {
        const res = await api.get('/admin/owners', { params: { search: searchQuery.value } });
        owners.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const loadShops = async () => {
    try {
        const res = await api.get('/admin/shops');
        shops.value = res.data;
    } catch (err) {
        console.error(err);
    }
};

const openModal = (owner = null) => {
    if (owner) {
        isEditing.value = true;
        editingId.value = owner.id;
        form.value = {
            name: owner.name,
            email: owner.email,
            password: '',
            phone: owner.phone || '',
            shop_id: owner.shop ? owner.shop.id : null,
        };
    } else {
        isEditing.value = false;
        editingId.value = null;
        form.value = {
            name: '',
            email: '',
            password: '',
            phone: '',
            shop_id: null,
        };
    }
    showModal.value = true;
};

const saveOwner = async () => {
    try {
        if (isEditing.value) {
            await api.put(`/admin/owners/${editingId.value}`, form.value);
        } else {
            await api.post('/admin/owners', form.value);
        }
        showModal.value = false;
        loadOwners();
    } catch (err) {
        alert(err.response?.data?.message || 'Failed to save shop owner.');
    }
};

const deleteOwner = async (id) => {
    if (!confirm('Are you sure you want to delete this shop owner?')) return;
    try {
        await api.delete(`/admin/owners/${id}`);
        loadOwners();
    } catch (err) {
        alert('Failed to delete owner.');
    }
};

onMounted(() => {
    loadOwners();
    loadShops();
});
</script>


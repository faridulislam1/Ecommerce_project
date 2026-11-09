<template>
  <div class="min-h-screen bg-slate-100 text-slate-800 flex flex-col md:flex-row antialiased">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-white border-r border-slate-200 flex flex-col shrink-0">
      <!-- Brand Logo / Title -->
      <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 font-black text-xl text-white">
            S
          </div>
          <div>
            <h1 class="text-base font-bold tracking-tight text-slate-900">Shop Manager</h1>
            <p class="text-xs text-slate-500 truncate max-w-[140px]">{{ user?.shop?.name || 'Owner Portal' }}</p>
          </div>
        </div>
      </div>

      <!-- Navigation links -->
      <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Shop Controls</div>

        <router-link
          to="/vendor"
          exact-active-class="bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition group"
        >
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Shop Overview
        </router-link>

        <router-link
          to="/vendor/my-products"
          active-class="bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition group"
        >
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          My Listed Products
        </router-link>

        <router-link
          to="/vendor/catalog"
          active-class="bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition group"
        >
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
          Shared Catalog
          <span class="ml-auto text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Shared</span>
        </router-link>

        <router-link
          to="/vendor/create-product"
          active-class="bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition group"
        >
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          Create New Product
        </router-link>

        <router-link
          to="/vendor/settings"
          active-class="bg-emerald-600 text-white font-semibold shadow-md shadow-emerald-600/20"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition group"
        >
          <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          Shop Settings
        </router-link>

        <div class="pt-6 px-3 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Quick Actions</div>

        <router-link
          v-if="user?.shop?.slug"
          :to="'/shop/' + user.shop.slug"
          class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
          View My Public Shop
        </router-link>
      </nav>

      <!-- User footer -->
      <div class="p-4 border-t border-slate-200 bg-slate-50">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm flex items-center justify-center shrink-0">
              {{ user?.name?.charAt(0) || 'S' }}
            </div>
            <div class="truncate">
              <p class="text-sm font-semibold text-slate-800 truncate">{{ user?.name }}</p>
              <p class="text-xs text-slate-500 truncate">{{ user?.email }}</p>
            </div>
          </div>
          <button
            @click="logout"
            title="Log out"
            class="p-2 text-slate-400 hover:text-red-500 hover:bg-slate-200 rounded-lg transition"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- Top Bar -->
      <header class="h-16 border-b border-slate-200 bg-white px-6 flex items-center justify-between sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-3">
          <span class="text-sm font-bold text-slate-800">
            {{ user?.shop?.name || 'My Shop' }}
          </span>
          <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full border border-slate-200">
            Role: Shop Owner
          </span>
        </div>

        <div class="flex items-center gap-4">
          <router-link
            to="/"
            class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-3.5 py-1.5 rounded-lg border border-slate-300 flex items-center gap-1.5 transition font-medium"
          >
            <span>All Shops</span>
          </router-link>

          <button
            @click="logout"
            class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 transition"
          >
            Log Out
          </button>
        </div>
      </header>

      <!-- Router View Slot -->
      <main class="flex-1 overflow-y-auto p-6 md:p-8">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useAuth } from '../auth';

const { user, logout } = useAuth();
</script>


<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col md:flex-row antialiased">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 border-r border-slate-800 flex flex-col shrink-0">
      <!-- Brand Logo / Title -->
      <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 font-black text-xl text-white">
            E
          </div>
          <div>
            <h1 class="text-base font-bold tracking-tight text-white flex items-center gap-2">
              Admin Portal
              <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-400 font-semibold border border-indigo-500/30">Dark</span>
            </h1>
            <p class="text-xs text-slate-400">System Management</p>
          </div>
        </div>
      </div>

      <!-- Navigation links -->
      <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Core Navigation</div>

        <router-link
          to="/admin"
          exact-active-class="bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800/80 hover:text-white transition group"
        >
          <svg class="w-5 h-5 shrink-0 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard Overview
        </router-link>

        <router-link
          to="/admin/shops"
          active-class="bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800/80 hover:text-white transition group"
        >
          <svg class="w-5 h-5 shrink-0 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
          Shop Management
        </router-link>

        <router-link
          to="/admin/products"
          active-class="bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800/80 hover:text-white transition group"
        >
          <svg class="w-5 h-5 shrink-0 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          Shared Product Catalog
        </router-link>

        <router-link
          to="/admin/owners"
          active-class="bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800/80 hover:text-white transition group"
        >
          <svg class="w-5 h-5 shrink-0 opacity-75 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
          </svg>
          Shop Owner Accounts
        </router-link>

        <div class="pt-6 px-3 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Quick Actions</div>

        <router-link
          to="/"
          class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 hover:bg-slate-800/80 hover:text-slate-200 transition"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
          Customer Storefront
        </router-link>
      </nav>

      <!-- User footer -->
      <div class="p-4 border-t border-slate-800 bg-slate-900/60">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-9 h-9 rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-sm shrink-0">
              A
            </div>
            <div class="truncate">
              <p class="text-sm font-medium text-white truncate">{{ user?.name || 'Administrator' }}</p>
              <p class="text-xs text-slate-400 truncate">{{ user?.email }}</p>
            </div>
          </div>
          <button
            @click="logout"
            title="Log out"
            class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-950">
      <!-- Top Bar -->
      <header class="h-16 border-b border-slate-800 bg-slate-900/40 px-6 flex items-center justify-between backdrop-blur-md sticky top-0 z-10">
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
            System Live
          </span>
          <span class="text-xs text-slate-400 hidden sm:inline">| Database: MySQL connected</span>
        </div>

        <div class="flex items-center gap-4">
          <router-link
            to="/"
            class="text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-1.5 rounded-lg border border-slate-700 flex items-center gap-1.5 transition"
          >
            <span>Live Store</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </router-link>

          <button
            @click="logout"
            class="text-xs text-rose-400 hover:text-rose-300 font-medium px-2 py-1 rounded transition"
          >
            Sign Out
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


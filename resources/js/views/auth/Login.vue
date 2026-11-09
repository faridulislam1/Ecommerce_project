<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-center relative overflow-hidden selection:bg-indigo-500 selection:text-white">
    <!-- Ambient Background Glows -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Container -->
    <div class="w-full max-w-5xl mx-auto p-4 sm:p-6 lg:p-8 relative z-10">
      <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800/80 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Side: Brand Showcase & Role Highlights -->
        <div class="lg:col-span-5 bg-gradient-to-br from-indigo-950/60 via-slate-900 to-slate-950 p-8 sm:p-10 border-b lg:border-b-0 lg:border-r border-slate-800 flex flex-col justify-between relative overflow-hidden">
          <div class="relative z-10 space-y-6">
            <!-- Brand Logo -->
            <router-link to="/" class="inline-flex items-center gap-3 group">
              <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition">
                M
              </div>
              <div>
                <span class="text-xl font-black text-white tracking-tight">Market<span class="text-indigo-400">Hub</span></span>
                <span class="text-[10px] block font-semibold text-slate-400 uppercase tracking-wider">Multi-Vendor Management</span>
              </div>
            </router-link>

            <!-- Value Proposition -->
            <div class="space-y-3 pt-4">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-500/15 text-indigo-300 border border-indigo-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Secure Access
              </span>
              <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight">
                Single Sign-On for Platform Management
              </h2>
              <p class="text-xs text-slate-400 leading-relaxed">
                Log in to access the Dark Admin Dashboard or your individual Shop Owner inventory portal with shared catalog synchronization.
              </p>
            </div>

            <!-- Feature Checklist -->
            <div class="space-y-2.5 pt-2 text-xs text-slate-300">
              <div class="flex items-center gap-2.5">
                <div class="w-5 h-5 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span>Dark-Themed Administrative Control</span>
              </div>

              <div class="flex items-center gap-2.5">
                <div class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span>Shop Owner Custom Pricing & Catalog Browsing</span>
              </div>

              <div class="flex items-center gap-2.5">
                <div class="w-5 h-5 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center shrink-0">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span>Strict Shop-Scoped Customer Isolation</span>
              </div>
            </div>
          </div>

          <!-- Bottom Link -->
          <div class="pt-8 relative z-10">
            <router-link to="/" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition group">
              <span class="group-hover:-translate-x-1 transition">&larr;</span>
              <span>Back to Public Storefront</span>
            </router-link>
          </div>
        </div>

        <!-- Right Side: Modern Login Form with Validation -->
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-between">
          <div class="space-y-6">
            <!-- Header -->
            <div class="space-y-1">
              <h3 class="text-xl font-bold text-white tracking-tight">Account Sign In</h3>
              <p class="text-xs text-slate-400">Enter your registered credentials or select a demo role below.</p>
            </div>

            <!-- Server Error Alert -->
            <div v-if="serverError" class="p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs flex items-start gap-3 animate-shake">
              <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
              </svg>
              <div class="flex-1 font-medium">{{ serverError }}</div>
            </div>

            <!-- Form -->
            <form @submit.prevent="handleSubmit" novalidate class="space-y-4 text-xs">
              <!-- Email Input with Validation -->
              <div class="space-y-1">
                <div class="flex items-center justify-between">
                  <label class="font-semibold uppercase tracking-wider text-slate-300 text-[11px]">
                    Email Address
                  </label>
                  <span v-if="errors.email" class="text-rose-400 text-[11px] font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ errors.email }}
                  </span>
                </div>

                <div class="relative">
                  <input
                    v-model="email"
                    @blur="validateEmail"
                    @input="errors.email = ''"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="admin@ecommerce.com"
                    :class="[
                      'w-full pl-10 pr-10 py-3 rounded-xl bg-slate-950 text-white placeholder-slate-500 text-xs focus:outline-none transition border',
                      errors.email
                        ? 'border-rose-500 ring-1 ring-rose-500'
                        : isEmailValid && email
                        ? 'border-emerald-500/80 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500'
                        : 'border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500'
                    ]"
                  />
                  <!-- Email Leading Icon -->
                  <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                  </svg>

                  <!-- Success Checkmark -->
                  <svg v-if="isEmailValid && email && !errors.email" class="w-4 h-4 text-emerald-400 absolute right-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </div>

              <!-- Password Input with Validation & Show/Hide -->
              <div class="space-y-1">
                <div class="flex items-center justify-between">
                  <label class="font-semibold uppercase tracking-wider text-slate-300 text-[11px]">
                    Password
                  </label>
                  <span v-if="errors.password" class="text-rose-400 text-[11px] font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ errors.password }}
                  </span>
                </div>

                <div class="relative">
                  <input
                    v-model="password"
                    @blur="validatePassword"
                    @input="errors.password = ''"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="Enter at least 6 characters"
                    :class="[
                      'w-full pl-10 pr-10 py-3 rounded-xl bg-slate-950 text-white placeholder-slate-500 text-xs focus:outline-none transition border',
                      errors.password
                        ? 'border-rose-500 ring-1 ring-rose-500'
                        : password.length >= 6
                        ? 'border-emerald-500/80 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500'
                        : 'border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500'
                    ]"
                  />
                  <!-- Lock Icon -->
                  <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>

                  <!-- Show/Hide Toggle Button -->
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3.5 top-3.5 text-slate-500 hover:text-slate-300 transition"
                    title="Toggle password visibility"
                  >
                    <!-- Eye Off -->
                    <svg v-if="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                    </svg>
                    <!-- Eye -->
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl font-bold text-xs text-white bg-indigo-600 hover:bg-indigo-500 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/30 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
              >
                <template v-if="isSubmitting">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Authenticating...</span>
                </template>
                <template v-else>
                  <span>Sign In to Dashboard &rarr;</span>
                </template>
              </button>
            </form>

            <!-- 1-Click Interactive Demo Accounts -->
            <div class="pt-5 border-t border-slate-800/80 space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                  ⚡ 1-Click Demo Quick Logins
                </span>
                <span class="text-[10px] text-slate-500">Auto-fills & logs in</span>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                <!-- Admin Demo -->
                <button
                  type="button"
                  @click="fillAndLogin('admin@ecommerce.com', 'password', 'Admin')"
                  class="p-2.5 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 text-left transition group"
                >
                  <div class="flex items-center gap-2 mb-1">
                    <span class="w-5 h-5 rounded-md bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-[10px]">A</span>
                    <span class="text-xs font-bold text-white group-hover:text-indigo-400 transition">Admin</span>
                  </div>
                  <span class="block text-[10px] text-slate-400 truncate">Dark Dashboard</span>
                </button>

                <!-- Shop Owner 1 Demo -->
                <button
                  type="button"
                  @click="fillAndLogin('john@shop.com', 'password', 'Owner 1')"
                  class="p-2.5 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 text-left transition group"
                >
                  <div class="flex items-center gap-2 mb-1">
                    <span class="w-5 h-5 rounded-md bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[10px]">S</span>
                    <span class="text-xs font-bold text-white group-hover:text-emerald-400 transition">ElectroTech</span>
                  </div>
                  <span class="block text-[10px] text-slate-400 truncate">Shop Owner</span>
                </button>

                <!-- Shop Owner 2 Demo -->
                <button
                  type="button"
                  @click="fillAndLogin('sarah@shop.com', 'password', 'Owner 2')"
                  class="p-2.5 rounded-xl bg-slate-950/70 hover:bg-slate-800 border border-slate-800 text-left transition group"
                >
                  <div class="flex items-center gap-2 mb-1">
                    <span class="w-5 h-5 rounded-md bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-[10px]">S</span>
                    <span class="text-xs font-bold text-white group-hover:text-amber-400 transition">Fashion Shop</span>
                  </div>
                  <span class="block text-[10px] text-slate-400 truncate">Shop Owner</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from '../../auth';

const router = useRouter();
const { login } = useAuth();

const email = ref('');
const password = ref('');
const showPassword = ref(false);
const isSubmitting = ref(false);
const serverError = ref('');

const errors = ref({
    email: '',
    password: '',
});

// Email Regex Validation
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isEmailValid = computed(() => emailRegex.test(email.value.trim()));

const validateEmail = () => {
    if (!email.value.trim()) {
        errors.value.email = 'Email address is required.';
        return false;
    }
    if (!emailRegex.test(email.value.trim())) {
        errors.value.email = 'Please enter a valid email format.';
        return false;
    }
    errors.value.email = '';
    return true;
};

const validatePassword = () => {
    if (!password.value) {
        errors.value.password = 'Password is required.';
        return false;
    }
    if (password.value.length < 6) {
        errors.value.password = 'Password must be at least 6 characters.';
        return false;
    }
    errors.value.password = '';
    return true;
};

const handleSubmit = async () => {
    serverError.value = '';

    const validEmail = validateEmail();
    const validPassword = validatePassword();

    if (!validEmail || !validPassword) {
        return;
    }

    isSubmitting.value = true;
    try {
        const res = await login(email.value.trim(), password.value);
        if (res.success) {
            if (res.user.role === 'admin') {
                router.push('/admin');
            } else {
                router.push('/vendor');
            }
        } else {
            serverError.value = res.error || 'Invalid credentials. Please verify your email and password.';
        }
    } catch (err) {
        serverError.value = 'A connection error occurred. Please try again.';
    } finally {
        isSubmitting.value = false;
    }
};

const fillAndLogin = async (e, p) => {
    email.value = e;
    password.value = p;
    errors.value.email = '';
    errors.value.password = '';
    await handleSubmit();
};
</script>

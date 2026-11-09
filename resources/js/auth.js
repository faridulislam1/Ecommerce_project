import { reactive, computed } from 'vue';
import api from './api';

const storedToken = localStorage.getItem('auth_token') || null;
let storedUser = null;
try {
    storedUser = JSON.parse(localStorage.getItem('auth_user') || 'null');
} catch (e) {
    storedUser = null;
}

const state = reactive({
    token: storedToken,
    user: storedUser,
    isLoading: false,
});

export const useAuth = () => {
    const isAuthenticated = computed(() => !!state.token);
    const isAdmin = computed(() => state.user?.role === 'admin');
    const isShopOwner = computed(() => state.user?.role === 'shop_owner');
    const user = computed(() => state.user);

    const login = async (email, password) => {
        state.isLoading = true;
        try {
            const res = await api.post('/login', { email, password });
            state.token = res.data.token;
            state.user = res.data.user;
            localStorage.setItem('auth_token', state.token);
            localStorage.setItem('auth_user', JSON.stringify(state.user));
            return { success: true, user: state.user };
        } catch (err) {
            const msg = err.response?.data?.message || 'Login failed. Please check credentials.';
            return { success: false, error: msg };
        } finally {
            state.isLoading = false;
        }
    };

    const logout = async () => {
        try {
            if (state.token) {
                await api.post('/logout');
            }
        } catch (e) {
            // ignore network error on logout
        } finally {
            state.token = null;
            state.user = null;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            window.location.href = '/login';
        }
    };

    const fetchMe = async () => {
        if (!state.token) return null;
        try {
            const res = await api.get('/me');
            state.user = res.data.user;
            localStorage.setItem('auth_user', JSON.stringify(state.user));
            return state.user;
        } catch (err) {
            state.token = null;
            state.user = null;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            return null;
        }
    };

    return {
        state,
        user,
        isAuthenticated,
        isAdmin,
        isShopOwner,
        login,
        logout,
        fetchMe,
    };
};


import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { authService } from '../services/auth.service';
import { authStorage } from '../storage/auth.storage';
import type { LoginRequest } from '../types/auth.types';
import type { User } from '../types/user.types';

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref<User | null>(null);
  const isLoading = ref(false);
  const isInitialized = ref(false);

  // Getters
  const isAuthenticated = computed(() => user.value !== null);

  const userName = computed(() => user.value?.name || '');

  // Actions
  async function login(credentials: LoginRequest): Promise<void> {
    try {
      isLoading.value = true;
      const response = await authService.login(credentials);
      user.value = response.user;
    } catch (error) {
      throw error;
    } finally {
      isLoading.value = false;
    }
  }

  async function logout(): Promise<void> {
    try {
      isLoading.value = true;
      await authService.logout();
    } catch (error) {
      console.error('Error during logout:', error);
    } finally {
      user.value = null;
      isLoading.value = false;
    }
  }

  async function refreshToken(): Promise<void> {
    try {
      await authService.refreshToken();
    } catch (error) {
      // If refresh fails, clear auth state
      user.value = null;
      throw error;
    }
  }

  async function checkAuth(): Promise<void> {
    try {
      isLoading.value = true;
      const token = await authService.getStoredToken();

      if (token) {
        // Try to get current user
        try {
          const currentUser = await authService.getCurrentUser();
          user.value = currentUser;
        } catch (error) {
          // Token might be invalid, try to refresh
          try {
            await refreshToken();
            const currentUser = await authService.getCurrentUser();
            user.value = currentUser;
          } catch (refreshError) {
            // Refresh failed, clear everything
            await authService.clearStorage();
            user.value = null;
          }
        }
      }
    } catch (error) {
      console.error('Error checking auth:', error);
      user.value = null;
    } finally {
      isLoading.value = false;
      isInitialized.value = true;
    }
  }

  function setUser(userData: User | null): void {
    user.value = userData;
  }

  return {
    // State
    user,
    isLoading,
    isInitialized,
    // Getters
    isAuthenticated,
    userName,
    // Actions
    login,
    logout,
    refreshToken,
    checkAuth,
    setUser,
  };
});


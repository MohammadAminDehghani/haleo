import { Router } from 'vue-router';
import { useAuthStore } from '../stores/auth.store';

export function setupAuthGuard(router: Router): void {
  router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // Initialize auth if not already done
    if (!authStore.isInitialized) {
      await authStore.checkAuth();
    }

    // Check if route requires authentication
    const requiresAuth = to.matched.some((record) => record.meta.requiresAuth !== false);
    const isLoginPage = to.name === 'login';

    if (requiresAuth && !authStore.isAuthenticated) {
      // Redirect to login if not authenticated
      next({ name: 'login', query: { redirect: to.fullPath } });
    } else if (isLoginPage && authStore.isAuthenticated) {
      // Redirect to home if already authenticated
      next('/');
    } else {
      next();
    }
  });
}


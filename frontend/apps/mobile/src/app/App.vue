<script setup lang="ts">
import { RouterLink, RouterView, useRoute } from 'vue-router';
import { computed, onMounted } from 'vue';
import { useAuthStore } from '../stores/auth.store';

const route = useRoute();
const authStore = useAuthStore();

const pageTitle = computed(() => {
  const routeName = route.name as string;
  if (!routeName) return 'Home';
  return routeName.charAt(0).toUpperCase() + routeName.slice(1);
});

onMounted(async () => {
  // Initialize auth state on app mount
  if (!authStore.isInitialized) {
    await authStore.checkAuth();
  }
});
</script>

<template>
  <div class="app-layout">
    <header class="app-header">
      <h1>{{ pageTitle }}</h1>
    </header>

    <main class="app-main">
      <RouterView />
    </main>

    <footer class="app-footer">
      <nav class="footer-menu">
        <RouterLink to="/todo" class="menu-item">
          <span class="menu-label">Todo</span>
        </RouterLink>
        <RouterLink to="/articles" class="menu-item">
          <span class="menu-label">Articles</span>
        </RouterLink>
        <RouterLink to="/" class="menu-item">
          <span class="menu-label">Home</span>
        </RouterLink>
        <RouterLink to="/activities" class="menu-item">
          <span class="menu-label">Activities</span>
        </RouterLink>
        <RouterLink to="/profile" class="menu-item">
          <span class="menu-label">User</span>
        </RouterLink>
      </nav>
    </footer>
  </div>
</template>

<style scoped lang="css">
.app-layout {
  display: flex;
  flex-direction: column;
  height: 100vh;
  max-width: 100vw;
}

.app-header {
  background-color: #f0f0f0;
  padding: 1rem;
  text-align: center;
  border-bottom: 1px solid #ddd;
  flex-shrink: 0;
}

.app-header h1 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
}

.app-main {
  flex: 1;
  overflow-y: auto;
  padding: 0;
}

.app-footer {
  background-color: #f0f0f0;
  border-top: 1px solid #ddd;
  flex-shrink: 0;
}

.footer-menu {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 0.75rem 0;
}

.menu-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-decoration: none;
  color: #666;
  padding: 0.5rem 1rem;
  transition: color 0.2s;
  flex: 1;
}

.menu-item:hover {
  color: #333;
}

.menu-item.router-link-active {
  color: #007bff;
  font-weight: 600;
}

.menu-label {
  font-size: 0.875rem;
  text-align: center;
}
</style>

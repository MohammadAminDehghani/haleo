<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth.store';
import LoadingSpinner from '../components/LoadingSpinner.vue';

const router = useRouter();
const authStore = useAuthStore();

const handleLogout = async () => {
  try {
    await authStore.logout();
    router.push('/login');
  } catch (error) {
    console.error('Error during logout:', error);
  }
};
</script>

<template>
  <div class="user-view">
    <h1>User</h1>

    <LoadingSpinner v-if="authStore.isLoading" message="Loading profile..." />
    <div v-else-if="!authStore.user" class="error">No user data available</div>
    <div v-else class="user-profile">
      <div class="profile-item">
        <label>Name:</label>
        <p>{{ authStore.user.name }}</p>
      </div>
      <div class="profile-item">
        <label>Email:</label>
        <p>{{ authStore.user.email }}</p>
      </div>
      <div class="profile-item">
        <label>Member since:</label>
        <p>{{ new Date(authStore.user.created_at).toLocaleDateString() }}</p>
      </div>
      <button @click="handleLogout" class="logout-button">Logout</button>
    </div>
  </div>
</template>

<style scoped>
.user-view {
  padding: 1rem;
}

.error {
  text-align: center;
  padding: 2rem;
}

.error {
  color: #dc3545;
}

.user-profile {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.profile-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
}

.profile-item label {
  display: block;
  font-size: 0.875rem;
  color: #666;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.profile-item p {
  margin: 0;
  font-size: 1rem;
  color: #333;
}

.logout-button {
  margin-top: 1rem;
  padding: 0.75rem 1.5rem;
  background-color: #dc3545;
  color: white;
  border: none;
  border-radius: 0.25rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
  width: 100%;
}

.logout-button:hover {
  background-color: #c82333;
}
</style>


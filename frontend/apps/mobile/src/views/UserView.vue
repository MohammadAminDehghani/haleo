<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { userService } from '../services/user.service';
import type { User } from '../types/user.types';

const user = ref<User | null>(null);
const loading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;
    user.value = await userService.getProfile(1);

  } catch (err) {
    error.value = 'Failed to load user profile';
    console.error('Error loading user profile:', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="user-view">
    <h1>User</h1>

    <div v-if="loading" class="loading">Loading profile...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="user" class="user-profile">
      <div class="profile-item">
        <label>Name:</label>
        <p>{{ user.name }}</p>
      </div>
      <div class="profile-item">
        <label>Email:</label>
        <p>{{ user.email }}</p>
      </div>
      <div class="profile-item">
        <label>Member since:</label>
        <p>{{ new Date(user.created_at).toLocaleDateString() }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.user-view {
  padding: 1rem;
}

.loading,
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
</style>


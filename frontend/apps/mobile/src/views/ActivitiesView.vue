<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { activityService } from '../services/activity.service';
import type { Activity } from '../types/activity.types';

const activities = ref<Activity[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;
    activities.value = await activityService.getAll();
  } catch (err) {
    error.value = 'Failed to load activities';
    console.error('Error loading activities:', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="activities-view">
    <h1>Activities</h1>

    <div v-if="loading" class="loading">Loading activities...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="activities.length === 0" class="empty">No activities found</div>
    <div v-else class="activities-list">
      <div v-for="activity in activities" :key="activity.id" class="activity-item">
        <div class="activity-header">
          <h3>{{ activity.name }}</h3>
          <span class="activity-type">{{ activity.type }}</span>
        </div>
        <p v-if="activity.description">{{ activity.description }}</p>
        <small>{{ new Date(activity.created_at).toLocaleDateString() }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>
.activities-view {
  padding: 1rem;
}

.loading,
.error,
.empty {
  text-align: center;
  padding: 2rem;
}

.error {
  color: #dc3545;
}

.activities-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.activity-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
  border-left: 4px solid #17a2b8;
}

.activity-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.activity-header h3 {
  margin: 0;
  font-size: 1.25rem;
  color: #333;
}

.activity-type {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  background-color: #17a2b8;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
}

.activity-item p {
  margin: 0.5rem 0;
  color: #666;
  line-height: 1.5;
}

.activity-item small {
  color: #999;
  font-size: 0.875rem;
}
</style>


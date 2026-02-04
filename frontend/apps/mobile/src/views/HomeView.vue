<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { articleService } from '../services/article.service';
import { todoService } from '../services/todo.service';
import { activityService } from '../services/activity.service';
import LoadingSpinner from '../components/LoadingSpinner.vue';
import type { Article } from '../types/article.types';
import type { Todo } from '../types/todo.types';
import type { Activity } from '../types/activity.types';

const articles = ref<Article[]>([]);
const todos = ref<Todo[]>([]);
const activities = ref<Activity[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;

    const [articlesData, todosData, activitiesData] = await Promise.all([
      articleService.getAll().catch(() => []),
      todoService.getAll().catch(() => []),
      activityService.getAll().catch(() => []),
    ]);

    articles.value = articlesData;
    todos.value = todosData;
    activities.value = activitiesData;
  } catch (err) {
    error.value = 'Failed to load data';
    console.error('Error loading home data:', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="home-view">
    <h1>Home</h1>

    <LoadingSpinner v-if="loading" message="Loading..." />
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="content">
      <div class="stats">
        <div class="stat-item">
          <h3>Articles</h3>
          <p>{{ articles.length }}</p>
        </div>
        <div class="stat-item">
          <h3>Todos</h3>
          <p>{{ todos.length }}</p>
        </div>
        <div class="stat-item">
          <h3>Activities</h3>
          <p>{{ activities.length }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.home-view {
  padding: 1rem;
}

.error {
  text-align: center;
  padding: 2rem;
}

.error {
  color: #dc3545;
}

.stats {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.stat-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
}

.stat-item h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1rem;
  color: #666;
}

.stat-item p {
  margin: 0;
  font-size: 2rem;
  font-weight: bold;
  color: #333;
}
</style>


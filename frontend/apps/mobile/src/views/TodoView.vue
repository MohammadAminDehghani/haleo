<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { todoService } from '../services/todo.service';
import LoadingSpinner from '../components/LoadingSpinner.vue';
import type { Todo } from '../types/todo.types';

const todos = ref<Todo[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;
    todos.value = await todoService.getAll();
  } catch (err) {
    error.value = 'Failed to load todos';
    console.error('Error loading todos:', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="todo-view">
    <h1>Todo</h1>

    <LoadingSpinner v-if="loading" message="Loading todos..." />
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="todos.length === 0" class="empty">No todos found</div>
    <div v-else class="todos-list">
      <div v-for="todo in todos" :key="todo.id" class="todo-item" :class="{ completed: todo.completed }">
        <div class="todo-header">
          <h3>{{ todo.title }}</h3>
          <span class="status" :class="{ 'status-completed': todo.completed }">
            {{ todo.completed ? '✓ Done' : '○ Pending' }}
          </span>
        </div>
        <p v-if="todo.description">{{ todo.description }}</p>
        <small>{{ new Date(todo.created_at).toLocaleDateString() }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>
.todo-view {
  padding: 1rem;
}

.error,
.empty {
  text-align: center;
  padding: 2rem;
}

.error {
  color: #dc3545;
}

.todos-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.todo-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
  border-left: 4px solid #ffc107;
}

.todo-item.completed {
  opacity: 0.7;
  border-left-color: #28a745;
}

.todo-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.todo-header h3 {
  margin: 0;
  font-size: 1.25rem;
  color: #333;
}

.status {
  font-size: 0.875rem;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  background-color: #fff3cd;
  color: #856404;
}

.status-completed {
  background-color: #d4edda;
  color: #155724;
}

.todo-item p {
  margin: 0.5rem 0;
  color: #666;
  line-height: 1.5;
}

.todo-item small {
  color: #999;
  font-size: 0.875rem;
}
</style>


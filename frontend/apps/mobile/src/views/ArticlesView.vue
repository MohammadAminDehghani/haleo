<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { articleService } from '../services/article.service';
import LoadingSpinner from '../components/LoadingSpinner.vue';
import type { Article } from '../types/article.types';

const articles = ref<Article[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;
    articles.value = await articleService.getAll();
  } catch (err) {
    error.value = 'Failed to load articles';
    console.error('Error loading articles:', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="articles-view">
    <h1>Articles</h1>

    <LoadingSpinner v-if="loading" message="Loading articles..." />
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="articles.length === 0" class="empty">No articles found</div>
    <div v-else class="articles-list">
      <div v-for="article in articles" :key="article.id" class="article-item">
        <h3>{{ article.title }}</h3>
        <p>{{ article.content }}</p>
        <small>{{ new Date(article.created_at).toLocaleDateString() }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>
.articles-view {
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

.articles-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.article-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
  border-left: 4px solid #007bff;
}

.article-item h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.25rem;
  color: #333;
}

.article-item p {
  margin: 0.5rem 0;
  color: #666;
  line-height: 1.5;
}

.article-item small {
  color: #999;
  font-size: 0.875rem;
}
</style>


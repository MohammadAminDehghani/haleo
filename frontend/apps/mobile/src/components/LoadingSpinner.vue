<script setup lang="ts">
interface Props {
  message?: string;
  size?: 'small' | 'medium' | 'large';
}

withDefaults(defineProps<Props>(), {
  message: 'Loading...',
  size: 'medium',
});
</script>

<template>
  <div class="loading-container" :class="`size-${size}`">
    <div class="spinner">
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
    </div>
    <p v-if="message" class="loading-message">{{ message }}</p>
  </div>
</template>

<style scoped>
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3rem 2rem;
  min-height: 200px;
}

.size-small {
  padding: 1.5rem 1rem;
  min-height: 100px;
}

.size-medium {
  padding: 3rem 2rem;
  min-height: 200px;
}

.size-large {
  padding: 4rem 2rem;
  min-height: 300px;
}

.spinner {
  position: relative;
  width: 60px;
  height: 60px;
}

.size-small .spinner {
  width: 40px;
  height: 40px;
}

.size-large .spinner {
  width: 80px;
  height: 80px;
}

.spinner-ring {
  position: absolute;
  width: 100%;
  height: 100%;
  border: 4px solid transparent;
  border-top-color: #007bff;
  border-radius: 50%;
  animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.spinner-ring:nth-child(1) {
  animation-delay: -0.45s;
  border-top-color: #007bff;
}

.spinner-ring:nth-child(2) {
  animation-delay: -0.3s;
  border-top-color: #17a2b8;
  width: 80%;
  height: 80%;
  top: 10%;
  left: 10%;
}

.spinner-ring:nth-child(3) {
  animation-delay: -0.15s;
  border-top-color: #28a745;
  width: 60%;
  height: 60%;
  top: 20%;
  left: 20%;
}

.spinner-ring:nth-child(4) {
  border-top-color: #ffc107;
  width: 40%;
  height: 40%;
  top: 30%;
  left: 30%;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.loading-message {
  margin-top: 1.5rem;
  color: #666;
  font-size: 0.95rem;
  font-weight: 500;
  animation: pulse 1.5s ease-in-out infinite;
}

.size-small .loading-message {
  margin-top: 1rem;
  font-size: 0.85rem;
}

.size-large .loading-message {
  margin-top: 2rem;
  font-size: 1.1rem;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>


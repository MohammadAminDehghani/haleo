<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth.store';
import LoadingSpinner from '../components/LoadingSpinner.vue';

const router = useRouter();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const error = ref<string | null>(null);
const isSubmitting = ref(false);

const handleSubmit = async () => {
  if (!email.value || !password.value) {
    error.value = 'Please fill in all fields';
    return;
  }

  try {
    isSubmitting.value = true;
    error.value = null;

    await authStore.login({
      email: email.value,
      password: password.value,
    });

    // Redirect to home on success
    router.push('/');
  } catch (err: unknown) {
    if (err instanceof Error) {
      error.value = err.message || 'Login failed. Please check your credentials.';
    } else {
      error.value = 'Login failed. Please check your credentials.';
    }
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <div class="login-view">
    <div class="login-container">
      <h1>Login</h1>

      <form @submit.prevent="handleSubmit" class="login-form">
        <div v-if="error" class="error-message">{{ error }}</div>

        <div class="form-group">
          <label for="email">Email</label>
          <input
            id="email"
            v-model="email"
            type="email"
            placeholder="Enter your email"
            required
            :disabled="isSubmitting"
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password"
            v-model="password"
            type="password"
            placeholder="Enter your password"
            required
            :disabled="isSubmitting"
          />
        </div>

        <button type="submit" class="submit-button" :disabled="isSubmitting">
          <LoadingSpinner v-if="isSubmitting" message="" size="small" />
          <span v-else>Login</span>
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-view {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 1rem;
  background-color: #f5f5f5;
}

.login-container {
  background: white;
  padding: 2rem;
  border-radius: 0.5rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.login-container h1 {
  margin: 0 0 1.5rem 0;
  text-align: center;
  color: #333;
  font-size: 1.75rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.error-message {
  background-color: #fee;
  color: #c33;
  padding: 0.75rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  text-align: center;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-group label {
  font-weight: 600;
  color: #333;
  font-size: 0.875rem;
}

.form-group input {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 0.25rem;
  font-size: 1rem;
  transition: border-color 0.2s;
}

.form-group input:focus {
  outline: none;
  border-color: #007bff;
}

.form-group input:disabled {
  background-color: #f5f5f5;
  cursor: not-allowed;
}

.submit-button {
  padding: 0.75rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 0.25rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
}

.submit-button:hover:not(:disabled) {
  background-color: #0056b3;
}

.submit-button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}
</style>


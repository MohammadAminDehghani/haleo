import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import TodoView from '../views/TodoView.vue';
import ArticlesView from '../views/ArticlesView.vue';
import ActivitiesView from '../views/ActivitiesView.vue';
import UserView from '../views/UserView.vue';
import LoginView from '../views/LoginView.vue';
import { setupAuthGuard } from './auth.guard';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { requiresAuth: false },
    },
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { requiresAuth: true },
    },
    {
      path: '/todo',
      name: 'todo',
      component: TodoView,
      meta: { requiresAuth: true },
    },
    {
      path: '/articles',
      name: 'articles',
      component: ArticlesView,
      meta: { requiresAuth: true },
    },
    {
      path: '/activities',
      name: 'activities',
      component: ActivitiesView,
      meta: { requiresAuth: true },
    },
    {
      path: '/profile',
      name: 'profile',
      component: UserView,
      meta: { requiresAuth: true },
    },
  ],
});

setupAuthGuard(router);

export default router;

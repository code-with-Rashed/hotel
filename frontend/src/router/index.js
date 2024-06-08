import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin',
      name: 'login',
      component: () => import('../views/admin/LoginView.vue'),
      meta: { title: 'Login' }
    },
    {
      path: '/admin/dashboard',
      name: 'dashboard',
      component: () => import('../views/admin/DashboardView.vue'),
      meta: { title: 'Dashboard' }
    }
  ]
})

export default router

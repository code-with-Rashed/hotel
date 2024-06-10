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
    },
    {
      path: '/admin/rooms',
      name: 'rooms',
      component: () => import('../views/admin/RoomsView.vue'),
      meta: { title: 'Rooms' }
    },
    {
      path: '/admin/room/features',
      name: 'features',
      component: () => import('../views/admin/FeaturesView.vue'),
      meta: { title: 'Room Features' }
    },
    {
      path: '/admin/room/ratings/reviews',
      name: 'ratings-reviews',
      component: () => import('../views/admin/RatingsReviewsView.vue'),
      meta: { title: 'Ratings & Reviews' }
    },
    {
      path: '/admin/room/facilities',
      name: 'facilities',
      component: () => import('../views/admin/FacilitiesView.vue'),
      meta: { title: 'Room Facilities' }
    },
    {
      path: '/admin/contact-us',
      name: 'contact-us',
      component: () => import('../views/admin/ContactUsView.vue'),
      meta: { title: 'Contact Us' }
    }
  ]
})

export default router

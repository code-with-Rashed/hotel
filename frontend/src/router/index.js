import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin',
      meta: { isAdminPanelRoutes: true },
      children: [
        {
          path: '',
          name: 'login',
          meta: { title: 'Admin Login Page' },
          component: () => import('../views/admin/LoginView.vue')
        },
        {
          path: 'dashboard',
          name: 'dashboard',
          component: () => import('../views/admin/DashboardView.vue'),
          meta: { title: 'Dashboard' }
        },
        {
          path: 'rooms',
          name: 'rooms',
          component: () => import('../views/admin/RoomsView.vue'),
          meta: { title: 'Rooms' }
        },
        {
          path: 'new/bookings',
          name: 'new-bookings',
          component: () => import('../views/admin/NewBookings.vue'),
          meta: { title: 'New Bookings' }
        },
        {
          path: 'refund/bookings',
          name: 'refund-bookings',
          component: () => import('../views/admin/RefundBookings.vue'),
          meta: { title: 'Refund Bookings' }
        },

        {
          path: 'all/bookings',
          name: 'all-bookings',
          component: () => import('../views/admin/AllBookings.vue'),
          meta: { title: 'All Bookings' }
        },
        {
          path: 'room/features',
          name: 'features',
          component: () => import('../views/admin/FeaturesView.vue'),
          meta: { title: 'Room Features' }
        },
        {
          path: 'room/ratings/reviews',
          name: 'ratings-reviews',
          component: () => import('../views/admin/RatingsReviewsView.vue'),
          meta: { title: 'Ratings & Reviews' }
        },
        {
          path: 'user-records',
          name: 'user-records',
          component: () => import('../views/admin/UsersView.vue'),
          meta: { title: 'User Records' }
        },
        {
          path: 'room/facilities',
          name: 'facilities',
          component: () => import('../views/admin/FacilitiesView.vue'),
          meta: { title: 'Room Facilities' }
        },
        {
          path: 'contact-us',
          name: 'contact-us',
          component: () => import('../views/admin/ContactUsView.vue'),
          meta: { title: 'Contact Us' }
        },
        {
          path: 'carousel/management',
          name: 'carousel',
          component: () => import('../views/admin/CarouselView.vue'),
          meta: { title: 'Carousel Management' }
        },
        {
          path: 'settings',
          name: 'settings',
          component: () => import('../views/admin/SettingsView.vue'),
          meta: { title: 'Settings Management' }
        },
        {
          path: 'team-profile',
          name: 'team',
          component: () => import('../views/admin/TeamView.vue'),
          meta: { title: 'Team Profile Management' }
        },
        {
          path: 'address',
          name: 'address',
          component: () => import('../views/admin/AddressView.vue'),
          meta: { title: 'Address Management' }
        },
        {
          path: 'profile',
          name: 'profile',
          component: () => import('../views/admin/ProfileView.vue'),
          meta: { title: 'Profile Management' }
        }
      ]
    },
    {
      path: '/',
      name: 'home-page',
      component: () => import('../views/visitior/HomeView.vue'),
      meta: { title: 'Home' }
    },
    {
      path: '/rooms',
      name: 'rooms-page',
      component: () => import('../views/visitior/RoomsView.vue'),
      meta: { title: 'Rooms' }
    },
    {
      path: '/room/:id(\\d+)',
      name: 'room-details',
      component: () => import('../views/visitior/RoomDetailsView.vue'),
      meta: { title: 'Room Details' }
    },
    {
      path: '/confirm/booking/room/:id(\\d+)',
      name: 'confirm-booking',
      component: () => import('../views/visitior/ConfirmBookingView.vue'),
      meta: { title: 'Confirm Booking Room', isConfirmBookingRoomRoutes: true }
    },
    {
      path: '/facilities',
      name: 'facilities-page',
      component: () => import('../views/visitior/FacilitiesView.vue'),
      meta: { title: 'Facilities' }
    },
    {
      path: '/contact-us',
      name: 'contact-page',
      component: () => import('../views/visitior/ContactView.vue'),
      meta: { title: 'Contact Us' }
    },
    {
      path: '/about',
      name: 'about-page',
      component: () => import('../views/visitior/AboutView.vue'),
      meta: { title: 'About Us' }
    },
    {
      path: '/booking/status',
      name: 'booking-status',
      component: () => import('../views/visitior/BookingStatus.vue'),
      meta: { title: 'Booking Status', isBookingStatusPage: true }
    },
    {
      path: '/user',
      meta: { isUserPanelRoutes: true },
      children: [
        {
          path: 'profile',
          name: 'user-profile-page',
          component: () => import('../views/users/ProfileView.vue'),
          meta: { title: 'My Profile' }
        },
        {
          path: 'my-bookings',
          name: 'user-bookings-page',
          component: () => import('../views/users/MyBookingsView.vue'),
          meta: { title: 'My Bookings History' }
        }
      ]
    }
  ]
})

export default router

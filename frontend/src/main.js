import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './App.vue'
import router from './router'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const app = createApp(App)
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
app.use(pinia)
app.use(router)
app.mount('#app')

router.beforeEach((to) => {
  document.title = to.meta.title

  // routes protection for admin panel
  if (to.meta.isAdminPanelRoutes) {
    const { isAdminAuthenticate } = useAdminCredentialsStore()
    if (!isAdminAuthenticate && to.name != 'login') {
      return { name: 'login' }
    } else if (isAdminAuthenticate && to.name == 'login') {
      return { name: 'dashboard' }
    }
  }

  const { isUserAuthenticate } = useUserCredentialsStore()
  // routes protection for user panel
  if (to.meta.isUserPanelRoutes) {
    if (!isUserAuthenticate) {
      return { name: 'home-page' }
    }
  }

  // routes protection for confirm booking page
  if (to.meta.isConfirmBookingRoomRoutes) {
    if (!isUserAuthenticate) {
      return { name: 'rooms-page' }
    }
  }

  // routes protection for booking status page
  if (to.meta.isBookingStatusPage) {
    if (!isUserAuthenticate) {
      return { name: 'home-page' }
    }
  }
})

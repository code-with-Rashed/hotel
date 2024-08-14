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

  // routes protection for user panel
  if (to.meta.isUserPanelRoutes) {
    const { isUserAuthenticate } = useUserCredentialsStore()
    if (!isUserAuthenticate) {
      return { name: 'home-page' }
    }
  }
})

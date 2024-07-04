import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAdminCredentialsStore = defineStore(
  'adminCredentials',
  () => {
    const isAdminAuthenticate = ref(false)
    const tokenType = ref(null)
    const adminAccessToken = ref(null)
    const admin = ref(null)
    function adminCredentials(data) {
      isAdminAuthenticate.value = true
      tokenType.value = data.token_type
      adminAccessToken.value = data.admin_access_token
      admin.value = data.admin
    }
    function destroyAdminCredentials() {
      isAdminAuthenticate.value = false
      tokenType.value = null
      adminAccessToken.value = null
      admin.value = null
    }
    return {
      isAdminAuthenticate,
      tokenType,
      adminAccessToken,
      admin,
      adminCredentials,
      destroyAdminCredentials
    }
  },
  { persist: true }
)

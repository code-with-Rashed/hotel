import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUserCredentialsStore = defineStore(
  'userCredentials',
  () => {
    const isUserAuthenticate = ref(false)
    const tokenType = ref(null)
    const userAccessToken = ref(null)
    const user = ref(null)
    function userCredentials(data) {
      isUserAuthenticate.value = true
      tokenType.value = data.token_type
      userAccessToken.value = data.user_access_token
      user.value = data.user
    }
    function destroyUserCredentials() {
      isUserAuthenticate.value = false
      tokenType.value = null
      userAccessToken.value = null
      user.value = null
    }
    return {
      isUserAuthenticate,
      tokenType,
      userAccessToken,
      user,
      userCredentials,
      destroyUserCredentials
    }
  },
  { persist: true }
)

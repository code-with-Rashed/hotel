import { ref } from 'vue'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const storeUserCredentials = useUserCredentialsStore()
const token = storeUserCredentials.tokenType + ' ' + storeUserCredentials.userAccessToken

export default function useProfileApi() {
  const url = import.meta.env.VITE_API_URL + '/api/user/profile'

  const results = ref([])
  const errors = ref(null)

  // update user profile record
  const updateProfile = async (userInfo, id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update/' + id, {
        method: 'PUT',
        body: JSON.stringify(userInfo),
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          Authorization: token
        }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }
  return { results, errors, updateProfile }
}

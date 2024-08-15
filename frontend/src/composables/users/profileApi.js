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

  // update user profile image
  const updateProfileImage = async (userPhoto, id) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('photo', userPhoto.value)
      const request = await fetch(url + '/update/photo/' + id, {
        method: 'POST',
        body: formData,
        headers: {
          Accept: 'application/json',
          Authorization: token,
          'X-HTTP-Method-Override': 'PUT'
        }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }
  return { results, errors, updateProfile, updateProfileImage }
}

import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useLogoApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/logo'

  const results = ref([])
  const errors = ref(null)

  // get logo record
  const get = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url, {
        method: 'GET',
        headers: {
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

  // update logo record
  const put = async (logo) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('logo', logo.value)
      const request = await fetch(url + '/update', {
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

  return { results, errors, get, put }
}

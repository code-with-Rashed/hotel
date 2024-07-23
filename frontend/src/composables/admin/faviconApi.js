import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useFaviconApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/favicon'

  const results = ref([])
  const errors = ref(null)

  // get favicon record
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

  // update favicon record
  const put = async (favicon) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('icon', favicon.value)
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

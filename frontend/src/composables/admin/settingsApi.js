import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useSettingsApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/setting'

  const results = ref([])
  const errors = ref(null)

  // get site settings record
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

  // send request the web application shutdown or running
  const shutdown = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/shutdown', {
        method: 'PUT',
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

  // update settings record
  const put = async (updateRecord) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update', {
        method: 'PUT',
        body: JSON.stringify(updateRecord),
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

  return { results, errors, get, shutdown, put }
}

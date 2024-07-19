import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useContactApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/contact'

  const results = ref([])
  const errors = ref(null)

  // fetch all contact request record
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

  // delete all contact messages
  const deleteAll = async () => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/delete/all/record', {
        method: 'DELETE',
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

  // update all contact message status
  const updateAllStatus = async () => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update/all/status', {
        method: 'PATCH',
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

  return { results, errors, get, deleteAll, updateAllStatus }
}

import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useRoomImageApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/room/image'

  const results = ref([])
  const errors = ref(null)

  // get room related images record
  const get = async (id) => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/' + id, {
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

  return { results, errors, get }
}

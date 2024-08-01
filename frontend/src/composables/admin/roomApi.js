import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useRoomApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/room'

  const results = ref([])
  const errors = ref(null)

  // get all hotel room record
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

  // post a new room record
  const post = async (newRoom) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/create', {
        method: 'POST',
        body: JSON.stringify(newRoom),
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

  // update room status
  const roomStatus = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/status/' + id, {
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

  // delete a room record
  const destroy = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/delete/' + id, {
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

  return { results, errors, get, post, roomStatus, destroy }
}

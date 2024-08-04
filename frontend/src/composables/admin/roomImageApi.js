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

  // post a room image
  const post = async (roomId, roomImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('room_id', roomId)
      formData.append('image', roomImage.value)
      const request = await fetch(url + '/create', {
        method: 'POST',
        body: formData,
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

  // update a room image
  const put = async (id, roomImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('image', roomImage.value)
      const request = await fetch(url + '/update/' + id, {
        method: 'POST',
        body: formData,
        headers: {
          Authorization: token,
          Accept: 'application/json',
          'X-HTTP-Method-Override': 'PUT'
        }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }

  // update room image thumbnail status
  const thumbnail = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/thumbnail/' + id, {
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

  // delete a room image
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

  return { results, errors, get, post, put, thumbnail, destroy }
}

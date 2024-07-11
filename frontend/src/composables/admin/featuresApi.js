import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useFeaturesApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/feature'

  const results = ref([])
  const errors = ref(null)

  // get all available room feature record
  const get = async () => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url, {
        method: 'GET',
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

  // post a new room feature record
  const post = async (newFeature) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/create', {
        method: 'POST',
        body: JSON.stringify(newFeature),
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

  // get a single feature record
  const show = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/show/' + id, {
        method: 'GET',
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
  // update a room feature record
  const put = async (id, updateFeature) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update/' + id, {
        method: 'PUT',
        body: JSON.stringify(updateFeature),
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

  // delete a room feature record
  const destroy = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/delete/' + id, {
        method: 'DELETE',
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
  return { results, errors, get, post, show, put, destroy }
}

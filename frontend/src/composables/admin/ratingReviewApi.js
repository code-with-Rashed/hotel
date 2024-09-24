import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useRatingReviewApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/room/ratings-reviews'

  const results = ref([])
  const errors = ref(null)

  // get all available rating & review records
  const get = async (pagenumber = null) => {
    results.value = []
    errors.value = null
    let finalurl = url
    if (pagenumber) {
      finalurl = finalurl + '?page=' + pagenumber
    }
    try {
      const request = await fetch(finalurl, {
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

  // update rating & review  status
  const put = async (id) => {
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

  // delete rating & review record
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
  return { results, errors, get, put, destroy }
}

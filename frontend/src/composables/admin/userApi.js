import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useUserApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/user'

  const results = ref([])
  const errors = ref(null)

  // get all user record
  const get = async (search = null, pagenumber = null) => {
    results.value = []
    errors.value = null
    let finalurl = url + '/data'
    if (search) {
      finalurl = finalurl + '/' + search
    }
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

  // get user details
  const userDetails = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/details/' + id, {
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

  // update user status
  const userStatus = async (userid) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/status/' + userid, {
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

  return { results, errors, get, userStatus, userDetails }
}

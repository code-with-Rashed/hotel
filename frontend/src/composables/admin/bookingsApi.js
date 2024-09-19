import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useBookingsApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin'

  const results = ref([])
  const errors = ref(null)

  // fetch all booking record
  const getAllBookings = async (search = null, pagenumber = null) => {
    results.value = []
    errors.value = null
    let finalurl = url + '/all/bookings'
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

  return { results, errors, getAllBookings }
}

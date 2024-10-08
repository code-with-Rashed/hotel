import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useDashboardApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/dashboard'

  const results = ref([])
  const errors = ref(null)

  // fetch achivement summary
  const getSummary = async () => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/summary', {
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

  // fetch booking analytics
  const getBookingAnalytics = async (period) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/booking-analytics/' + period, {
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

  // fetch users, queries, ratings & reviews related analytics
  const getAnalytics = async (period) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/analytics/' + period, {
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

  return { results, errors, getSummary, getBookingAnalytics, getAnalytics }
}

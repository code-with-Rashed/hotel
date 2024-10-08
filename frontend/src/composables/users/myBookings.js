import { ref } from 'vue'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const storeUserCredentials = useUserCredentialsStore()
const token = storeUserCredentials.tokenType + ' ' + storeUserCredentials.userAccessToken
const user_id = storeUserCredentials.user.id

export default function useMyBookingsApi() {
  const url = import.meta.env.VITE_API_URL + '/api'

  const results = ref([])
  const errors = ref(null)

  // fetch booking records for user
  const get = async () => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/my-booking-records/' + user_id, {
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

  // send request for cancel booking
  const put = async (order_id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/cancel-my-booking', {
        method: 'PUT',
        body: JSON.stringify({ user_id, order_id }),
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

  // send  Rating & Review
  const sendRatingReview = async (data) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/rating-review', {
        method: 'POST',
        body: JSON.stringify(data),
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

  return { results, errors, get, put, sendRatingReview }
}

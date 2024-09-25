import { ref } from 'vue'

export default function useRatingReviewApi() {
  const url = import.meta.env.VITE_API_URL + '/api/rating-review'

  const results = ref([])
  const errors = ref(null)

  // fetch all reting & review record for room
  const get = async (room_id) => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/' + room_id, {
        method: 'GET',
        headers: {
          Accept: 'application/json'
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

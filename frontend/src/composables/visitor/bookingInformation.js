import { ref } from 'vue'

export default function useBookingInformationApi() {
  const url = import.meta.env.VITE_API_URL + '/api'

  const results = ref([])
  const errors = ref(null)

  // fetch all room related record
  const checkBookingInfo = async (info) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/check/booking/information', {
        method: 'POST',
        body: JSON.stringify(info),
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json'
        }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }

  return { results, errors, checkBookingInfo }
}

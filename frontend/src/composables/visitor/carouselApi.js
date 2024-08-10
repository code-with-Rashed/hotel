import { ref } from 'vue'

export default function useCarouselApi() {
  const url = import.meta.env.VITE_API_URL + '/api/carousel'

  const results = ref([])
  const errors = ref(null)

  // fetch all carousel image record
  const get = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url, {
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

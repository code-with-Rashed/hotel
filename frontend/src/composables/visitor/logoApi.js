import { ref } from 'vue'

export default function useLogoApi() {
  const url = import.meta.env.VITE_API_URL + '/api/logo'

  const results = ref([])
  const errors = ref(null)

  // fetch logo record
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
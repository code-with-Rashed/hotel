import { ref } from 'vue'

export default function useContactApi() {
  const url = import.meta.env.VITE_API_URL + '/api/contact'

  const results = ref([])
  const errors = ref(null)

  // post a new contact request
  const post = async (newContact) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url, {
        method: 'POST',
        body: JSON.stringify(newContact),
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
  return { results, errors, post }
}

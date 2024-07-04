import { ref } from 'vue'
export default function useAdminProfileApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/profile'

  const results = ref([])
  const errors = ref(null)

  const login = async (loginData) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/login', {
        method: 'POST',
        body: JSON.stringify(loginData),
        headers: { 'Content-Type': 'application/json', Accept: 'application/json' }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }

  return { results, errors, login }
}

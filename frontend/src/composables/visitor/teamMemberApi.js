import { ref } from 'vue'

export default function useTeamMemberApi() {
  const url = import.meta.env.VITE_API_URL + '/api/team-members'

  const results = ref([])
  const errors = ref(null)

  // fetch all team member record
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
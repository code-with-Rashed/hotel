import { ref } from 'vue'

export default function useRoomApi() {
  const url = import.meta.env.VITE_API_URL + '/api'

  const results = ref([])
  const errors = ref(null)

  // fetch all room related record
  const allRoom = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/all/room', {
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

  return { results, errors, allRoom }
}
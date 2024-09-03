import { ref } from 'vue'

export default function useRoomApi() {
  const url = import.meta.env.VITE_API_URL + '/api'

  const results = ref([])
  const errors = ref(null)

  // fetch all room related record
  const allRoom = async (pagenumber = null) => {
    results.value = []
    errors.value = null
    let finalurl = url + '/all/room'
    if (pagenumber) {
      finalurl = finalurl + '?page=' + pagenumber
    }
    try {
      const request = await fetch(finalurl, {
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

  // fetch single room related record
  const room = async (id) => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/room/' + id, {
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

  // fetch confirm booking room related record for user
  const confirmRoom = async (id) => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url + '/confirm/room/' + id, {
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

  return { results, errors, allRoom, room, confirmRoom }
}

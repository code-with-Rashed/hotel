import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useFacilityApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/facility'

  const results = ref([])
  const errors = ref(null)

  // get all room facility record
  const get = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url, {
        method: 'GET',
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

  // post a facility record
  const post = async (facilityData, facilityImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('name', facilityData.name)
      formData.append('description', facilityData.description)
      formData.append('image', facilityImage.value)
      const request = await fetch(url + '/create', {
        method: 'POST',
        body: formData,
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
  return { results, errors, get, post }
}

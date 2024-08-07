import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useRoomFeatureFacilityApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/room/feature-facility'

  const results = ref([])
  const errors = ref(null)

  // get all assigned room feature record
  const getAssignedRoomFeatures = async (roomId) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/features-id/' + roomId, {
        method: 'GET',
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

  // get all assigned room facility record
  const getAssignedRoomFacility = async (roomId) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/facilities-id/' + roomId, {
        method: 'GET',
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

  // post room feature & facility ids
  const post = async (featureFacility) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/create', {
        method: 'POST',
        body: JSON.stringify(featureFacility),
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

  // update room feature & facility ids
  const put = async (featureFacility) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update', {
        method: 'PUT',
        body: JSON.stringify(featureFacility),
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

  return { results, errors, getAssignedRoomFeatures, getAssignedRoomFacility, post, put }
}

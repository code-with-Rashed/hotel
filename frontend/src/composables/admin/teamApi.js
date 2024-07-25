import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useTeamApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/team'

  const results = ref([])
  const errors = ref(null)

  // get all team profile record
  const get = async () => {
    results.value = []
    errors.value = null

    try {
      const request = await fetch(url, {
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

  // post a team member record
  const post = async (teamData, memberImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('name', teamData.name)
      formData.append('designation', teamData.designation)
      formData.append('photo', memberImage.value)
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

  // get a single team member record
  const show = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/show/' + id, {
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

  // update team member record
  const put = async (id, editTeamMemberRecord, memberImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('name', editTeamMemberRecord.name)
      formData.append('designation', editTeamMemberRecord.designation)
      if (memberImage.value) {
        formData.append('photo', memberImage.value)
      }
      const request = await fetch(url + '/update/' + id, {
        method: 'POST',
        body: formData,
        headers: {
          Accept: 'application/json',
          Authorization: token,
          'X-HTTP-Method-Override': 'PUT'
        }
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }

  // delete team member record
  const destroy = async (id) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/delete/' + id, {
        method: 'DELETE',
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
  return { results, errors, get, post, show, put, destroy }
}

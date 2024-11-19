import { ref } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken

export default function useAchievementApi() {
  const url = import.meta.env.VITE_API_URL + '/api/admin/achievement'

  const results = ref([])
  const errors = ref(null)

  // get all achievement record
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

  // post a achievement record
  const post = async (data, achievementImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('achievement', data.achievement)
      formData.append('photo', achievementImage.value)
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

  // get a single achievement record
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

  // update achivement record
  const put = async (id, editAchievementRecord, achievementImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('achievement', editAchievementRecord.achievement)
      if (achievementImage.value) {
        formData.append('photo', achievementImage.value)
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

  // delete achievement record
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

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

  const logout = async (token) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/logout', {
        method: 'DELETE',
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

  // fetch admin profile record
  const show = async (id, token) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/show/' + id, {
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

  // update profile record
  const update = async (id, token, updatedData, profilePhoto) => {
    results.value = []
    errors.value = null
    try {
      const formData = new FormData()
      if (profilePhoto.value) {
        formData.append('photo', profilePhoto.value)
      }
      formData.append('name', updatedData.name)
      formData.append('email', updatedData.email)
      const request = await fetch(url + '/update/' + id, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          Authorization: token
        },
        body: formData
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }

  // update password
  const updatePassword = async (id, token, password) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/update/password/' + id, {
        method: 'PUT',
        headers: {
          Authorization: token,
          Accept: 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(password)
      })
      const response = await request.json()
      results.value = response
    } catch (error) {
      errors.value = error
    }
  }
  return { results, errors, login, logout, show, update, updatePassword }
}

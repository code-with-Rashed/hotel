import { ref } from 'vue'

export default function useUserApi() {
  const url = import.meta.env.VITE_API_URL + '/api/user'

  const results = ref([])
  const errors = ref(null)

  // register a new user
  const post = async (userInfo, userImage) => {
    results.value = []
    errors.value = null

    try {
      const formData = new FormData()
      formData.append('name', userInfo.name)
      formData.append('email', userInfo.email)
      formData.append('number', userInfo.number)
      formData.append('pincode', userInfo.pincode)
      formData.append('dob', userInfo.dob)
      formData.append('address', userInfo.address)
      formData.append('password', userInfo.password)
      formData.append('password_confirmation', userInfo.password_confirmation)
      formData.append('photo', userImage.value)
      const request = await fetch(url + '/register', {
        method: 'POST',
        body: formData,
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

  // login user
  const login = async (loginInfo) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/login', {
        method: 'POST',
        body: JSON.stringify(loginInfo),
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

  return { results, errors, post, login }
}

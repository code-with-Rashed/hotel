import { ref } from 'vue'

export default function useAccountRecoveryApi() {
  const url = import.meta.env.VITE_API_URL + '/api/user'

  const results = ref([])
  const errors = ref(null)

  // start account recovery proccess after verify email
  const verifyEmail = async (email) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/reset-password', {
        method: 'POST',
        body: JSON.stringify({ email }),
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

  // verify otp after verify email
  const verifyOtp = async (email, otp) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/verify-otp', {
        method: 'POST',
        body: JSON.stringify({ email, otp }),
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

  // set new password after verify email & otp
  const newPassword = async (creadentials) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/new-password', {
        method: 'POST',
        body: JSON.stringify(creadentials),
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

  return { results, errors, verifyEmail, verifyOtp, newPassword }
}

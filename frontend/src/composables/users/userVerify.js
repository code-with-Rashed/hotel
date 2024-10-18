import { ref } from 'vue'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const storeUserCredentials = useUserCredentialsStore()
const token = storeUserCredentials.tokenType + ' ' + storeUserCredentials.userAccessToken

export default function useUserVerifyApi() {
  const url = import.meta.env.VITE_API_URL + '/api/user'

  const results = ref([])
  const errors = ref(null)

  // send request for verify user email
  const verifyEmail = async (email) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/send/email-verify-otp', {
        method: 'POST',
        body: JSON.stringify({ email }),
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

  // send request for email verify otp
  const verifyOtp = async (otpInfo) => {
    results.value = []
    errors.value = null
    try {
      const request = await fetch(url + '/send/valid-otp', {
        method: 'POST',
        body: JSON.stringify(otpInfo),
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

  return { results, errors, verifyEmail, verifyOtp }
}

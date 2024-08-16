<script setup>
import { reactive, ref, onMounted } from 'vue'
import useAdminProfileApi from '@/composables/admin/adminProfileApi'
import { useRouter } from 'vue-router'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'
import useLogoApi from '@/composables/visitor/logoApi'

const router = useRouter()
const { results: logoResults, get } = useLogoApi()
const { results, errors, login } = useAdminProfileApi()
const storeToastMessage = useToastMessageStore()
const storeAdminCredentials = useAdminCredentialsStore()

const submitBtn = ref(true)
const loginData = reactive({
  email: '',
  password: ''
})

const loginNow = async () => {
  submitBtn.value = false
  await login(loginData)
  submitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    storeAdminCredentials.adminCredentials(results.value.data)
    router.push({ name: 'dashboard' })
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}

// get logo
const logo = ref(null)
const showLogo = async () => {
  await get()
  logo.value = logoResults.value.data.logo.logo
}

onMounted(() => showLogo())
</script>
<template class="bg-light">
  <div class="w-50 m-auto shadow-sm p-4 bg-white mt-5 rounded">
    <img :src="logo" alt="logo" class="d-block m-auto mb-3 rounded-circle" height="100" />
    <p class="h5 text-center mb-4">Login Your Account</p>
    <form @submit.prevent="loginNow()">
      <div class="form-group mb-3">
        <label for="email" class="mb-2">Email</label>
        <input
          type="email"
          id="email"
          class="form-control"
          placeholder="Enter your email"
          maxlength="50"
          required
          autofocus
          v-model.trim="loginData.email"
        />
      </div>
      <div class="form-group mb-3">
        <label for="password" class="mb-2">Password</label>
        <input
          type="password"
          id="password"
          class="form-control"
          placeholder="Enter your password"
          maxlength="25"
          required
          v-model.trim="loginData.password"
        />
      </div>
      <button type="submit" class="btn btn-primary" v-if="submitBtn">Login</button>
      <button class="btn btn-primary" type="button" disabled v-else>
        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
        <span role="status"> Proccssing...</span>
      </button>
    </form>
  </div>
  <ToastMessage />
</template>

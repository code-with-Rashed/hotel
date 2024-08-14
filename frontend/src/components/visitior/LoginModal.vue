<script setup>
import AccountRecoveryModal from '@/components/visitior/AccountRecoveryModal.vue'
import { ref, reactive } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'
import useUserApi from '@/composables/users/userApi'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const { results, errors, login } = useUserApi()
const storeToastMessage = useToastMessageStore()
const storeUserCredentials = useUserCredentialsStore()

const loginInfo = reactive({
  email: '',
  password: ''
})

const loginBtn = ref(true)
const loginNow = async () => {
  loginBtn.value = false
  await login(loginInfo)
  loginBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    storeUserCredentials.userCredentials(results.value.data)
    hideBsModal('loginModal')
    // clear user login form data
    for (const key in loginInfo) {
      loginInfo[key] = ''
    }
  } else {
    // show validation error
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 15000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
</script>
<template>
  <!-- Login Modal start -->
  <div
    class="modal fade"
    id="loginModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="loginNow">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle fs-3 me-2"></i>User login
            </h5>
            <button
              type="reset"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input
                type="email"
                class="form-control shadow-none"
                maxlength="70"
                required
                v-model.trim="loginInfo.email"
              />
            </div>
            <div class="mb-4">
              <label class="form-label">Password</label>
              <input
                type="password"
                class="form-control shadow-none"
                maxlength="50"
                required
                v-model.trim="loginInfo.password"
              />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none" v-if="loginBtn">Login</button>
              <button class="btn btn-primary" type="button" disabled v-else>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status"> Proccssing...</span>
              </button>
              <button
                type="button"
                class="btn text-secondary text-decoration-none"
                data-bs-toggle="modal"
                data-bs-dismiss="modal"
                data-bs-target="#accountRecoveryModal"
              >
                Forgot Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Login Modal end -->
  <AccountRecoveryModal />
  <ToastMessage />
</template>

<script setup>
import { ref, reactive } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'
import useAccountRecoveryApi from '@/composables/visitor/accountRecoveryApi'

const { results, errors, verifyEmail, verifyOtp, newPassword } = useAccountRecoveryApi()
const storeToastMessage = useToastMessageStore()
const creadentials = reactive({
  email: '',
  otp: '',
  token: '',
  password: '',
  password_confirmation: ''
})

// start account recovery proccess after verify email
const emailVerifyBtn = ref(true)
const emailVerify = async () => {
  emailVerifyBtn.value = false
  await verifyEmail(creadentials.email)
  emailVerifyBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    document.getElementById('otpModalBtn').click()
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

// verify otp after verify email
const otpVerifyBtn = ref(true)
const otpVerify = async () => {
  otpVerifyBtn.value = false
  await verifyOtp(creadentials.email, creadentials.otp)
  otpVerifyBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    document.getElementById('newPasswordModalBtn').click()
    creadentials.token = creadentials.otp
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

// set new password after verify email & otp
const setNewPasswordBtn = ref(true)
const setNewPassword = async () => {
  setNewPasswordBtn.value = false
  await newPassword(creadentials)
  setNewPasswordBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('newPasswordModal')
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
  <!-- Account Recovery Modal start -->
  <div
    class="modal fade"
    id="accountRecoveryModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="emailVerify">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle fs-3 me-2"></i>Account Recovery
            </h5>
            <button
              type="reset"
              class="btn-close"
              aria-label="Close"
              data-bs-toggle="modal"
              data-bs-dismiss="modal"
              data-bs-target="#loginModal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Enter your registered email</label>
              <input
                type="email"
                name="email"
                class="form-control shadow-none"
                maxlength="70"
                required
                v-model="creadentials.email"
              />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none" v-if="emailVerifyBtn">
                SEND
              </button>
              <button class="btn btn-primary" type="button" disabled v-else>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status"> Proccssing...</span>
              </button>
            </div>
            <span
              class="invisible"
              data-bs-toggle="modal"
              data-bs-target="#otpModal"
              id="otpModalBtn"
            ></span>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Account Recovery Modal end -->

  <!-- verify otp modal start -->
  <div
    class="modal fade"
    id="otpModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="otpVerify">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-check-circle fs-3 me-2"></i>Verify Your OTP
            </h5>
            <button
              type="reset"
              class="btn-close"
              aria-label="Close"
              data-bs-toggle="modal"
              data-bs-dismiss="modal"
              data-bs-target="#otpModal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Enter OTP</label>
              <input
                type="text"
                class="form-control shadow-none"
                maxlength="10"
                required
                v-model="creadentials.otp"
              />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none" v-if="otpVerifyBtn">
                VERIFY
              </button>
              <button class="btn btn-primary" type="button" disabled v-else>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status"> Proccssing...</span>
              </button>
              <span
                class="invisible"
                data-bs-toggle="modal"
                data-bs-target="#newPasswordModal"
                id="newPasswordModalBtn"
              ></span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- verify otp modal end -->

  <!-- set new password modal start-->
  <div
    class="modal fade"
    id="newPasswordModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="setNewPassword">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-key fs-3 me-2"></i>Set Your New Password
            </h5>
            <button
              type="reset"
              class="btn-close"
              aria-label="Close"
              data-bs-toggle="modal"
              data-bs-dismiss="modal"
              data-bs-target="#newPasswordModal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input
                type="text"
                class="form-control shadow-none"
                maxlength="50"
                required
                v-model="creadentials.password"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input
                type="text"
                class="form-control shadow-none"
                maxlength="50"
                required
                v-model="creadentials.password_confirmation"
              />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none" v-if="setNewPasswordBtn">
                SAVE
              </button>
              <button class="btn btn-primary" type="button" disabled v-else>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status"> Proccssing...</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- set new password modal end -->
  <ToastMessage />
</template>

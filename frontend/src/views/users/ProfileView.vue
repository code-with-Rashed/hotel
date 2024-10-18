<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import { reactive, ref } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import useProfileApi from '@/composables/users/profileApi'
import useUserVerifyApi from '@/composables/users/userVerify'
import { hideBsModal } from '@/helpers/hideBsModal'

const storeUserCredentials = useUserCredentialsStore()
const { results, errors, updateProfile, updateProfileImage, updatePassword } = useProfileApi()
const {
  results: userVerifyResults,
  errors: userVerifyErrors,
  verifyEmail,
  verifyOtp
} = useUserVerifyApi()
const storeToastMessage = useToastMessageStore()

const userInfo = reactive({
  id: '',
  name: '',
  email: '',
  email_verified_at: '',
  number: '',
  pincode: '',
  address: '',
  dob: ''
})
for (const key in userInfo) {
  userInfo[key] = storeUserCredentials.user[key]
}

// update profile information
const updateProfileBtn = ref(true)
const profileUpdate = async () => {
  updateProfileBtn.value = false
  await updateProfile(userInfo, userInfo.id)
  updateProfileBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    for (const key in userInfo) {
      storeUserCredentials.user[key] = userInfo[key]
    }
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//--------------------------

// handle user profile photo
const userPhoto = ref()
const showUserPhoto = ref()
const selectUserPhoto = (event) => {
  userPhoto.value = event.target.files[0]
  showUserPhoto.value = URL.createObjectURL(userPhoto.value)
}
showUserPhoto.value = storeUserCredentials.user.photo
//------------------------

// update user profile image
const changeProfileImageBtn = ref(true)
const changeProfileImage = async () => {
  changeProfileImageBtn.value = false
  await updateProfileImage(userPhoto, userInfo.id)
  changeProfileImageBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    storeUserCredentials.user.photo = results.value.data.photo
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// -------------------

// update user password
const userPassword = reactive({
  old_password: '',
  password: '',
  password_confirmation: ''
})

const changePasswordBtn = ref(true)
const changePassword = async () => {
  changePasswordBtn.value = false
  await updatePassword(userPassword, userInfo.id)
  changePasswordBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    // clear user password form data
    for (const key in userPassword) {
      userPassword[key] = ''
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
//------------------------

// send request for verify user email
const verifyMyEmailBtn = ref(true)
const verifyMyEmail = async () => {
  verifyMyEmailBtn.value = false
  await verifyEmail(userInfo.email)
  verifyMyEmailBtn.value = true
  if (userVerifyResults.value.success) {
    storeToastMessage.showToastMessage(
      userVerifyResults.value.success,
      userVerifyResults.value.message
    )
    document.getElementById('otpModalBtn').click()
  } else {
    // show validation error
    let message = ''
    message += '<strong>' + userVerifyResults.value.message + '</strong><br>'
    if (userVerifyResults.value.message == 'validation error') {
      userVerifyResults.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(userVerifyResults.value.success, message, 15000)
  }
  if (userVerifyErrors.value) {
    storeToastMessage.showToastMessage(false, userVerifyErrors.value.message)
  }
}

// send request for email verify otp
const otpInfo = reactive({
  email: '',
  otp: ''
})
const verifyOtpBtn = ref(true)
const verifyMyOtp = async () => {
  verifyOtpBtn.value = false
  otpInfo.email = userInfo.email
  await verifyOtp(otpInfo)
  verifyOtpBtn.value = true
  if (userVerifyResults.value.success) {
    hideBsModal('otpModal')
    otpInfo.otp = ''
    storeToastMessage.showToastMessage(
      userVerifyResults.value.success,
      userVerifyResults.value.message
    )
    storeUserCredentials.user.email_verified_at = true
    userInfo.email_verified_at = true
  } else {
    // show validation error
    let message = ''
    message += '<strong>' + userVerifyResults.value.message + '</strong><br>'
    if (userVerifyResults.value.message == 'validation error') {
      userVerifyResults.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(userVerifyResults.value.success, message, 15000)
  }
  if (userVerifyErrors.value) {
    storeToastMessage.showToastMessage(false, userVerifyErrors.value.message)
  }
}
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row">
          <div class="col-12 mb-4 my-5 px-4">
            <h3 class="fw-bold">Profile Details</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <RouterLink :to="{ name: 'home-page' }">Home</RouterLink>
              </li>
              <li class="breadcrumb-item active" aria-current="page">My Profile</li>
            </ol>
          </div>
        </div>
        <!-- update profile -->
        <div class="row">
          <div class="col-md-12 px-3 mb-2">
            <div class="card border-primary shadow-sm p-3">
              <h5>Update Profile Details</h5>
              <form @submit.prevent="profileUpdate">
                <div class="row p-2">
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Name</label>
                    <input
                      type="name"
                      name="name"
                      class="form-control shadow-none"
                      maxlength="50"
                      required
                      v-model.trim="userInfo.name"
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label"
                      >Email
                      <template v-if="userInfo.email_verified_at">
                        <span class="badge bg-primary" title="This emeil is verified"
                          >verified</span
                        >
                      </template>
                      <template v-else>
                        <span class="badge bg-danger" title="This email is unverified"
                          >unverified</span
                        >
                        <span
                          class="invisible"
                          data-bs-toggle="modal"
                          data-bs-target="#otpModal"
                          id="otpModalBtn"
                        ></span>
                        <button
                          class="btn btn-sm btn-primary ms-2"
                          type="button"
                          @click="verifyMyEmail"
                          v-if="verifyMyEmailBtn"
                        >
                          verify my email
                        </button>
                        <button class="btn btn-sm btn-primary ms-2" type="button" disabled v-else>
                          <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                          <span role="status"> verify my email...</span>
                        </button>
                      </template>
                    </label>
                    <input
                      type="email"
                      class="form-control shadow-none"
                      maxlength="70"
                      required
                      v-model.trim="userInfo.email"
                      readonly
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Phone Number</label>
                    <input
                      type="number"
                      class="form-control shadow-none"
                      maxlength="15"
                      required
                      v-model.trim="userInfo.number"
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Pincode</label>
                    <input
                      type="text"
                      class="form-control shadow-none"
                      maxlength="20"
                      required
                      v-model.trim="userInfo.pincode"
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Date of Birth</label>
                    <input
                      type="date"
                      name="dob"
                      class="form-control shadow-none"
                      required
                      v-model.trim="userInfo.dob"
                    />
                  </div>
                  <div class="col-md-6 mb-3 p-0">
                    <label class="form-label">Address</label>
                    <textarea
                      class="form-control shadow-none"
                      name="address"
                      rows="1"
                      maxlength="255"
                      required
                      v-model.trim="userInfo.address"
                    ></textarea>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary text-white shadow-none"
                  v-if="updateProfileBtn"
                >
                  Save Changes
                </button>
                <button class="btn btn-primary" type="button" disabled v-else>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status"> Proccssing...</span>
                </button>
              </form>
            </div>
          </div>
        </div>
        <!-- update profile photo -->
        <div class="row">
          <div class="col-md-6 px-3 my-3">
            <div class="card border-info shadow-sm p-3">
              <h5>Update Profile Picture</h5>
              <form @submit.prevent="changeProfileImage">
                <div class="row p-2">
                  <img
                    :src="showUserPhoto"
                    alt="profile"
                    class="rounded-circle mx-auto"
                    style="width: 200px"
                  />
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">New Profile Picture</label>
                    <input
                      type="file"
                      name="profile"
                      accept="accept/*"
                      class="form-control shadow-none"
                      required
                      @change="selectUserPhoto"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary text-white shadow-none"
                  v-if="changeProfileImageBtn"
                >
                  Change Profile Image
                </button>
                <button class="btn btn-primary" type="button" disabled v-else>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status"> Proccssing...</span>
                </button>
              </form>
            </div>
          </div>
          <!-- update user password -->
          <div class="col-md-6 px-3 my-3">
            <div class="card border-danger shadow-sm p-3">
              <h5>Update Password</h5>
              <form @submit.prevent="changePassword">
                <div class="row p-2">
                  <div class="col-md-12 my-2 ps-0">
                    <label class="form-label">Old Password</label>
                    <input
                      type="password"
                      class="form-control shadow-none"
                      required
                      maxlength="50"
                      v-model.trim="userPassword.old_password"
                    />
                  </div>
                  <div class="col-md-12 mb-2 ps-0">
                    <label class="form-label">New Password</label>
                    <input
                      type="password"
                      class="form-control shadow-none"
                      required
                      maxlength="50"
                      v-model.trim="userPassword.password"
                    />
                  </div>
                  <div class="col-md-12 mb-3 ps-0">
                    <label class="form-label">Confirm Password</label>
                    <input
                      type="password"
                      class="form-control shadow-none"
                      required
                      maxlength="50"
                      v-model.trim="userPassword.password_confirmation"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary text-white shadow-none"
                  v-if="changePasswordBtn"
                >
                  Change Password
                </button>
                <button class="btn btn-primary" type="button" disabled v-else>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status"> Proccssing...</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- otp modal start -->
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
            <form @submit.prevent="verifyMyOtp">
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
                    v-model="otpInfo.otp"
                  />
                </div>
                <div class="mb-2 d-flex align-items-center justify-content-between">
                  <button type="submit" class="btn btn-dark shadow-none" v-if="verifyOtpBtn">
                    VERIFY
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
      <!-- otp modal end -->
    </template>
  </LayoutView>
  <ToastMessage />
</template>

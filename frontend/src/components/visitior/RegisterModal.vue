<script setup>
import { ref, reactive } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'
import useUserApi from '@/composables/users/userApi'

const { results, errors, post } = useUserApi()
const storeToastMessage = useToastMessageStore()

const userInfo = reactive({
  name: '',
  email: '',
  number: '',
  pincode: '',
  address: '',
  dob: '',
  password: '',
  password_confirmation: ''
})

// handle user profile photo
const userPhoto = ref()
const showUserPhoto = ref()
const selectUserPhoto = (event) => {
  userPhoto.value = event.target.files[0]
  showUserPhoto.value = URL.createObjectURL(userPhoto.value)
}
//------------------------

const registerBtn = ref(true)
const register = async () => {
  registerBtn.value = false
  await post(userInfo, userPhoto)
  registerBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('registerModal')
    // clear user form data
    for (const key in userInfo) {
      userInfo[key] = ''
    }
    userPhoto.value = null
    showUserPhoto.value = null
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
  <!-- Register Modal start -->
  <div
    class="modal fade"
    id="registerModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3">
        <form @submit.prevent="register">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-lines-fill fs-3 me-2"></i>User Registration
            </h5>
            <button
              type="reset"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note : Your details must match with your Id (Passport , Driving license , etc.) that
              will be required during check-in.
            </span>
            <div class="container-flued">
              <div class="row">
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Name</label>
                  <input
                    type="name"
                    class="form-control shadow-none"
                    maxlength="50"
                    required
                    v-model.trim="userInfo.name"
                  />
                </div>
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control shadow-none"
                    maxlength="70"
                    required
                    v-model.trim="userInfo.email"
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
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Pincode</label>
                  <input
                    type="text"
                    class="form-control shadow-none"
                    maxlength="20"
                    required
                    v-model.trim="userInfo.pincode"
                  />
                </div>
                <div class="col-md-12 mb-3 p-0">
                  <label class="form-label">Address</label>
                  <textarea
                    class="form-control shadow-none"
                    rows="1"
                    maxlength="248"
                    required
                    v-model.trim="userInfo.address"
                  ></textarea>
                </div>
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Date of Birth</label>
                  <input
                    type="date"
                    class="form-control shadow-none"
                    required
                    v-model.trim="userInfo.dob"
                  />
                </div>
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Profile Picture</label>
                  <input
                    type="file"
                    name="profile"
                    accept="image/*"
                    class="form-control shadow-none"
                    required
                    @change="selectUserPhoto"
                  />
                </div>
                <div class="mb-3 text-end" v-if="showUserPhoto">
                  <img :src="showUserPhoto" alt="preview image" class="rounded" height="100" />
                </div>
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control shadow-none"
                    required
                    maxlength="50"
                    v-model.trim="userInfo.password"
                  />
                </div>
                <div class="col-md-6 mb-4 p-0">
                  <label class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    class="form-control shadow-none"
                    required
                    maxlength="50"
                    v-model.trim="userInfo.password_confirmation"
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary" v-if="registerBtn">Register</button>
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
  <!-- Register Modal end -->
  <ToastMessage />
</template>

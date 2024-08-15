<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import { reactive, ref } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import useProfileApi from '@/composables/users/profileApi'

const storeUserCredentials = useUserCredentialsStore()
const { results, errors, updateProfile, updateProfileImage } = useProfileApi()
const storeToastMessage = useToastMessageStore()

const userInfo = reactive({
  id: '',
  name: '',
  email: '',
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
            <div class="card border-0 shadow-sm p-3">
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
        <div class="row mt-3">
          <div class="col-md-6 px-3 mb-2">
            <div class="card border-0 shadow-sm p-3">
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
          <div class="col-md-6 px-3 mb-2">
            <div class="card border-0 shadow-sm p-3">
              <h5>Update Password</h5>
              <form id="password-form">
                <div class="row p-2">
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">Password</label>
                    <input
                      type="password"
                      name="password"
                      class="form-control shadow-none"
                      required
                    />
                  </div>
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">Confirm Password</label>
                    <input
                      type="password"
                      name="confirm-password"
                      class="form-control shadow-none"
                      required
                    />
                  </div>
                </div>
                <button type="submit" class="btn custom-bg text-white shadow-none">
                  Change Password
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

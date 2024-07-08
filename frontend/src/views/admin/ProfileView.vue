<script setup>
import LayoutView from './layout/LayoutView.vue'
import useAdminProfileApi from '@/composables/admin/adminProfileApi'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import { onMounted, ref, reactive } from 'vue'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'

const storeAdminCredentials = useAdminCredentialsStore()
const adminProfileId = storeAdminCredentials.admin.id
const token = storeAdminCredentials.tokenType + ' ' + storeAdminCredentials.adminAccessToken
const { results, errors, show, update } = useAdminProfileApi()
const storeToastMessage = useToastMessageStore()
const profilePhoto = ref()
const newProfilePhoto = ref()
const updateProfileBtn = ref(true)

const showProfile = reactive({
  name: '',
  email: ''
})
const selectPhoto = (event) => {
  newProfilePhoto.value = event.target.files[0]
  profilePhoto.value = URL.createObjectURL(newProfilePhoto.value)
}
const updateProfileRecord = async () => {
  updateProfileBtn.value = false
  await update(adminProfileId, token, showProfile, newProfilePhoto)
  updateProfileBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
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

onMounted(async () => {
  await show(adminProfileId, token)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    profilePhoto.value = results.value.data.admin.photo
    showProfile.name = results.value.data.admin.name
    showProfile.email = results.value.data.admin.email
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
})
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Profile Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="row py-3">
              <!-- Profile Update Area Start -->
              <div class="col-md-6">
                <form class="shadow rounded p-4" @submit.prevent="updateProfileRecord">
                  <div class="mb-4">
                    <img :src="profilePhoto" alt="Profile-Photo" class="rounded-circle w-25" />
                  </div>
                  <div class="form-group mb-3">
                    <label for="photo" class="mb-1">Change Photo</label>
                    <input
                      type="file"
                      id="photo"
                      class="form-control"
                      accept="image/*"
                      @change="selectPhoto"
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="name" class="mb-1">Name</label>
                    <input
                      type="text"
                      id="name"
                      class="form-control"
                      maxlength="50"
                      required
                      v-model.trim="showProfile.name"
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="email" class="mb-1">Email</label>
                    <input
                      type="email"
                      id="email"
                      class="form-control"
                      maxlength="60"
                      required
                      v-model.trim="showProfile.email"
                    />
                  </div>
                  <button type="submit" class="btn btn-primary" v-if="updateProfileBtn">
                    Update
                  </button>
                  <button class="btn btn-primary" type="button" disabled v-else>
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status"> Proccssing...</span>
                  </button>
                </form>
              </div>
              <!-- Profile Update Area End -->
              <!-- Change Password Area Start -->
              <div class="col-md-6">
                <form class="shadow rounded p-4">
                  <p class="h5 fw-bold mb-3">Update Password</p>
                  <div class="form-group mb-3">
                    <label for="oldPassword" class="mb-1">Old Password</label>
                    <input
                      type="password"
                      id="oldPassword"
                      class="form-control"
                      placeholder="Enter old password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="newPassword" class="mb-1">New Password</label>
                    <input
                      type="password"
                      id="newPassword"
                      class="form-control"
                      placeholder="Enter new password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="confirmPassword" class="mb-1">Confirm Password</label>
                    <input
                      type="password"
                      id="confirmPassword"
                      class="form-control"
                      placeholder="Enter confirm password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
              </div>
              <!-- Change Password Area End -->
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

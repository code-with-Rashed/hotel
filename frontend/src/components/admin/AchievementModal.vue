<script setup>
import { ref, reactive, watch } from 'vue'
import useAchievementApi from '@/composables/admin/achievementApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  instruction: String,
  editAchievementId: Number,
  deleteAchievementId: Number
})

const { results, errors, post, show, put, destroy } = useAchievementApi()
const storeToastMessage = useToastMessageStore()

// handle achievement image
const achievementImage = ref()
const tempAchievementImage = ref()
const showAchievementImage = ref()
const selectAchievementImage = (event) => {
  achievementImage.value = event.target.files[0]
  tempAchievementImage.value = URL.createObjectURL(achievementImage.value)
  showAchievementImage.value = URL.createObjectURL(achievementImage.value)
}
//------------------------

// add new achievement record
const achievementData = reactive({
  achievement: ''
})
const addAchievementSubmitBtn = ref(true)
const postAchievementRecord = async () => {
  addAchievementSubmitBtn.value = false
  await post(achievementData, achievementImage)
  addAchievementSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('addAchievementModal')
    achievementData.achievement = ''
    achievementImage.value = null
    tempAchievementImage.value = null
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
//-------------------

// handle props instruction
watch(props, (propsValues) => {
  if (propsValues.instruction == 'show') {
    getAchievement(propsValues.editAchievementId)
  }
})
//----------------

// get single achievement record for editing
const getAchievement = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    showAchievementImage.value = results.value.data.achievement.photo
    editAchievementRecord.achievement = results.value.data.achievement.achievement
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// --------------------------------------

// update Achievement record
const editAchievementRecord = reactive({
  achievement: ''
})

const updateAchievementSubmitBtn = ref(true)
const updateAchievementRecord = async () => {
  updateAchievementSubmitBtn.value = false
  await put(props.editAchievementId, editAchievementRecord, achievementImage)
  updateAchievementSubmitBtn.value = true
  tempAchievementImage.value = null
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editAchievementModal')
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
// --------------------------

// delete Achievement record
const deleteAchievementSubmitBtn = ref(true)
const deleteAchievementRecord = async () => {
  deleteAchievementSubmitBtn.value = false
  await destroy(props.deleteAchievementId)
  deleteAchievementSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteAchievementModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
</script>
<template>
  <!-- Add new Achievement Modal start -->
  <div
    class="modal fade"
    id="addAchievementModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="postAchievementRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Achievement Record</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="name">achievement summary</label>
              <input
                type="text"
                id="name"
                class="form-control shadow-none"
                title="Enter a new Achievement Record"
                maxlength="50"
                required
                v-model.trim="achievementData.achievement"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="photo">Achievement Photo</label>
              <input
                type="file"
                id="photo"
                class="form-control shadow-none"
                title="Enter a new Achievement Picture"
                accept="image/*"
                required
                @change="selectAchievementImage"
              />
            </div>
            <div class="mb-3" v-if="tempAchievementImage">
              <img :src="tempAchievementImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="addAchievementSubmitBtn"
            >
              SUBMIT
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
  <!-- Add new Achievement Modal end -->

  <!-- Edit Achievement Modal start -->
  <div
    class="modal fade"
    id="editAchievementModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateAchievementRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Updet Achievement Record</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="name">Achievement Record</label>
              <input
                type="text"
                id="name"
                class="form-control shadow-none"
                title="Update Achievement record"
                maxlength="50"
                required
                v-model.trim="editAchievementRecord.achievement"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="photo"
                >Update Achievement Picture ( optional )</label
              >
              <input
                type="file"
                id="photo"
                class="form-control shadow-none"
                title="Chose Another Achievement Picture"
                accept="image/*"
                @change="selectAchievementImage"
              />
            </div>
            <div class="mb-3" v-if="showAchievementImage">
              <img :src="showAchievementImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateAchievementSubmitBtn"
            >
              UPDATE
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
  <!-- Edit Achievement Modal end -->

  <!-- delete Achievement modal start -->
  <div
    class="modal fade"
    id="deleteAchievementModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Achievement Record</h5>
          <button
            type="button"
            class="btn-close shadow-none"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <p class="fw-bold text-center text-danger">
              Are you sure ? you wan't to delete this record !
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            Cancel
          </button>
          <button
            type="button"
            class="btn btn-danger text-white shadow-none"
            @click="deleteAchievementRecord"
            v-if="deleteAchievementSubmitBtn"
          >
            DELETE
          </button>
          <button class="btn btn-primary" type="button" disabled v-else>
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status"> Proccssing...</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- delete Achievement modal end -->

  <ToastMessage />
</template>

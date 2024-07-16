<script setup>
import { ref, reactive, watch } from 'vue'
import useFacilityApi from '@/composables/admin/facilityApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  editFacilityId: Number,
  deleteFacilityId: Number
})

const { results, errors, post, show, put, destroy } = useFacilityApi()
const storeToastMessage = useToastMessageStore()

// handle facility image
const facilityImage = ref()
const showFacilityImage = ref()
const selectFacilityImage = (event) => {
  facilityImage.value = event.target.files[0]
  showFacilityImage.value = URL.createObjectURL(facilityImage.value)
}
//------------------------

// add facility record
const facilityData = reactive({
  name: '',
  description: ''
})
const addFacilitySubmitBtn = ref(true)
const postFacilityRecord = async () => {
  addFacilitySubmitBtn.value = false
  await post(facilityData, facilityImage)
  addFacilitySubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('addFacilityRecord')
    facilityData.name = ''
    facilityData.description = ''
    facilityImage.value = null
    showFacilityImage.value = null
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

// handle update & delete instruction for facility record
const currentEditFacilityId = ref()
watch(props, (foundedIds) => {
  if (foundedIds.editFacilityId && foundedIds.editFacilityId != currentEditFacilityId.value) {
    getFacilityRecord(foundedIds.editFacilityId)
  }
  currentEditFacilityId.value = foundedIds.editFacilityId
  currentDeleteFacilityId.value = foundedIds.deleteFacilityId
})
//----------------

// get single facility record for editing
const getFacilityRecord = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    showFacilityImage.value = results.value.data.facility.image
    editFacilityRecord.name = results.value.data.facility.name
    editFacilityRecord.description = results.value.data.facility.description
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// --------------------------------------

// update facility record
const updateFacilitySubmitBtn = ref(true)
const editFacilityRecord = reactive({
  name: '',
  description: ''
})

const updateFeatureRecord = async () => {
  updateFacilitySubmitBtn.value = false
  await put(currentEditFacilityId.value, editFacilityRecord, facilityImage)
  updateFacilitySubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editFacilityRecord')
    editFacilityRecord.name = ''
    editFacilityRecord.description = ''
    facilityImage.value = null
    showFacilityImage.value = null
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

// delete facility record
const currentDeleteFacilityId = ref()
const deleteFacilitySubmitBtn = ref(true)

const deleteFacilityRecord = async () => {
  deleteFacilitySubmitBtn.value = false
  await destroy(currentDeleteFacilityId.value)
  deleteFacilitySubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteFacilityModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
</script>
<template>
  <div
    class="modal fade"
    id="addFacilityRecord"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form @submit.prevent="postFacilityRecord">
        <input
          type="hidden"
          name="CSRF_TOKEN"
          id="CSRF_TOKEN"
          value="d43f70ba414fabe4d0d1182f06f26a11"
        />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Facility</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Picture</label>
              <input
                type="file"
                id="facility_picture_inp"
                class="form-control shadow-none"
                title="Enter a new Facility Picture (svg format) recomended ."
                accept="image/*"
                required
                @change="selectFacilityImage"
              />
            </div>
            <div class="mb-3" v-if="showFacilityImage">
              <img :src="showFacilityImage" alt="preview image" class="img-fluid" />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Name</label>
              <input
                type="text"
                id="facility_name_inp"
                class="form-control shadow-none"
                title="Enter a new Facility Name"
                maxlength="50"
                required
                v-model.trim="facilityData.name"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Description</label>
              <textarea
                id="facility_description_inp"
                class="form-control shadow-none"
                rows="5"
                maxlength="250"
                v-model.trim="facilityData.description"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="addFacilitySubmitBtn"
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
  <!-- edit facility modal start -->
  <div
    class="modal fade"
    id="editFacilityRecord"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateFeatureRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Facility Record</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Picture</label>
              <input
                type="file"
                id="facility_picture_inp"
                class="form-control shadow-none"
                title="Enter a new Facility Picture (svg format) recomended ."
                accept="image/*"
                @change="selectFacilityImage"
              />
            </div>
            <div class="mb-3" v-if="showFacilityImage">
              <img :src="showFacilityImage" alt="preview image" class="img-fluid" />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="facility_name">Facility Name</label>
              <input
                type="text"
                id="facility_name"
                class="form-control shadow-none"
                title="Edit Facility Name"
                maxlength="50"
                required
                v-model.trim="editFacilityRecord.name"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="facility_description"
                >Facility Description</label
              >
              <textarea
                id="facility_description"
                class="form-control shadow-none"
                rows="5"
                maxlength="250"
                v-model.trim="editFacilityRecord.description"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateFacilitySubmitBtn"
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
  <!-- edit facility modal end -->
  <!-- delete feature modal start -->
  <div
    class="modal fade"
    id="deleteFacilityModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form @submit.prevent="deleteFacilityRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Delete Feature Record</h5>
            <button
              type="reset"
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
              type="submit"
              class="btn btn-danger text-white shadow-none"
              v-if="deleteFacilitySubmitBtn"
            >
              DELETE
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
  <!-- delete feature modal end -->
  <ToastMessage />
</template>

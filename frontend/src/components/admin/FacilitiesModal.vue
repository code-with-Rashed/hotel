<script setup>
import { ref, reactive, watch } from 'vue'
import useFacilityApi from '@/composables/admin/facilityApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  instruction: String,
  editFacilityId: Number,
  deleteFacilityId: Number
})

const { results, errors, post, show, put, destroy } = useFacilityApi()
const storeToastMessage = useToastMessageStore()

// handle facility image
const facilityImage = ref()
const tempFacilityImage = ref()
const showFacilityImage = ref()
const selectFacilityImage = (event) => {
  facilityImage.value = event.target.files[0]
  tempFacilityImage.value = URL.createObjectURL(facilityImage.value)
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
    tempFacilityImage.value = null
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
    getFacilityRecord(propsValues.editFacilityId)
  }
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

const updateFacilityRecord = async () => {
  updateFacilitySubmitBtn.value = false
  await put(props.editFacilityId, editFacilityRecord, facilityImage)
  updateFacilitySubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editFacilityRecord')
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
const deleteFacilitySubmitBtn = ref(true)
const deleteFacilityRecord = async () => {
  deleteFacilitySubmitBtn.value = false
  await destroy(props.deleteFacilityId)
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
            <div class="mb-3" v-if="tempFacilityImage">
              <img :src="tempFacilityImage" alt="preview image" class="img-fluid" />
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
                required
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
      <form @submit.prevent="updateFacilityRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Facility Record</h5>
            <button
              type="button"
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
                required
                v-model.trim="editFacilityRecord.description"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
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
  <!-- delete facility modal start -->
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
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Delete Facility Record</h5>
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
            @click="deleteFacilityRecord"
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
    </div>
  </div>
  <!-- delete facility modal end -->
  <ToastMessage />
</template>

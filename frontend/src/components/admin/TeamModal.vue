<script setup>
import { ref, reactive, watch } from 'vue'
import useTeamApi from '@/composables/admin/teamApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  editTeamMemberId: Number,
  deleteTeamMemberId: Number
})

const { results, errors, post, show, put, destroy } = useTeamApi()
const storeToastMessage = useToastMessageStore()

// handle team member image
const memberImage = ref()
const showMemberImage = ref()
const selectMemberImage = (event) => {
  memberImage.value = event.target.files[0]
  showMemberImage.value = URL.createObjectURL(memberImage.value)
}
//------------------------

// add new team member record
const teamMemberData = reactive({
  name: '',
  designation: ''
})
const addTeamMemberSubmitBtn = ref(true)
const postTeamMemberRecord = async () => {
  addTeamMemberSubmitBtn.value = false
  await post(teamMemberData, memberImage)
  addTeamMemberSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('addTeamMemberModal')
    teamMemberData.name = ''
    teamMemberData.designation = ''
    memberImage.value = null
    showMemberImage.value = null
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

// handle update & delete instruction for team member record
const currentEditTeamMemberId = ref()
watch(props, (foundedIds) => {
  if (foundedIds.editTeamMemberId && foundedIds.editTeamMemberId != currentEditTeamMemberId.value) {
    getTeamMember(foundedIds.editTeamMemberId)
  }
  currentEditTeamMemberId.value = foundedIds.editTeamMemberId
  currentDeleteTeamMemberId.value = foundedIds.deleteTeamMemberId
})
//----------------

// get single team member record for editing
const getTeamMember = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    showMemberImage.value = results.value.data.team.photo
    editTeamMemberRecord.name = results.value.data.team.name
    editTeamMemberRecord.designation = results.value.data.team.designation
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// --------------------------------------

// update team member profile record
const editTeamMemberRecord = reactive({
  name: '',
  designation: ''
})

const updateTeamMemberSubmitBtn = ref(true)
const updateTeamMemberRecord = async () => {
  updateTeamMemberSubmitBtn.value = false
  await put(currentEditTeamMemberId.value, editTeamMemberRecord, memberImage)
  updateTeamMemberSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editTeamMemberModal')
    editTeamMemberRecord.name = ''
    editTeamMemberRecord.designation = ''
    memberImage.value = null
    showMemberImage.value = null
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

// delete team member record
const currentDeleteTeamMemberId = ref()
const deleteTeamMemberSubmitBtn = ref(true)

const deleteTeamMemberRecord = async () => {
  deleteTeamMemberSubmitBtn.value = false
  await destroy(currentDeleteTeamMemberId.value)
  deleteTeamMemberSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteTeamMemberModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
</script>
<template>
  <!-- Add new team member Modal start -->
  <div
    class="modal fade"
    id="addTeamMemberModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="postTeamMemberRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Team Member</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="name">Member Name</label>
              <input
                type="text"
                id="name"
                class="form-control shadow-none"
                title="Enter a new Member Name"
                maxlength="50"
                required
                v-model.trim="teamMemberData.name"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="designation">Member Designation</label>
              <input
                type="text"
                id="designation"
                class="form-control shadow-none"
                title="Enter team member designation"
                maxlength="60"
                required
                v-model.trim="teamMemberData.designation"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="photo">Member Picture</label>
              <input
                type="file"
                id="photo"
                class="form-control shadow-none"
                title="Enter a new Member Picture"
                accept="image/*"
                required
                @change="selectMemberImage"
              />
            </div>
            <div class="mb-3" v-if="showMemberImage">
              <img :src="showMemberImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="addTeamMemberSubmitBtn"
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
  <!-- Add new team member Modal end -->

  <!-- Edit team member Modal start -->
  <div
    class="modal fade"
    id="editTeamMemberModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateTeamMemberRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Updet Team Member Record</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="name">Member Name</label>
              <input
                type="text"
                id="name"
                class="form-control shadow-none"
                title="Update Member Name"
                maxlength="50"
                required
                v-model.trim="editTeamMemberRecord.name"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="designation">Member Designation</label>
              <input
                type="text"
                id="designation"
                class="form-control shadow-none"
                title="Update member designation"
                maxlength="60"
                required
                v-model.trim="editTeamMemberRecord.designation"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold" for="photo"
                >Update Member Picture ( optional )</label
              >
              <input
                type="file"
                id="photo"
                class="form-control shadow-none"
                title="Chose Another Picture"
                accept="image/*"
                @change="selectMemberImage"
              />
            </div>
            <div class="mb-3" v-if="showMemberImage">
              <img :src="showMemberImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateTeamMemberSubmitBtn"
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
  <!-- Edit team member Modal end -->

  <!-- delete team member modal start -->
  <div
    class="modal fade"
    id="deleteTeamMemberModal"
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
          <h5 class="modal-title">Delete team member Record</h5>
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
            @click="deleteTeamMemberRecord"
            v-if="deleteTeamMemberSubmitBtn"
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
  <!-- delete team member modal end -->

  <ToastMessage />
</template>

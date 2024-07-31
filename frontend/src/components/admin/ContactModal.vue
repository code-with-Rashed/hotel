<script setup>
import { ref, watch } from 'vue'
import useContactApi from '@/composables/admin/contactApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'

const props = defineProps({
  viewContactId: Number,
  deleteContactId: Number
})

const { results, errors, show, update, destroy } = useContactApi()
const storeToastMessage = useToastMessageStore()

// handle view & delete instruction for contact message
const currentViewContactId = ref()
watch(props, (foundedIds) => {
  if (foundedIds.viewContactId && foundedIds.viewContactId != currentViewContactId.value) {
    viewContactRecord(foundedIds.viewContactId)
  }
  currentViewContactId.value = foundedIds.viewContactId
  currentDeleteContactId.value = foundedIds.deleteContactId
})
//----------------------------------------------------

// view contact message
const viewContactMessage = ref()
const viewContactRecord = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    viewContactMessage.value = results.value.data.contact

    // if this contact message is first time read then update contact message status
    if (!viewContactMessage.value.status) {
      await update(id)
    }
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//--------------------------

// delete contact message record
const currentDeleteContactId = ref()
const deleteContactMessageBtn = ref(true)

const deleteContactMessage = async () => {
  deleteContactMessageBtn.value = false
  await destroy(currentDeleteContactId.value)
  deleteContactMessageBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteContactMessageModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}

const deleteViewsMessage = () => {
  currentDeleteContactId.value = currentViewContactId.value
}
// -----------------------------
</script>
<template>
  <!-- view details contact message modal start -->
  <div
    class="modal fade"
    id="viewContactMessageModal"
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
          <h5 class="modal-title" id="staticBackdropLabel">View Details Contact Message</h5>
          <button
            type="button"
            class="btn-close shadow-none"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <template v-if="viewContactMessage">
              <p><strong>Name : </strong> {{ viewContactMessage.name }}</p>
              <p><strong>Email : </strong> {{ viewContactMessage.email }}</p>
              <p><strong>Subject : </strong> {{ viewContactMessage.subject }}</p>
              <p><strong>Message : </strong> {{ viewContactMessage.message }}</p>
              <p>
                <strong>Date : </strong>
                {{ dateFormatter(viewContactMessage.created_at) }}
                {{ timeFormatter(viewContactMessage.created_at) }}
              </p>
            </template>
            <template v-else>
              <p class="h4 text-center">Data not found !</p>
            </template>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-danger text-white shadow-none"
            data-bs-toggle="modal"
            data-bs-target="#deleteContactMessageModal"
            @click="deleteViewsMessage"
          >
            DELETE
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- view details contact message modal end -->
  <!-- delete contact message modal start -->
  <div
    class="modal fade"
    id="deleteContactMessageModal"
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
          <h5 class="modal-title" id="staticBackdropLabel">Delete Contact Message</h5>
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
              Are you sure ? you wan't to delete this contact message !
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
            @click="deleteContactMessage"
            v-if="deleteContactMessageBtn"
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
  <!-- delete contact message modal end -->
  <ToastMessage />
</template>

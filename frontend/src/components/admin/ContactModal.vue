<script setup>
import { ref, watch } from 'vue'
import useContactApi from '@/composables/admin/contactApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const props = defineProps({
  viewContactId: Number
})

const { results, errors, show, update } = useContactApi()
const storeToastMessage = useToastMessageStore()

// handle view & delete instruction for contact message
const currentViewContactId = ref()
watch(props, (foundedIds) => {
  if (foundedIds.viewContactId && foundedIds.viewContactId != currentViewContactId.value) {
    viewContactRecord(foundedIds.viewContactId)
  }
  currentViewContactId.value = foundedIds.viewContactId
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
                {{
                  new Date(viewContactMessage.created_at).toLocaleDateString('en-GB', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                  })
                }}
              </p>
            </template>
            <template v-else>
              <p class="h4 text-center">Data not found !</p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- view details contact message modal start -->
  <ToastMessage />
</template>

<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useContactApi from '@/composables/admin/contactApi'
import ContactModal from '@/components/admin/ContactModal.vue'
import { hideBsModal } from '@/helpers/hideBsModal'
import { dateFormatter } from '@/helpers/dateTime'
import { urlSplit } from '@/helpers/urlSplit'

const route = useRoute()
const storeToastMessage = useToastMessageStore()
const { results, errors, get, deleteAll, updateAllStatus, update } = useContactApi()

// get all contact request record
const reloader = ref(true)
const contactRecord = async () => {
  reloader.value = false
  await get(route.query.page)
  reloader.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
onMounted(() => contactRecord())
//-----------------------------

// delete all contact messages
const deleteAllContactMessageBtn = ref(true)
const deleteAllRecord = async () => {
  deleteAllContactMessageBtn.value = false
  await deleteAll()
  deleteAllContactMessageBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteAllContactMessageConfirmationModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await contactRecord()
}
// -----------------------------

// update all contact message status
const updateAllRecordStatus = async () => {
  await updateAllStatus()
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await contactRecord()
}
// -----------------------------

// update contact message status
const updateStatus = async (id) => {
  await update(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await contactRecord()
}
//------------------------------

// change message status
const status = (id) => {
  const statusBtn = document.getElementById('status-' + id)
  if (statusBtn) {
    statusBtn.classList.remove('bg-warning')
    statusBtn.classList.add('bg-primary')
    statusBtn.classList.add('text-white')
    statusBtn.innerHTML = 'Readed'
  }
}

// send contact message id to child (CotactModal) component for view details
const viewContactId = ref(0)
const viewContact = (id) => {
  viewContactId.value = id
  status(id) // the message mark as read
}
//------------------------------------

// send contact message id to child (CotactModal) component for message delete
const deleteContactId = ref(0)
const deleteContact = (id) => {
  deleteContactId.value = id
}
//------------------------------------

// page switching for pagination
watch(route, () => contactRecord())
//------------------------------
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Contact Request Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Contact Us List</h5>
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="contactRecord"
                title="Reload facility record list ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <div>
                <button
                  class="btn btn-success btn-sm shadow-none m-1"
                  type="button"
                  title="Mark all readed ."
                  @click="updateAllRecordStatus"
                >
                  <i class="bi bi-eye"></i> Seen All
                </button>
                <button
                  class="btn btn-danger btn-sm shadow-none m-1"
                  type="button"
                  title="Delete all messages ."
                  data-bs-toggle="modal"
                  data-bs-target="#deleteAllContactMessageConfirmationModal"
                >
                  <i class="bi bi-trash"></i> Delete All
                </button>
              </div>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Name</th>
                    <th width="20%">Email</th>
                    <th width="25%">Subject</th>
                    <th width="8%">Status</th>
                    <th width="12%">Date</th>
                    <th width="15%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template v-for="contact in results.data.contacts.data" :key="contact.id">
                        <tr>
                          <td>{{ contact.id }}</td>
                          <td>{{ contact.name }}</td>
                          <td>{{ contact.email }}</td>
                          <td>{{ contact.subject }}</td>
                          <td>
                            <span
                              @click="updateStatus(contact.id)"
                              class="btn text-white fw-bold btn-sm bg-primary shadow-none"
                              v-if="contact.status"
                              >Readed</span
                            >
                            <span
                              :id="`status-${contact.id}`"
                              @click="updateStatus(contact.id)"
                              class="btn fw-bold btn-sm bg-warning shadow-none"
                              v-else
                              >Unread</span
                            >
                          </td>
                          <td>
                            {{ dateFormatter(contact.created_at) }}
                          </td>
                          <td>
                            <button
                              class="btn btn-sm btn-primary mt-1 rounded shadow-none mx-2"
                              title="View Details contact message ."
                              data-bs-target="#viewContactMessageModal"
                              data-bs-toggle="modal"
                              @click="viewContact(contact.id)"
                            >
                              <i class="bi bi-eye"></i> View
                            </button>
                            <button
                              class="btn btn-sm btn-danger mt-1 rounded shadow-none"
                              title="Delete this message ."
                              data-bs-target="#deleteContactMessageModal"
                              data-bs-toggle="modal"
                              @click="deleteContact(contact.id)"
                            >
                              <i class="bi bi-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </template>
                    </template>
                  </template>
                  <template v-else>
                    <tr class="my-3 text-center">
                      <td colspan="7">
                        <div class="spinner-border" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <!-- pagination template start -->
              <template v-if="results.data">
                <span>{{
                  `Showing ${results.data.contacts.from} to ${results.data.contacts.to} of
                  ${results.data.contacts.total} entries`
                }}</span>
                <ul class="pagination mt-2">
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.contacts.prev_page_url, '?page=')
                            ? urlSplit(results.data.contacts.prev_page_url, '?page=').pop()
                            : urlSplit(results.data.contacts.first_page_url, '?page=').pop()
                        }
                      }"
                      class="page-link shadow-none"
                      type="button"
                      >Previous</RouterLink
                    >
                  </li>
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.contacts.next_page_url, '?page=')
                            ? urlSplit(results.data.contacts.next_page_url, '?page=').pop()
                            : urlSplit(results.data.contacts.last_page_url, '?page=').pop()
                        }
                      }"
                      class="page-link shadow-none"
                      type="button"
                      >Next</RouterLink
                    >
                  </li>
                </ul>
              </template>
              <!-- pagination template end -->
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ContactModal :viewContactId="viewContactId" :deleteContactId="deleteContactId" />
  <ToastMessage />

  <!-- delete all contact message modal start -->
  <div
    class="modal fade"
    id="deleteAllContactMessageConfirmationModal"
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
          <h5 class="modal-title" id="staticBackdropLabel">Delete all Contact Messages</h5>
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
              Are you sure ? you wan't to delete all contact messages !
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
            @click="deleteAllRecord"
            v-if="deleteAllContactMessageBtn"
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
  <!-- delete all contact message modal end -->
</template>

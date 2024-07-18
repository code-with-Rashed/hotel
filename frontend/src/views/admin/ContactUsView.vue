<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useContactApi from '@/composables/admin/contactApi'

const storeToastMessage = useToastMessageStore()
const { results, errors, get, deleteAll } = useContactApi()

// get all contact request record
const reloader = ref(true)
const contactRecord = async () => {
  reloader.value = false
  await get()
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
const deleteAllRecord = async () => {
  await deleteAll()
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// -----------------------------
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
                >
                  <i class="bi bi-eye"></i> Seen All
                </button>
                <button
                  class="btn btn-danger btn-sm shadow-none m-1"
                  type="button"
                  title="Delete all messages ."
                  @click="deleteAllRecord"
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
                      <template v-for="contact in results.data.contacts" :key="contact.id">
                        <tr>
                          <td>{{ contact.id }}</td>
                          <td>{{ contact.name }}</td>
                          <td>{{ contact.email }}</td>
                          <td>{{ contact.subject }}</td>
                          <td>
                            <span
                              class="btn text-white fw-bold btn-sm bg-primary shadow-none"
                              v-if="contact.status"
                              >Readed</span
                            >
                            <span class="btn fw-bold btn-sm bg-warning shadow-none" v-else
                              >Unread</span
                            >
                          </td>
                          <td>
                            {{
                              new Date(contact.created_at).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                              })
                            }}
                          </td>
                          <td>
                            <button
                              class="btn btn-sm btn-primary mt-1 rounded shadow-none mx-2"
                              title="View Details message ."
                            >
                              <i class="bi bi-eye"></i> View
                            </button>
                            <button
                              class="btn btn-sm btn-danger mt-1 rounded shadow-none"
                              title="Delete this message ."
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
              <ul class="pagination mt-2" id="pagination">
                <li class="page-item disabled">
                  <a href="?page=0" class="page-link" type="button">Previous</a>
                </li>
                <li class="page-item">
                  <a href="?page=2" class="page-link" type="button">Next</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

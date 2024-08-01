<script setup>
import LayoutView from './layout/LayoutView.vue'
import RoomModal from '../../components/admin/RoomModal.vue'
import { onMounted, ref } from 'vue'
import useRoomApi from '@/composables/admin/roomApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const { results, errors, get } = useRoomApi()
const storeToastMessage = useToastMessageStore()

// get all hotel room record
const reloader = ref(true)
const roomRecord = async () => {
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
onMounted(() => roomRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Hotel Room Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Rooms</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="roomRecord">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addRoomModal"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row px-3">
              <div class="table-responsive-lg">
                <table class="table border table-hover text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Area</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Guest</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="room-data">
                    <template v-if="reloader">
                      <template v-if="results.data">
                        <template v-for="room in results.data.rooms" :key="room.id">
                          <tr>
                            <td>{{ room.id }}</td>
                            <td>{{ room.name }}</td>
                            <td>{{ room.area }} s-f</td>
                            <td><span class="fw-bold">&#2547;</span> {{ room.price }}</td>
                            <td>{{ room.quantity }}</td>
                            <td>
                              <span class="badge rounded-pill bg-light text-dark text-wrap"
                                >{{ room.adult }} Adult</span
                              >
                              <span class="badge rounded-pill bg-light text-dark text-wrap"
                                >{{ room.children }} Children</span
                              >
                            </td>
                            <td>
                              <button class="btn btn-sm shadow-none btn-primary">Active</button>
                            </td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#room-img-s"
                                title="Add Img"
                              >
                                <i class="bi bi-images"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-secondary mx-1"
                                data-bs-toggle="modal"
                                data-bs-target="#edit-room-s"
                                title="Edit"
                              >
                                <i class="bi bi-pencil-square"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-danger"
                                title="Delete"
                              >
                                <i class="bi bi-trash"></i>
                              </button>
                            </td>
                          </tr>
                        </template>
                      </template>
                    </template>
                    <template v-else>
                      <tr>
                        <td colspan="8">
                          <div class="spinner-border my-4" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
                <!-- pagination start -->
                <ul class="pagination mt-2" id="pagination">
                  <li class="page-item">
                    <a class="page-link" type="button">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" type="button">Next</a>
                  </li>
                </ul>
                <!-- pagination end -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <RoomModal />
  <ToastMessage />
</template>

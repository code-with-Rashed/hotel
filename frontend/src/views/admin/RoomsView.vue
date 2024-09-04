<script setup>
import LayoutView from './layout/LayoutView.vue'
import RoomModal from '../../components/admin/RoomModal.vue'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import useRoomApi from '@/composables/admin/roomApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { urlSplit } from '@/helpers/urlSplit'

const route = useRoute()
const { results, errors, get, roomStatus } = useRoomApi()
const storeToastMessage = useToastMessageStore()

// send instruction props
const instruction = ref('')

// update room status
const updateRoomStatus = async (id) => {
  await roomStatus(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await roomRecord()
}
//------------------------------

// send room id to child (RoomModal) component for editing room record
const editRoomId = ref(0)
const editRoom = (id) => {
  editRoomId.value = id
  instruction.value = 'show'
}
// --------------------------

// send room id to child (RoomModal) component for manage room image record
const roomId = ref(0)
const manageRoomImage = (id) => {
  roomId.value = id
  instruction.value = 'manage-room-image'
}
// --------------------------

// send room id to child (RoomModal) component for manage room feature & facility record
const roomFeatueFacility = (id) => {
  roomId.value = id
  instruction.value = 'manage-room-feature-facility'
}
// ---------------------------

// send room id to child (RoomModal) component for deleting room record
const deleteRoomId = ref(0)
const deleteRoom = (id) => {
  deleteRoomId.value = id
}
// --------------------------

// get all hotel room record
const reloader = ref(true)
const roomRecord = async () => {
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
onMounted(() => roomRecord())
//--------------------------

// page switching for pagination
watch(route, () => roomRecord())
//------------------------------
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
                        <template v-for="room in results.data.rooms.data" :key="room.id">
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
                              <button
                                class="btn btn-sm shadow-none btn-warning"
                                @click="updateRoomStatus(room.id)"
                                v-if="room.status"
                              >
                                Inactive
                              </button>
                              <button
                                class="btn btn-sm shadow-none btn-primary"
                                @click="updateRoomStatus(room.id)"
                                v-else
                              >
                                Active
                              </button>
                            </td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#roomImageModal"
                                title="Manage Room images"
                                @click="manageRoomImage(room.id)"
                              >
                                <i class="bi bi-images"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-success ms-1"
                                data-bs-toggle="modal"
                                data-bs-target="#roomFeatureFacility"
                                title="Manage Room Feature & Facility ."
                                @click="roomFeatueFacility(room.id)"
                              >
                                <i class="bi bi-puzzle"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-secondary mx-1"
                                data-bs-toggle="modal"
                                data-bs-target="#editRoomModal"
                                title="Edit"
                                @click="editRoom(room.id)"
                              >
                                <i class="bi bi-pencil-square"></i>
                              </button>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-danger"
                                title="Delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteRoomModal"
                                @click="deleteRoom(room.id)"
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
                <!-- pagination template start -->
                <template v-if="results.data">
                  <span>{{
                    `Showing ${results.data.rooms.from ?? 0} to ${results.data.rooms.to ?? 0} of
                  ${results.data.rooms.total} entries`
                  }}</span>
                  <ul class="pagination mt-2">
                    <li class="page-item">
                      <RouterLink
                        :to="{
                          query: {
                            page: urlSplit(results.data.rooms.prev_page_url, '?page=')
                              ? urlSplit(results.data.rooms.prev_page_url, '?page=').pop()
                              : urlSplit(results.data.rooms.first_page_url, '?page=').pop()
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
                            page: urlSplit(results.data.rooms.next_page_url, '?page=')
                              ? urlSplit(results.data.rooms.next_page_url, '?page=').pop()
                              : urlSplit(results.data.rooms.last_page_url, '?page=').pop()
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
      </div>
    </template>
  </LayoutView>
  <RoomModal
    :deleteRoomId="deleteRoomId"
    :editRoomId="editRoomId"
    :instruction="instruction"
    :roomId="roomId"
  />
  <ToastMessage />
</template>

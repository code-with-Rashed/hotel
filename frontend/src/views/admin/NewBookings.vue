<script setup>
import LayoutView from './layout/LayoutView.vue'
import useBookingsApi from '@/composables/admin/bookingsApi'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'
import { urlSplit } from '@/helpers/urlSplit'
import { onMounted, reactive, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { hideBsModal } from '@/helpers/hideBsModal'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const route = useRoute()
const { results, errors, getNewBookings, roomAssign } = useBookingsApi()
const storeToastMessage = useToastMessageStore()
const search = ref(null)

// get all new booking records
const reloader = ref(true)
const showNewBookings = async () => {
  reloader.value = false
  await getNewBookings(search.value, route.query.page)
  reloader.value = true
}
onMounted(() => showNewBookings())
// --------------------------

// page switching for pagination
watch(route, () => showNewBookings())
//------------------------------

// assign room for user
const assignRoom = reactive({
  id: '',
  room_no: ''
})
const setId = (id) => {
  assignRoom.id = id
}
const assignRoomSubmitBtn = ref(true)
const assignRoomNow = async () => {
  assignRoomSubmitBtn.value = false
  await roomAssign(assignRoom)
  assignRoomSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('assign_room')
    assignRoom.room_no = ''
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
  await showNewBookings()
}
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>New Bookings Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">All New Bookings</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="showNewBookings">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <div>
                <input
                  type="search"
                  class="form-control shadow-none"
                  placeholder="search"
                  v-model.trim="search"
                  @keyup.enter="showNewBookings"
                />
              </div>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-light">
                  <tr>
                    <th>ID</th>
                    <th>User Details</th>
                    <th>Room Details</th>
                    <th>Booking Details</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template v-for="booking in results.data.new_bookings.data" :key="booking.id">
                        <tr>
                          <td>{{ booking.id }}</td>

                          <td>
                            <span class="badge bg-primary">
                              Transection Id :&nbsp;&nbsp; {{ booking.tran_id }}
                            </span>
                            <br />
                            <b>Name : </b> {{ booking.user_name }}
                            <br />
                            <b>Phone : </b> {{ booking.phone }}
                            <br />
                            <b>email : </b> {{ booking.email }}
                          </td>

                          <td>
                            <b>Room : </b> {{ booking.room_name }}
                            <br />
                            <b>Price : </b>&#2547; {{ booking.price }}
                          </td>

                          <td>
                            <b>Checkin : </b> {{ dateFormatter(booking.checkin) }}
                            <br />
                            <b>Checkout : </b> {{ dateFormatter(booking.checkout) }}
                            <br />
                            <b>Paid : </b>&#2547; {{ booking.amount }}
                            <br />
                            <b>Order Date : </b> {{ dateFormatter(booking.created_at) }} |
                            {{ timeFormatter(booking.created_at) }}
                          </td>

                          <td>
                            <button
                              class="btn text-white fw-bold btn-sm btn-primary shadow-none"
                              type="button"
                              data-bs-toggle="modal"
                              data-bs-target="#assign_room"
                              @click="setId(booking.id)"
                            >
                              <i class="bi bi-check2-square"></i> Assign Room
                            </button>
                            <br />
                            <button
                              class="btn text-white fw-bold btn-sm btn-danger shadow-none mt-1"
                              type="button"
                            >
                              <i class="bi bi-trash"></i> Cancel Booking
                            </button>
                          </td>
                        </tr>
                      </template>
                    </template>
                  </template>
                  <template v-else>
                    <tr class="text-center">
                      <td colspan="6">
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
                  `Showing ${results.data.new_bookings.from ?? 0} to ${results.data.new_bookings.to ?? 0} of
                  ${results.data.new_bookings.total} entries`
                }}</span>
                <ul class="pagination mt-2">
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.new_bookings.prev_page_url, '?page=')
                            ? urlSplit(results.data.new_bookings.prev_page_url, '?page=').pop()
                            : urlSplit(results.data.new_bookings.first_page_url, '?page=').pop()
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
                          page: urlSplit(results.data.new_bookings.next_page_url, '?page=')
                            ? urlSplit(results.data.new_bookings.next_page_url, '?page=').pop()
                            : urlSplit(results.data.new_bookings.last_page_url, '?page=').pop()
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
      <!-- Room Assign Modal start -->
      <div
        class="modal fade"
        id="assign_room"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <form @submit.prevent="assignRoomNow">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Assign Room</h5>
                <button
                  type="reset"
                  class="btn-close shadow-none"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label fw-bold" for="room_no">Room Number</label>
                  <input
                    type="text"
                    id="room_no"
                    class="form-control shadow-none"
                    title="Assign Room Number"
                    required
                    v-model.trim="assignRoom.room_no"
                  />
                </div>
                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                  Note : Assign Room Number only when user has been arrived !
                </span>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button
                  type="submit"
                  class="btn btn-primary text-white shadow-none"
                  v-if="assignRoomSubmitBtn"
                >
                  ASSIGN
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
      <!-- Room Assign Modal end -->
    </template>
  </LayoutView>
  <ToastMessage />
</template>

<script setup>
import LayoutView from './layout/LayoutView.vue'
import useBookingsApi from '@/composables/admin/bookingsApi'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'
import { urlSplit } from '@/helpers/urlSplit'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const route = useRoute()
const { results, errors, getRefundBookings, refundBooking } = useBookingsApi()
const search = ref(null)
const storeToastMessage = useToastMessageStore()

// get all refund booking records
const reloader = ref(true)
const showRefundBookings = async () => {
  reloader.value = false
  await getRefundBookings(search.value, route.query.page)
  reloader.value = true
}
onMounted(() => showRefundBookings())
// --------------------------

// page switching for pagination
watch(route, () => showRefundBookings())
//------------------------------

// set booking id
const bookingId = ref(null)
const setBookingId = (id) => {
  bookingId.value = id
}
// -------------

// request to refund
const refundNow = async () => {
  storeToastMessage.showToastMessage(true, 'Please Wait. Refund payment in proccess.')
  await refundBooking(bookingId.value)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await showRefundBookings()
}
// -----------------------
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Refund Bookings Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Refund Bookings</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="showRefundBookings">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <div>
                <input
                  type="search"
                  class="form-control shadow-none"
                  placeholder="search"
                  v-model.trim="search"
                  @keyup.enter="showRefundBookings"
                />
              </div>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-light">
                  <tr>
                    <th>#</th>
                    <th>User Details</th>
                    <th>Booking Details</th>
                    <th>Refund Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template
                        v-for="booking in results.data.refund_bookings.data"
                        :key="booking.id"
                      >
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
                            <b>Checkin : </b> {{ dateFormatter(booking.checkin) }}
                            <br />
                            <b>Checkout : </b> {{ dateFormatter(booking.checkout) }}
                            <br />
                            <b>Order Date : </b> {{ dateFormatter(booking.created_at) }} |
                            {{ timeFormatter(booking.created_at) }}
                          </td>
                          <td><b>Paid : </b>&#2547; {{ booking.amount }}</td>
                          <td>
                            <button
                              class="btn text-white fw-bold btn-sm btn-primary shadow-none"
                              type="button"
                              data-bs-toggle="modal"
                              data-bs-target="#refundBookingConfirmation"
                              @click="setBookingId(booking.id)"
                            >
                              <i class="bi bi-cash-stack"></i> Refund
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
                  `Showing ${results.data.refund_bookings.from ?? 0} to ${results.data.refund_bookings.to ?? 0} of
                  ${results.data.refund_bookings.total} entries`
                }}</span>
                <ul class="pagination mt-2">
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.refund_bookings.prev_page_url, '?page=')
                            ? urlSplit(results.data.refund_bookings.prev_page_url, '?page=').pop()
                            : urlSplit(results.data.refund_bookings.first_page_url, '?page=').pop()
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
                          page: urlSplit(results.data.refund_bookings.next_page_url, '?page=')
                            ? urlSplit(results.data.refund_bookings.next_page_url, '?page=').pop()
                            : urlSplit(results.data.refund_bookings.last_page_url, '?page=').pop()
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
    <ToastMessage />
  </LayoutView>
  <!-- Refund Booking Confirmation Start -->
  <div class="modal fade" id="refundBookingConfirmation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <strong>Are You Sure You Wan't to Refund this booking mony ?</strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="refundNow">
            Yes
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Refund Booking Confirmation Modal End -->
</template>

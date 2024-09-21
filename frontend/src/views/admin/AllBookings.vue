<script setup>
import LayoutView from './layout/LayoutView.vue'
import useBookingsApi from '@/composables/admin/bookingsApi'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'
import { urlSplit } from '@/helpers/urlSplit'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const { results, getAllBookings } = useBookingsApi()
const search = ref(null)

// get all room booking records
const reloader = ref(true)
const showAllBookings = async () => {
  reloader.value = false
  await getAllBookings(search.value, route.query.page)
  reloader.value = true
}
onMounted(() => showAllBookings())
// --------------------------

// change status background
const status = (status) => {
  let bgColor = ''
  switch (status) {
    case 'booked':
      bgColor = 'bg-primary'
      break

    case 'pending':
      bgColor = 'bg-warning'
      break

    case 'refunded':
      bgColor = 'bg-danger'
      break

    default:
      bgColor = 'bg-secondary'
      break
  }
  return bgColor
}
// ------------------------

// page switching for pagination
watch(route, () => showAllBookings())
//------------------------------

// show booking details for print/download
const bookingDetails = ref(null)
const assignBookingDetails = (index) => {
  bookingDetails.value = results.value.data.all_bookings.data[index]
}
// ---------------------------------------
// Print booking Invoice
const printInvoice = () => {
  window.print()
}
//-------------
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>All Bookings Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">All Bookings</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="showAllBookings">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <div>
                <input
                  type="search"
                  class="form-control shadow-none"
                  placeholder="search"
                  v-model.trim="search"
                  @keyup.enter="showAllBookings"
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
                    <th>Status</th>
                    <th>Invoice</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template
                        v-for="(booking, index) in results.data.all_bookings.data"
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
                            <span
                              class="btn text-white fw-bold btn-sm shadow-none"
                              :class="status(booking.booking_status)"
                              >{{ booking.booking_status }}</span
                            >
                          </td>
                          <td>
                            <span
                              class="btn text-white fw-bold btn-sm bg-primary shadow-none"
                              title="Download Invoice"
                              data-bs-toggle="modal"
                              data-bs-target="#bookingDetailsModal"
                              @click="assignBookingDetails(index)"
                              ><i class="bi bi-file-earmark-arrow-down fw-bold"></i> Invoice</span
                            >
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
                  `Showing ${results.data.all_bookings.from ?? 0} to ${results.data.all_bookings.to ?? 0} of
                  ${results.data.all_bookings.total} entries`
                }}</span>
                <ul class="pagination mt-2">
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.all_bookings.prev_page_url, '?page=')
                            ? urlSplit(results.data.all_bookings.prev_page_url, '?page=').pop()
                            : urlSplit(results.data.all_bookings.first_page_url, '?page=').pop()
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
                          page: urlSplit(results.data.all_bookings.next_page_url, '?page=')
                            ? urlSplit(results.data.all_bookings.next_page_url, '?page=').pop()
                            : urlSplit(results.data.all_bookings.last_page_url, '?page=').pop()
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
  <!-- Booking Details Modal Start -->
  <div
    class="modal fade"
    id="bookingDetailsModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 d-print-none" id="staticBackdropLabel">Booking Details</h1>
          <h1 class="modal-title fs-5 d-none d-print-block" id="staticBackdropLabel">
            Invoice Details
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div v-if="bookingDetails">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><strong>Order ID : </strong>{{ bookingDetails.id }}</li>
              <li class="list-group-item">
                <strong>Transection ID : </strong>{{ bookingDetails.tran_id }}
              </li>
              <li class="list-group-item">
                <strong>Booking Status : </strong>{{ bookingDetails.booking_status.toUpperCase() }}
              </li>
              <li class="list-group-item">
                <strong>Transection Status : </strong>{{ bookingDetails.tran_status.toUpperCase() }}
              </li>
              <li class="list-group-item">
                <strong>Arrival Status : </strong
                >{{ bookingDetails.arrival ? 'arrived' : 'not arrived' }}
              </li>
              <li class="list-group-item">
                <strong>Room Name : </strong>{{ bookingDetails.room_name }}
              </li>
              <li class="list-group-item">
                <strong>Room No : </strong>{{ bookingDetails.room_no ?? 'not assign' }}
              </li>
              <li class="list-group-item">
                <strong>Checkin : </strong>{{ dateFormatter(bookingDetails.checkin) }}
              </li>
              <li class="list-group-item">
                <strong>Checkin : </strong>{{ dateFormatter(bookingDetails.checkout) }}
              </li>
              <li class="list-group-item">
                <strong>Order Date : </strong>{{ dateFormatter(bookingDetails.created_at) }} |
                {{ timeFormatter(bookingDetails.created_at) }}
              </li>
              <li class="list-group-item">
                <strong>Cost : </strong>{{ bookingDetails.price }} {{ bookingDetails.currency }} per
                night.
              </li>
              <li class="list-group-item">
                <strong>Total Cost : </strong>{{ bookingDetails.total_pay }}
                {{ bookingDetails.currency }}
              </li>
              <li class="list-group-item">
                <strong>User Name : </strong>{{ bookingDetails.user_name }}
              </li>
              <li class="list-group-item">
                <strong>User Email : </strong>{{ bookingDetails.email }}
              </li>
              <li class="list-group-item">
                <strong>User Phone : </strong>{{ bookingDetails.phone }}
              </li>
            </ul>
          </div>
          <div class="d-print-none">
            <hr />
            <button
              type="button"
              class="btn btn-primary btn-sm text-center m-auto d-block py-2"
              @click="printInvoice()"
            >
              <i class="bi bi-printer"></i>
              Print Invoice
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Booking Details Modal End -->
</template>

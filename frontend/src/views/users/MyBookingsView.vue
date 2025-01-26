<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import useMyBookingsApi from '@/composables/users/myBookings'
import { onMounted, reactive, ref } from 'vue'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'
import useLogoApi from '@/composables/visitor/logoApi'

const { results: logoResult, get: getLogo } = useLogoApi()
const { results, get, put, sendRatingReview } = useMyBookingsApi()
const storeToastMessage = useToastMessageStore()

// show logo for invoice
const showLogo = async () => {
  await getLogo()
}
// --------------------

// show all order list
const reloader = ref(true)
const show = async () => {
  reloader.value = false
  await get()
  reloader.value = true
}
onMounted(() => {
  show()
  showLogo()
})
//------------------

// show booking details for print/download
const bookingDetails = ref(null)
const assignBookingDetails = (index) => {
  bookingDetails.value = results.value.data[index]
}
// ---------------------------------------
// Print booking Invoice
const printInvoice = () => {
  window.print()
}
//-------------

// cancel booking
const cancelBookingId = ref(null)
const assignCancelId = (id) => {
  cancelBookingId.value = id
}
const cancelNow = async () => {
  await put(cancelBookingId.value)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  await show()
}
// -----------------------

// handle rating & review
const ratingReview = reactive({
  booking_order_id: '',
  room_id: '',
  user_id: '',
  star: '5',
  message: ''
})
const assignRatingReviewRelation = (index) => {
  ratingReview.booking_order_id = results.value.data[index].id
  ratingReview.room_id = results.value.data[index].room_id
  ratingReview.user_id = results.value.data[index].user_id
}
const sendFeedbackSubmitBtn = ref(true)
const sendFeedbackNow = async () => {
  sendFeedbackSubmitBtn.value = false
  await sendRatingReview(ratingReview)
  sendFeedbackSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  ratingReview.star = '5'
  ratingReview.message = ''
  hideBsModal('ratingReview')
  await show()
}
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container d-print-none">
        <div class="row">
          <div class="col-12 mb-4 my-5 px-4">
            <h3 class="fw-bold">Booking List</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <RouterLink :to="{ name: 'home-page' }">Home</RouterLink>
              </li>
              <li class="breadcrumb-item active" aria-current="page">My Booking List</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <template v-if="reloader">
            <template v-if="results.data">
              <template v-for="(booking, index) in results.data" :key="booking.id">
                <div class="col-md-4 px-3 mb-3">
                  <div class="card border-0 shadow p-3">
                    <div>
                      <strong>{{ booking.booking_details.room_name }}</strong
                      ><br />
                      <strong>Room Unique ID : {{ booking.room_id }}</strong
                      ><br />
                      <strong>Room No : {{ booking.booking_details.room_no }}</strong
                      ><br />
                      <span class="mt-1 d-block"
                        ><span class="fs-5">&#2547;</span> {{ booking.booking_details.price }} Per
                        Night</span
                      >
                    </div>
                    <div class="mt-1">
                      <strong>Transection ID : </strong
                      ><span class="badge bg-primary p-1">{{ booking.tran_id }}</span>
                    </div>
                    <div class="mt-3">
                      <strong>Transection Status : </strong>
                      <span
                        class="badge"
                        :class="{
                          'bg-primary': booking.tran_status.toLowerCase() == 'valid' ? true : false,
                          'bg-danger':
                            booking.tran_status.toLowerCase() == 'cancelled' ||
                            booking.tran_status.toLowerCase() == 'failed'
                              ? true
                              : false,
                          'bg-warning':
                            booking.tran_status.toLowerCase() == 'pending' ? true : false
                        }"
                        >{{ booking.tran_status }}</span
                      >
                    </div>
                    <div class="mt-3">
                      <strong>Checkin : </strong>{{ dateFormatter(booking.checkin) }} <br />
                      <strong>Checkout : </strong>{{ dateFormatter(booking.checkout) }} <br />
                    </div>
                    <div class="mt-3">
                      <strong>Total Amount : </strong><span class="fs-5">&#2547;</span>
                      {{ booking.booking_details.total_pay }} <br />
                      <strong>Paid Amount : </strong><span class="fs-5">&#2547;</span>
                      {{ booking.amount }} <br />
                      <strong>Order Date : </strong>{{ dateFormatter(booking.created_at) }} |
                      {{ timeFormatter(booking.created_at) }}
                    </div>
                    <div class="mt-3">
                      <div>
                        <strong>Booking Status : </strong
                        ><span class="badge bg-primary mb-3">{{ booking.booking_status }}</span>
                      </div>
                      <template v-if="booking.booking_status.toLowerCase() == 'booked'">
                        <template v-if="booking.arrival">
                          <template v-if="booking.booking_details.rating">
                            <button
                              class="btn btn-dark btn-sm shadow-none me-1"
                              data-bs-toggle="modal"
                              data-bs-target="#bookingDetailsModal"
                              @click="assignBookingDetails(index)"
                            >
                              <i class="bi bi-file-earmark-arrow-down fw-bold"></i>
                              Download PDF
                            </button>
                          </template>
                          <template v-else>
                            <button
                              class="btn btn-dark btn-sm shadow-none me-1"
                              data-bs-toggle="modal"
                              data-bs-target="#bookingDetailsModal"
                              @click="assignBookingDetails(index)"
                            >
                              <i class="bi bi-file-earmark-arrow-down fw-bold"></i>
                              Download PDF
                            </button>
                            <button
                              class="btn btn-primary btn-sm shadow-none me-1"
                              data-bs-toggle="modal"
                              data-bs-target="#ratingReview"
                              @click="assignRatingReviewRelation(index)"
                            >
                              <i class="bi bi-stars fw-bold"></i>
                              Rate & Review
                            </button>
                          </template>
                        </template>
                        <template v-else>
                          <button
                            class="btn btn-danger btn-sm shadow-none me-1"
                            @click="assignCancelId(booking.id)"
                            data-bs-toggle="modal"
                            data-bs-target="#cancelBookingModal"
                          >
                            <i class="bi bi-x-octagon fw-bold"></i>
                            Cancel my Booking
                          </button>
                        </template>
                      </template>
                      <template v-else-if="booking.booking_status.toLowerCase() == 'cancelled'">
                        <template v-if="booking.refund">
                          <button
                            class="btn btn-dark btn-sm shadow-none me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#bookingDetailsModal"
                            @click="assignBookingDetails(index)"
                          >
                            <i class="bi bi-file-earmark-arrow-down fw-bold"></i>
                            Download PDF
                          </button>
                        </template>
                        <template v-else>
                          <button class="btn btn-danger btn-sm shadow-none me-1">
                            <i class="bi bi-cash-coin fw-bold"></i>
                            Refund in Proccess
                          </button>
                        </template>
                      </template>
                      <template v-else>
                        <button
                          class="btn btn-warning btn-sm shadow-none me-1"
                          data-bs-toggle="modal"
                          data-bs-target="#bookingDetailsModal"
                          @click="assignBookingDetails(index)"
                        >
                          <i class="bi bi-file-earmark-arrow-down fw-bold"></i>
                          Download PDF
                        </button>
                      </template>
                    </div>
                  </div>
                </div>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="col-12 text-center mx-3">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />

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
          <div class="d-none d-print-block">
            <template v-if="logoResult.data">
              <img
                :src="logoResult.data.logo?.logo"
                alt="logo"
                height="50"
                width="50"
                class="rounded"
              />
            </template>
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Invoice Details</h1>
          </div>
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
                <strong>Room Name : </strong>{{ bookingDetails.booking_details.room_name }}
              </li>
              <li class="list-group-item">
                <strong>Room No : </strong
                >{{ bookingDetails.booking_details.room_no ?? 'not assign' }}
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
                <strong>Cost : </strong>{{ bookingDetails.booking_details.price }}
                {{ bookingDetails.currency }} per night.
              </li>
              <li class="list-group-item">
                <strong>Total Cost : </strong>{{ bookingDetails.booking_details.total_pay }}
                {{ bookingDetails.currency }}
              </li>
              <li class="list-group-item">
                <strong>User Name : </strong>{{ bookingDetails.booking_details.user_name }}
              </li>
              <li class="list-group-item">
                <strong>User Email : </strong>{{ bookingDetails.booking_details.email }}
              </li>
              <li class="list-group-item">
                <strong>User Phone : </strong>{{ bookingDetails.booking_details.phone }}
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

  <!-- Cancel Booking Warning Modal Start -->
  <div class="modal fade" id="cancelBookingModal" aria-hidden="true">
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
          <strong>Are You Sure You Wan't to Cancel this booking ?</strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="cancelNow">
            Yes
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Cancel Booking Warning Modal End -->

  <!--  Rating & Review Modal Start -->
  <div
    class="modal fade"
    id="ratingReview"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="sendFeedbackNow">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Rating & Review</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Feedback Label</label>
              <select v-model="ratingReview.star" required class="form-control shadow-none">
                <option value="5">Exelent</option>
                <option value="4">Good</option>
                <option value="3">Ok</option>
                <option value="2">Poor</option>
                <option value="1">Bad</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Feedback Message</label>
              <textarea
                name="message"
                cols="1"
                class="form-control shadow-none"
                required
                maxlength="255"
                v-model="ratingReview.message"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="sendFeedbackSubmitBtn"
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
  <!--  Rating & Review Modal End -->
</template>

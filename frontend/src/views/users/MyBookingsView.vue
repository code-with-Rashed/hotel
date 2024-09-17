<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import useMyBookingsApi from '@/composables/users/myBookings'
import { onMounted, ref } from 'vue'
import { dateFormatter } from '@/helpers/dateTime'

const { results, get } = useMyBookingsApi()

// show all order list
const reloader = ref(true)
const show = async () => {
  reloader.value = false
  await get()
  reloader.value = true
}
//------------------

onMounted(() => show())
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
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
              <template v-for="booking in results.data" :key="booking.id">
                <div class="col-md-4 px-3 mb-3">
                  <div class="card border-0 shadow p-3">
                    <div>
                      <strong>{{ booking.booking_details.room_name }}</strong
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
                      <strong>Order Date : </strong>{{ dateFormatter(booking.created_at) }}
                    </div>
                    <div class="mt-3">
                      <div>
                        <strong>Booking Status : </strong
                        ><span class="badge bg-primary mb-3">{{ booking.booking_status }}</span>
                      </div>
                      <template v-if="booking.booking_status.toLowerCase() == 'booked'">
                        <template v-if="booking.arrival">
                          <template v-if="booking.booking_details.rating">
                            <button class="btn btn-dark btn-sm shadow-none me-1">
                              Download PDF
                            </button>
                          </template>
                          <template v-else>
                            <button class="btn btn-dark btn-sm shadow-none me-1">
                              Download PDF
                            </button>
                            <button class="btn btn-primary btn-sm shadow-none me-1">
                              Rate & Review
                            </button>
                          </template>
                        </template>
                        <template v-else>
                          <button class="btn btn-danger btn-sm shadow-none me-1">
                            Cancel my Booking
                          </button>
                        </template>
                      </template>
                      <template v-else-if="booking.booking_status.toLowerCase() == 'cancelled'">
                        <template v-if="booking.refund">
                          <button class="btn btn-dark btn-sm shadow-none me-1">Download PDF</button>
                        </template>
                        <template v-else>
                          <button class="btn btn-danger btn-sm shadow-none me-1">
                            Refund in Proccess
                          </button>
                        </template>
                      </template>
                      <template v-else>
                        <button class="btn btn-warning btn-sm shadow-none me-1">
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
</template>

<script setup>
import LayoutView from './layout/LayoutView.vue'
import useBookingsApi from '@/composables/admin/bookingsApi'
import { dateFormatter } from '@/helpers/dateTime'
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
                            <b>Order Date : </b> {{ dateFormatter(booking.created_at) }}
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
    </template>
  </LayoutView>
</template>

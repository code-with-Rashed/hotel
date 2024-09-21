<script setup>
import LayoutView from './layout/LayoutView.vue'
import useBookingsApi from '@/composables/admin/bookingsApi'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'
import { urlSplit } from '@/helpers/urlSplit'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const { results, getNewBookings } = useBookingsApi()
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
    </template>
  </LayoutView>
</template>

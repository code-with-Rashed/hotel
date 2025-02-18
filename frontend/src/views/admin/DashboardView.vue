<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref } from 'vue'
import useDashboardApi from '@/composables/admin/dashboardApi'

const { results, getSummary, getBookingAnalytics, getAnalytics } = useDashboardApi()
const period = ref(1)

// show achivement summary record
const summaryResults = ref(null)
const showSummary = async () => {
  await getSummary()
  summaryResults.value = results.value.data
}
//--------------------------------

// show booking analytics
const bookingAnalyticsResults = ref(null)
const showBookingAnalytics = async () => {
  await getBookingAnalytics(period.value)
  bookingAnalyticsResults.value = results.value.data[0]
}
//----------------------

// show users, queries, ratings & reviews related analytics
const analyticsResults = ref(null)
const showAnalytics = async () => {
  await getAnalytics(period.value)
  analyticsResults.value = results.value.data
}
//----------------------

onMounted(() => {
  showSummary()
  showBookingAnalytics()
  showAnalytics()
})
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <div class="d-flex justify-content-between mb-4 align-items-center">
          <h3>Dashboard</h3>
        </div>
        <div class="row mb-4">
          <div class="col-md-3 mb-4">
            <RouterLink :to="{ name: 'new-bookings' }" class="text-decoration-none">
              <div class="card text-center text-success p-3">
                <i class="bi bi-box-arrow-up-right d-block text-end"></i>
                <h6>New Bookings</h6>
                <h1 class="mt-3 mb-0">{{ summaryResults?.new_bookings }}</h1>
              </div>
            </RouterLink>
          </div>
          <div class="col-md-3 mb-4">
            <RouterLink :to="{ name: 'refund-bookings' }" class="text-decoration-none">
              <div class="card text-center text-warning p-3">
                <i class="bi bi-box-arrow-up-right d-block text-end"></i>
                <h6>Request for refund Bookings</h6>
                <h1 class="mt-3 mb-0">{{ summaryResults?.request_refund_bookings }}</h1>
              </div>
            </RouterLink>
          </div>
          <div class="col-md-3 mb-4">
            <RouterLink :to="{ name: 'contact-us' }" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <i class="bi bi-box-arrow-up-right d-block text-end"></i>
                <h6>New Contacts</h6>
                <h1 class="mt-3 mb-0">{{ summaryResults?.new_contacts }}</h1>
              </div>
            </RouterLink>
          </div>
          <div class="col-md-3 mb-4">
            <RouterLink :to="{ name: 'ratings-reviews' }" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <i class="bi bi-box-arrow-up-right d-block text-end"></i>
                <h6>New Ratings & Reviews</h6>
                <h1 class="mt-3 mb-0">{{ summaryResults?.new_ratings_reviews }}</h1>
              </div>
            </RouterLink>
          </div>
        </div>

        <div class="d-flex justify-content-between mb-4 align-items-center">
          <h5>Booking Analytics</h5>
          <select
            class="form-select w-auto shadow-none bg-light"
            @change="showBookingAnalytics"
            v-model="period"
          >
            <option value="1">Past 30 days</option>
            <option value="2">Past 90 days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All Time</option>
          </select>
        </div>

        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Total Bookings</h6>
              <h1 class="mt-2 mb-0">{{ bookingAnalyticsResults?.total_bookings }}</h1>
              <h4 class="mt-2 mb-0">
                &#2547; {{ bookingAnalyticsResults?.total_bookings_amount }}
              </h4>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-info text-center p-3">
              <h6>Active Bookings</h6>
              <h1 class="mt-2 mb-0">{{ bookingAnalyticsResults?.active_bookings }}</h1>
              <h4 class="mt-2 mb-0">
                &#2547; {{ bookingAnalyticsResults?.active_bookings_amount }}
              </h4>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-warning text-center p-3">
              <h6>Refunded Bookings</h6>
              <h1 class="mt-2 mb-0">{{ bookingAnalyticsResults?.refunded_bookings }}</h1>
              <h4 class="mt-2 mb-0">
                &#2547; {{ bookingAnalyticsResults?.refunded_bookings_amount }}
              </h4>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-danger text-center p-3">
              <h6>Cancelled Bookings</h6>
              <h1 class="mt-2 mb-0">{{ bookingAnalyticsResults?.cancelled_bookings }}</h1>
              <h4 class="mt-2 mb-0">
                &#2547; {{ bookingAnalyticsResults?.cancelled_bookings_amount }}
              </h4>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between mb-4 align-items-center">
          <h5>User , Queries , Reviews Analytics</h5>
          <select
            class="form-select w-auto shadow-none bg-light"
            @change="showAnalytics"
            v-model="period"
          >
            <option value="1">Past 30 days</option>
            <option value="2">Past 90 days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All Time</option>
          </select>
        </div>

        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>New Registration</h6>
              <h1 class="mt-2 mb-0" id="total_user">{{ analyticsResults?.total_users }}</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-success text-center p-3">
              <h6>Contact us</h6>
              <h1 class="mt-2 mb-0" id="total_contact">
                {{ analyticsResults?.total_contact_query }}
              </h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Reviews</h6>
              <h1 class="mt-2 mb-0" id="total_rating_review">
                {{ analyticsResults?.total_ratings_reviews }}
              </h1>
            </div>
          </div>
        </div>

        <h5>Users</h5>
        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Total Users</h6>
              <h1 class="mt-2 mb-0">5</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-success text-center p-3">
              <h6>Active Users</h6>
              <h1 class="mt-2 mb-0">5</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-warning text-center p-3">
              <h6>Inactive Users</h6>
              <h1 class="mt-2 mb-0">0</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-danger text-center p-3">
              <h6>Unvarified Users</h6>
              <h1 class="mt-2 mb-0">0</h1>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

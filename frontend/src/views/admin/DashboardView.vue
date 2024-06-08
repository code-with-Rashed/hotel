<script setup>
import LayoutView from './layout/LayoutView.vue'
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
            <a href="new_bookings.php" class="text-decoration-none">
              <div class="card text-center text-success p-3">
                <h6>New Bookings</h6>
                <h1 class="mt-3 mb-0">1</h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="refund_bookings.php" class="text-decoration-none">
              <div class="card text-center text-warning p-3">
                <h6>Refund Bookings</h6>
                <h1 class="mt-3 mb-0">0</h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="contact_us.php" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>New Contacts</h6>
                <h1 class="mt-3 mb-0">0</h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="ratings_reviews.php" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Rating &amp; Review</h6>
                <h1 class="mt-3 mb-0">0</h1>
              </div>
            </a>
          </div>
        </div>

        <div class="d-flex justify-content-between mb-4 align-items-center">
          <h5>Booking Analytics</h5>
          <select
            class="form-select w-auto shadow-none bg-light"
            onchange="booking_analytics(this.value)"
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
              <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
              <h4 class="mt-2 mb-0" id="total_bookings_amount">&#2547; 0</h4>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Active Bookings</h6>
              <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
              <h4 class="mt-2 mb-0" id="active_bookings_amount">৳ 0</h4>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Cancelled Bookings</h6>
              <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
              <h4 class="mt-2 mb-0" id="cancelled_bookings_amount">৳ 0</h4>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between mb-4 align-items-center">
          <h5>User , Queries , Reviews Analytics</h5>
          <select class="form-select w-auto shadow-none bg-light">
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
              <h1 class="mt-2 mb-0" id="total_user">5</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-success text-center p-3">
              <h6>Contact us</h6>
              <h1 class="mt-2 mb-0" id="total_contact">3</h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-primary text-center p-3">
              <h6>Reviews</h6>
              <h1 class="mt-2 mb-0" id="total_rating_review">5</h1>
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

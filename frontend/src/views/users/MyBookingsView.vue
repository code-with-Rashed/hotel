<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import { RouterLink } from 'vue-router'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row">
          <div class="col-12 mb-4 my-5 px-4">
            <h3 class="fw-bold">Booking List</h3>
            <div style="font-size: 14px">
              <RouterLink :to="{ name: 'home-page' }" class="text-secondary text-decoration-none"
                >Home
              </RouterLink>
              <span class="text-secondary mx-1">&gt;</span>
              <a href="javascript:void(0)" class="text-secondary text-decoration-none"
                >My Booking List</a
              >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Cupple</strong><br />
                <span class="mt-1 d-block">&#2547; 45654 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_6671ccd4905d2</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>19/06/2024 <br />
                <strong>Checkout : </strong>20/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 45654 <br />
                <strong>Paid Amount : </strong>&#2547; 45654 <br />
                <strong>Order Date : </strong>19/06/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-primary mb-3">booked</span>
                </div>
                <button class="btn btn-danger btn-sm shadow-none" onclick="cancel_bokking(13)">
                  Cancel
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Cupple</strong><br />
                <span class="mt-1 d-block">&#2547; 45654 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_6671ccb431609</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-warning">FAILED</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>19/06/2024 <br />
                <strong>Checkout : </strong>20/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 45654 <br />
                <strong>Paid Amount : </strong>&#2547; 0 <br />
                <strong>Order Date : </strong>19/06/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-warning mb-3">pending</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Rooms</strong><br />
                <span class="mt-1 d-block">&#2547; 2000 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_665a32a8f0521</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>01/06/2024 <br />
                <strong>Checkout : </strong>04/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 6000 <br />
                <strong>Paid Amount : </strong>&#2547; 6000 <br />
                <strong>Order Date : </strong>01/06/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-danger mb-3">cancelled</span>
                </div>
                <span class="badge bg-danger">Refund in process</span>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Cupple</strong><br />
                <span class="mt-1 d-block">&#2547; 45654 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_66575cf2c1d5a</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>01/06/2024 <br />
                <strong>Checkout : </strong>03/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 91308 <br />
                <strong>Paid Amount : </strong>&#2547; 91308 <br />
                <strong>Order Date : </strong>29/05/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-warning mb-3">refunded</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Rooms</strong><br />
                <span class="mt-1 d-block">&#2547; 2000 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_66522fefa82f7</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>04/06/2024 <br />
                <strong>Checkout : </strong>08/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 8000 <br />
                <strong>Paid Amount : </strong>&#2547; 8000 <br />
                <strong>Order Date : </strong>25/05/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-primary mb-3">booked</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Laxary</strong><br />
                <span class="mt-1 d-block">&#2547; 3223 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_66522fca275dd</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>01/06/2024 <br />
                <strong>Checkout : </strong>04/06/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 9669 <br />
                <strong>Paid Amount : </strong>&#2547; 9669 <br />
                <strong>Order Date : </strong>25/05/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-primary mb-3">booked</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Duplex</strong><br />
                <span class="mt-1 d-block">&#2547; 12000 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_66522f92f3d92</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>29/05/2024 <br />
                <strong>Checkout : </strong>31/05/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 24000 <br />
                <strong>Paid Amount : </strong>&#2547; 24000 <br />
                <strong>Order Date : </strong>25/05/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-primary mb-3">booked</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
          <div class="col-md-4 px-3 mb-3">
            <div class="card border-0 shadow-sm p-3">
              <div>
                <strong>Cupple</strong><br />
                <span class="mt-1 d-block">&#2547; 45654 Per Night</span>
              </div>
              <div class="mt-1">
                <strong>Transection ID : </strong
                ><span class="badge bg-primary p-1">SSLCZ_TEST_66522f0ddc604</span>
              </div>
              <div class="mt-3">
                <strong>Transection Status : </strong>
                <span class="badge bg-success">SUCCESS</span>
              </div>
              <div class="mt-3">
                <strong>Checkin : </strong>26/05/2024 <br />
                <strong>Checkout : </strong>28/05/2024 <br />
              </div>
              <div class="mt-3">
                <strong>Total Amount : </strong>&#2547; 91308 <br />
                <strong>Paid Amount : </strong>&#2547; 91308 <br />
                <strong>Order Date : </strong>25/05/2024
              </div>
              <div class="mt-3">
                <div>
                  <strong>Booking Status : </strong
                  ><span class="badge bg-primary mb-3">booked</span>
                </div>
                <button type="button" class="btn btn-dark btn-sm shadow-none">Download Pdf</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

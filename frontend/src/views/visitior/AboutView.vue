<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="my-5 px-4">
        <h2 class="fw-bold text-center h-fonts">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Excepturi odit saepe et eveniet
          dolor id aspernatur natus sapiente cum at? <br />
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, pariatur?
        </p>
      </div>

      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-lg-6 col-md-5 mb-4 order-lg-0 order-md-0 order-1">
            <h3 class="mb-3">Lorem ipsum dolor sit amet.</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum repudiandae voluptate
              id tempora magnam iure laudantium illo ipsam. Reiciendis aliquid consectetur accusamus
              odio dolorem ipsam vero consequuntur vel assumenda? Commodi, illum repellendus.
            </p>
          </div>
          <div class="col-lg-5 col-md-5 mb-4 order-lg-1 order-md-1 order-0">
            <img
              src="http://localhost/hotel/images/about/about.jpg"
              alt="about image"
              class="w-100"
            />
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row mt-5">
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white text-center shadow rounded border-top border-4 p-4 box">
              <img
                src="http://localhost/hotel/images/about/hotel.svg"
                alt="about hotel"
                width="70px"
              />
              <h6 class="mt-3">100+ Rooms</h6>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white text-center shadow rounded border-top border-4 p-4 box">
              <img
                src="http://localhost/hotel/images/about/customers.svg"
                alt="about customer"
                width="70px"
              />
              <h6 class="mt-3">200+ Customers</h6>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white text-center shadow rounded border-top border-4 p-4 box">
              <img
                src="http://localhost/hotel/images/about/rating.svg"
                alt="about ratting"
                width="70px"
              />
              <h6 class="mt-3">100k+ Ratting</h6>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white text-center shadow rounded border-top border-4 p-4 box">
              <img
                src="http://localhost/hotel/images/about/staff.svg"
                alt="about staff"
                width="70px"
              />
              <h6 class="mt-3">150+ Staffs</h6>
            </div>
          </div>
        </div>
      </div>

      <h3 class="text-center fw-bold my-5 h-fonts">MANAGEMENT TEAM</h3>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow rounded border-0">
              <img
                class="card-img-top"
                src="http://localhost/hotel/images/about/IMG26969.png"
                alt="Card image cap"
              />
              <div class="card-body">
                <h5 class="card-title text-center">Rashed alam</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow rounded border-0">
              <img
                class="card-img-top"
                src="http://localhost/hotel/images/about/IMG89419.png"
                alt="Card image cap"
              />
              <div class="card-body">
                <h5 class="card-title text-center">Kethrin</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow rounded border-0">
              <img
                class="card-img-top"
                src="http://localhost/hotel/images/about/IMG14983.png"
                alt="Card image cap"
              />
              <div class="card-body">
                <h5 class="card-title text-center">Mujahid islam</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow rounded border-0">
              <img
                class="card-img-top"
                src="http://localhost/hotel/images/about/IMG55395.png"
                alt="Card image cap"
              />
              <div class="card-body">
                <h5 class="card-title text-center">Menila</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

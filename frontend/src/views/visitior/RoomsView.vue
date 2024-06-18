<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="my-5 px-4">
        <h2 class="fw-bold text-center h-fonts">OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
              <div class="container-fluid flex-lg-column align-items-stretch">
                <div class="d-flex justify-content-between align-items-center">
                  <h4 class="mt-2">FILTERS</h4>
                  <button
                    type="button"
                    class="btn btn-sm shadow-none btn-warning"
                    onclick="reset_filters()"
                  >
                    All Reset
                  </button>
                </div>
                <button
                  class="navbar-toggler shadow-none"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#filterDropdown"
                  aria-controls="navbarNav"
                  aria-expanded="false"
                  aria-label="Toggle navigation"
                >
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div
                  class="collapse navbar-collapse flex-column align-items-stretch mt-2"
                  id="filterDropdown"
                >
                  <div class="bg-light rounded p-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-3 fs-5">CHECK AVAILABILITY</h5>
                      <button
                        type="button"
                        class="btn btn-sm shadow-none btn-warning d-none"
                        onclick="reset_check_availability()"
                        id="reset_check_availability_btn"
                      >
                        Reset
                      </button>
                    </div>
                    <label class="form-label" for="checkin">Check-in</label>
                    <input
                      type="date"
                      id="checkin"
                      onchange="checkin_checkout_data()"
                      class="form-control mb-3"
                      value=""
                    />
                    <label class="form-label" for="checkout">Check-out</label>
                    <input
                      type="date"
                      id="checkout"
                      onchange="checkin_checkout_data()"
                      class="form-control"
                      value=""
                    />
                  </div>
                  <div class="bg-light rounded p-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-3 fs-5">FACILITIES</h5>
                      <button
                        type="button"
                        class="btn btn-sm shadow-none btn-warning d-none"
                        onclick="reset_facilities()"
                        id="reset_facilities_btn"
                      >
                        Reset
                      </button>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-4"
                        class="form-check-input me-1"
                        value="4"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-4">wifi</label>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-5"
                        class="form-check-input me-1"
                        value="5"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-5">Telivision</label>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-6"
                        class="form-check-input me-1"
                        value="6"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-6">Ac</label>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-7"
                        class="form-check-input me-1"
                        value="7"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-7">Cleaner</label>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-8"
                        class="form-check-input me-1"
                        value="8"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-8">Hitter</label>
                    </div>
                    <div class="mb-2">
                      <input
                        type="checkbox"
                        id="f-9"
                        class="form-check-input me-1"
                        value="9"
                        name="selected_facility"
                        onclick="facility()"
                      />
                      <label class="form-check-label" for="f-9">Micro oven</label>
                    </div>
                  </div>
                  <div class="bg-light rounded p-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-3 fs-5">GUESTS</h5>
                      <button
                        type="button"
                        class="btn btn-sm shadow-none btn-warning d-none"
                        onclick="reset_guest()"
                        id="reset_guest_btn"
                      >
                        Reset
                      </button>
                    </div>
                    <div class="d-flex">
                      <div class="me-4">
                        <label for="adult" class="form-label">Adult</label>
                        <input
                          type="number"
                          oninput="guest()"
                          class="form-control shadow-none"
                          id="adult"
                          value=""
                        />
                      </div>
                      <div>
                        <label for="children" class="form-label">Children</label>
                        <input
                          type="number"
                          oninput="guest()"
                          class="form-control shadow-none"
                          id="children"
                          value=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </nav>
          </div>
          <!-- Show Rooms -->
          <div class="col-lg-9 col-md-12 px-4" id="show-rooms">
            <div class="card mb-4 border-0 shadow">
              <div class="row g-0 align-items-center p-3">
                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                  <img
                    src="http://localhost/hotel/images/rooms/IMG11314.jpg"
                    alt="rooms"
                    class="img-fluid rounded"
                  />
                </div>
                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                  <h5 class="mb-2">Rooms</h5>
                  <div class="features mb-3">
                    <h6 class="mb-1">Features</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Belcony</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Buth</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Door</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Window</span
                    >
                  </div>
                  <div class="facilities mb-3">
                    <h6 class="mb-1">Facilities</h6>
                    <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >wifi</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Telivision</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Ac</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Cleaner</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Hitter</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Micro oven</span
                    >
                  </div>
                  <div class="guest">
                    <h6 class="mb-1">Guest</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >5 Adult</span
                    >
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >5 Children</span
                    >
                  </div>
                  <div class="area">
                    <h6 class="mb-1">Area</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap"
                      >120 &nbsp; Squarefit</span
                    >
                  </div>
                </div>
                <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                  <h6 class="mb-3">
                    <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 2000</span> Per
                    Night
                  </h6>
                  <button
                    onclick="user_status(0,1)"
                    class="btn w-100 custom-bg text-white shadow-none mb-2"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=1" class="btn w-100 btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
            <div class="card mb-4 border-0 shadow">
              <div class="row g-0 align-items-center p-3">
                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                  <img
                    src="http://localhost/hotel/images/rooms/IMG42815.png"
                    alt="rooms"
                    class="img-fluid rounded"
                  />
                </div>
                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                  <h5 class="mb-2">Laxary</h5>
                  <div class="features mb-3">
                    <h6 class="mb-1">Features</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Belcony</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Buth</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Door</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Window</span
                    >
                  </div>
                  <div class="facilities mb-3">
                    <h6 class="mb-1">Facilities</h6>
                    <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >wifi</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Telivision</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Cleaner</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Hitter</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Micro oven</span
                    >
                  </div>
                  <div class="guest">
                    <h6 class="mb-1">Guest</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >4 Adult</span
                    >
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >3 Children</span
                    >
                  </div>
                  <div class="area">
                    <h6 class="mb-1">Area</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap"
                      >1234 &nbsp; Squarefit</span
                    >
                  </div>
                </div>
                <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                  <h6 class="mb-3">
                    <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 3223</span> Per
                    Night
                  </h6>
                  <button
                    onclick="user_status(0,2)"
                    class="btn w-100 custom-bg text-white shadow-none mb-2"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=2" class="btn w-100 btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
            <div class="card mb-4 border-0 shadow">
              <div class="row g-0 align-items-center p-3">
                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                  <img
                    src="http://localhost/hotel/images/rooms/IMG33142.png"
                    alt="rooms"
                    class="img-fluid rounded"
                  />
                </div>
                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                  <h5 class="mb-2">Duplex</h5>
                  <div class="features mb-3">
                    <h6 class="mb-1">Features</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Belcony</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Buth</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Window</span
                    >
                  </div>
                  <div class="facilities mb-3">
                    <h6 class="mb-1">Facilities</h6>
                    <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >wifi</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Telivision</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Ac</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Cleaner</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Hitter</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Micro oven</span
                    >
                  </div>
                  <div class="guest">
                    <h6 class="mb-1">Guest</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >5 Adult</span
                    >
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >6 Children</span
                    >
                  </div>
                  <div class="area">
                    <h6 class="mb-1">Area</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap"
                      >120 &nbsp; Squarefit</span
                    >
                  </div>
                </div>
                <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                  <h6 class="mb-3">
                    <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 12000</span> Per
                    Night
                  </h6>
                  <button
                    onclick="user_status(0,3)"
                    class="btn w-100 custom-bg text-white shadow-none mb-2"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=3" class="btn w-100 btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
            <div class="card mb-4 border-0 shadow">
              <div class="row g-0 align-items-center p-3">
                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                  <img
                    src="http://localhost/hotel/images/rooms/IMG25375.png"
                    alt="rooms"
                    class="img-fluid rounded"
                  />
                </div>
                <div class="col-md-5 px-lg-3 px-md-3 px-0">
                  <h5 class="mb-2">Cupple</h5>
                  <div class="features mb-3">
                    <h6 class="mb-1">Features</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Belcony</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Buth</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Door</span
                    ><span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >Window</span
                    >
                  </div>
                  <div class="facilities mb-3">
                    <h6 class="mb-1">Facilities</h6>
                    <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Telivision</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Ac</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Cleaner</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Hitter</span
                    ><span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                      >Micro oven</span
                    >
                  </div>
                  <div class="guest">
                    <h6 class="mb-1">Guest</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >5 Adult</span
                    >
                    <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                      >5 Children</span
                    >
                  </div>
                  <div class="area">
                    <h6 class="mb-1">Area</h6>
                    <span class="badge rounded-pill bg-light text-dark text-wrap"
                      >200 &nbsp; Squarefit</span
                    >
                  </div>
                </div>
                <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                  <h6 class="mb-3">
                    <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 45654</span> Per
                    Night
                  </h6>
                  <button
                    onclick="user_status(0,4)"
                    class="btn w-100 custom-bg text-white shadow-none mb-2"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=4" class="btn w-100 btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
          </div>
          <!-- Show Rooms -->
        </div>
      </div>
    </template>
  </LayoutView>
</template>

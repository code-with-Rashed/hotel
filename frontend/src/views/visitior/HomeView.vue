<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container-fluid px-lg-4 mt-4">
        <div id="carouselHome" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG96524.png"
                alt="Carousel image"
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG45894.png"
                alt="Carousel image"
              />
            </div>
            <div class="carousel-item active carousel-item-start">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG43122.png"
                alt="Carousel image"
              />
            </div>
            <div class="carousel-item carousel-item-next carousel-item-start">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG60733.png"
                alt="Carousel image"
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG46968.png"
                alt="Carousel image"
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block w-100 img-fluid"
                src="http://localhost/hotel/images/carousel/IMG48604.png"
                alt="Carousel image"
              />
            </div>
          </div>
          <button
            type="button"
            class="carousel-control-prev"
            data-bs-target="#carouselHome"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            type="button"
            class="carousel-control-next"
            data-bs-target="#carouselHome"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <div class="container availability-form">
        <div class="row">
          <div class="col-lg-12 bg-white shadow p-4 rounded">
            <h5 class="mb-4">Check Booking Availability</h5>
            <form action="rooms.php" method="get">
              <input type="hidden" name="check-booking-availability" />
              <div class="row align-items-end">
                <div class="col-lg-3 mb-3">
                  <label class="form-label fw-bold">Check-in</label>
                  <input type="date" class="form-control shadow-none" name="checkin" required="" />
                </div>
                <div class="col-lg-3 mb-3">
                  <label class="form-label fw-bold">Check-out</label>
                  <input type="date" class="form-control shadow-none" name="checkout" required="" />
                </div>
                <div class="col-lg-3 mb-3">
                  <label class="form-label fw-bold">Adult</label>
                  <select class="form-select shadow-none" name="adult" required="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="col-lg-2 mb-3">
                  <label class="form-label fw-bold">Children</label>
                  <select class="form-select shadow-none" name="children" required="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>
                </div>
                <div class="col-lg-1 mb-3">
                  <button type="submit" class="btn text-white dhadow-none custom-bg">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">OUR ROOMS</h2>
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4 g-0">
            <div class="card border-0 shadow" style="max-width: 350px; margin: auto">
              <img
                src="http://localhost/hotel/images/rooms/IMG25375.png"
                alt="card-img"
                class="card-img-top"
              />

              <div class="card-body">
                <h5 class="mb-2 card-title">Cupple</h5>

                <h6 class="mb-3">
                  <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 45654</span> Per
                  Night
                </h6>

                <div class="features mb-4">
                  <h6 class="mb-1">Features</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Belcony</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Buth</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Door</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Window</span
                  >
                </div>

                <div class="facilities mb-4">
                  <h6 class="mb-1">Facilities</h6>
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Telivision</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1">Ac</span>
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Cleaner</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Hitter</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Micro oven</span
                  >
                </div>

                <div class="guest mb-4">
                  <h6 class="mb-1">Guest</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >5 Adult</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >5 Children</span
                  >
                </div>

                <div class="area mb-4">
                  <h6 class="mb-1">Area</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap"
                    >200&nbsp; Squarefit</span
                  >
                </div>
                <div class="rating mb-4">
                  <h6 class="mb-1">Average Rating</h6>
                  <span class="badge bg-light rounded-pill">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                  </span>
                </div>
                <div class="d-flex mb-2 justify-content-evenly">
                  <button
                    onclick="user_status(0 , 4)"
                    class="btn btn-sm custom-bg text-white shadow-none"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=4" class="btn btn-sm btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 g-0">
            <div class="card border-0 shadow" style="max-width: 350px; margin: auto">
              <img
                src="http://localhost/hotel/images/rooms/IMG33142.png"
                alt="card-img"
                class="card-img-top"
              />

              <div class="card-body">
                <h5 class="mb-2 card-title">Duplex</h5>

                <h6 class="mb-3">
                  <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 12000</span> Per
                  Night
                </h6>

                <div class="features mb-4">
                  <h6 class="mb-1">Features</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Belcony</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Buth</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Window</span
                  >
                </div>

                <div class="facilities mb-4">
                  <h6 class="mb-1">Facilities</h6>
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >wifi</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Telivision</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1">Ac</span>
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Cleaner</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Hitter</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Micro oven</span
                  >
                </div>

                <div class="guest mb-4">
                  <h6 class="mb-1">Guest</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >5 Adult</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >6 Children</span
                  >
                </div>

                <div class="area mb-4">
                  <h6 class="mb-1">Area</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap"
                    >120&nbsp; Squarefit</span
                  >
                </div>
                <div class="rating mb-4">
                  <h6 class="mb-1">Average Rating</h6>
                  <span class="badge bg-light rounded-pill">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                  </span>
                </div>
                <div class="d-flex mb-2 justify-content-evenly">
                  <button
                    onclick="user_status(0 , 3)"
                    class="btn btn-sm custom-bg text-white shadow-none"
                  >
                    Book Now
                  </button>
                  <a href="room_details.php?id=3" class="btn btn-sm btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 g-0">
            <div class="card border-0 shadow" style="max-width: 350px; margin: auto">
              <img
                src="http://localhost/hotel/images/rooms/IMG42815.png"
                alt="card-img"
                class="card-img-top"
              />

              <div class="card-body">
                <h5 class="mb-2 card-title">Laxary</h5>

                <h6 class="mb-3">
                  <span class="badge rounded-pill bg-light text-dark text-wrap">৳ 3223</span> Per
                  Night
                </h6>

                <div class="features mb-4">
                  <h6 class="mb-1">Features</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Belcony</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Buth</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Door</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >Window</span
                  >
                </div>

                <div class="facilities mb-4">
                  <h6 class="mb-1">Facilities</h6>
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >wifi</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Telivision</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Cleaner</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Hitter</span
                  >
                  <span class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                    >Micro oven</span
                  >
                </div>

                <div class="guest mb-4">
                  <h6 class="mb-1">Guest</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >4 Adult</span
                  >
                  <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                    >3 Children</span
                  >
                </div>

                <div class="area mb-4">
                  <h6 class="mb-1">Area</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap"
                    >1234&nbsp; Squarefit</span
                  >
                </div>
                <div class="rating mb-4">
                  <h6 class="mb-1">Average Rating</h6>
                  <span class="badge bg-light rounded-pill">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                  </span>
                </div>
                <div class="d-flex mb-2 justify-content-evenly">
                  <button class="btn btn-sm custom-bg text-white shadow-none">Book Now</button>
                  <a href="room_details.php?id=2" class="btn btn-sm btn-outline-dark shadow-none"
                    >More Details</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">OUR FACILITIES</h2>
      <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
          <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
            <img
              src="http://localhost/hotel/images/facilities/IMG81256.svg"
              alt="facilities img"
              width="50px"
            />
            <h5 class="mt-3">Micro oven</h5>
          </div>
          <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
            <img
              src="http://localhost/hotel/images/facilities/IMG77436.svg"
              alt="facilities img"
              width="50px"
            />
            <h5 class="mt-3">Hitter</h5>
          </div>
          <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
            <img
              src="http://localhost/hotel/images/facilities/IMG30732.svg"
              alt="facilities img"
              width="50px"
            />
            <h5 class="mt-3">Cleaner</h5>
          </div>
          <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
            <img
              src="http://localhost/hotel/images/facilities/IMG87388.svg"
              alt="facilities img"
              width="50px"
            />
            <h5 class="mt-3">Ac</h5>
          </div>
          <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
            <img
              src="http://localhost/hotel/images/facilities/IMG96089.svg"
              alt="facilities img"
              width="50px"
            />
            <h5 class="mt-3">Telivision</h5>
          </div>
          <div class="col-md-12 text-center mt-4 my-3">
            <a
              href="facilities.php"
              class="btn btn-sm fw-bold btn-outline-dark shadow-none rounded-0"
              >More Facilities &gt;&gt;&gt;
            </a>
          </div>
        </div>
      </div>

      <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">REACH US</h2>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 bg-white p-4 rounded mb-3 mb-lg-0">
            <iframe
              class="w-100"
              height="320"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b:0xc80b8f06e177fe62!2sNew York, NY, USA!5e0!3m2!1sen!2sbd!4v171"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="bg-white p-4 mb-4 rounded">
              <h5 class="mb-2">Call us</h5>
              <div class="mb-2">
                <a
                  href="tel: +01860491387"
                  class="d-inline-block mb-2 text-decoration-none text-dark"
                >
                  <i class="bi bi-telephone-fill"></i> +01860491387
                </a>
              </div>
              <div class="mb-2">
                <a
                  href="tel: +01921083214"
                  class="d-inline-block mb-2 text-decoration-none text-dark"
                >
                  <i class="bi bi-telephone-fill"></i> +01921083214
                </a>
              </div>
            </div>
            <div class="bg-white p-4 mb-4 rounded">
              <h5>Follow us</h5>
              <a href="https://twitter.com" target="_blank" class="d-inline-block mb-3">
                <span class="badge bg-light text-dark fs-6 p-2">
                  <i class="bi bi-twitter me-1"></i> Twitter
                </span>
              </a>
              <br />
              <a href="https://facebook.com" target="_blank" class="d-inline-block mb-3">
                <span class="badge bg-light text-dark fs-6 p-2">
                  <i class="bi bi-facebook me-1"></i> Facebook
                </span>
              </a>
              <br />
              <a href="https://instagram.com" target="_blank" class="d-inline-block">
                <span class="badge bg-light text-dark fs-6 p-2">
                  <i class="bi bi-instagram me-1"></i> Instagram
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

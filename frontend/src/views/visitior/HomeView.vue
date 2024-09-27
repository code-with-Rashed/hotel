<script setup>
import LayoutView from './layout/LayoutView.vue'
import { ref, onMounted, watch } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { urlBasename } from '@/helpers/urlBasename'
import useCarouselApi from '@/composables/visitor/carouselApi'
import useFacilityApi from '@/composables/visitor/facilityApi'
import useAddressApi from '@/composables/visitor/addressApi'
import useRoomApi from '@/composables/visitor/roomApi'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useShutdownStore } from '@/stores/shutdown'

const { results: carouselResults, get: getCarousel } = useCarouselApi()
const { results: facilityResults, get: getFacility } = useFacilityApi()
const { results: addressResults, get: getAddress } = useAddressApi()
const { results: roomResults, allRoom } = useRoomApi()
const storeUserCredentials = useUserCredentialsStore()
const storeToastMessage = useToastMessageStore()
const router = useRouter()
const storeShutdown = useShutdownStore()

// show all carousel image record
const carouselReloader = ref(true)
const showCarousel = async () => {
  carouselReloader.value = false
  await getCarousel()
  carouselReloader.value = true
}
// -------------------------

// show all room related record
const roomReloader = ref(true)
const showRooms = async () => {
  roomReloader.value = false
  await allRoom()
  roomReloader.value = true
}
// -------------------------
// if any user is logedin ? then access specific routes
const userStatus = (roomId) => {
  if (storeUserCredentials.isUserAuthenticate) {
    router.push({ name: 'confirm-booking', params: { id: roomId } })
  } else {
    storeToastMessage.showToastMessage(true, "Please Login you'r account.", 3000)
  }
}
// -------------------------------
// first time carousel runner
const firstTimeRunCarousel = () => {
  setTimeout(() => {
    document.getElementById('nextCarousel').click()
  }, 3000)
}

watch(
  carouselResults,
  () => {
    firstTimeRunCarousel()
  },
  { once: true }
)
// -------------------------

// show all facility record
const facilityReloader = ref(true)
const showFacilities = async () => {
  facilityReloader.value = false
  await getFacility()
  facilityReloader.value = true
}
// -------------------------

// show address information
const address = ref(null)
const addressReloader = ref(true)
const showAddress = async () => {
  addressReloader.value = false
  await getAddress()
  addressReloader.value = true
  address.value = addressResults.value.data.company_information
}
// ------------------------

onMounted(() => {
  showCarousel()
  showRooms()
  showFacilities()
  showAddress()
})
</script>
<template>
  <LayoutView>
    <template #page>
      <!-- Carousel start -->
      <div class="container-fluid px-lg-4 mt-4">
        <div id="carouselHome" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <template v-if="carouselReloader">
              <template v-if="carouselResults.data">
                <template v-for="(carousel, i) in carouselResults.data.carousel" :key="carousel.id">
                  <div class="carousel-item" :class="{ active: !i }">
                    <img
                      class="d-block w-100 img-fluid"
                      :src="carousel.image"
                      alt="Carousel image"
                    />
                  </div>
                </template>
              </template>
            </template>
            <template v-else>
              <div class="text-center mx-5">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </template>
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
            <span class="carousel-control-next-icon" aria-hidden="true" id="nextCarousel"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <!-- Carousel end -->

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

      <!-- show some rooms start-->
      <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">OUR ROOMS</h2>
      <div class="container">
        <div class="row">
          <template v-if="roomReloader">
            <template v-if="roomResults.data">
              <template v-for="room in roomResults.data.rooms.data" :key="room.id">
                <div class="col-lg-4 col-md-6 mb-4 g-0">
                  <div class="card border-0 shadow" style="max-width: 350px; margin: auto">
                    <img :src="room.images[0].image" alt="card-img" class="card-img-top" />

                    <div class="card-body">
                      <h5 class="mb-2 card-title">{{ room.name }}</h5>

                      <h6 class="mb-3">
                        <span class="badge rounded-pill bg-light text-dark text-wrap"
                          ><strong>&#2547;</strong> {{ room.price }}</span
                        >
                        Per Night
                      </h6>

                      <div class="features mb-4">
                        <h6 class="mb-1">Features</h6>
                        <span
                          class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                          v-for="(feature, i) in room.features"
                          :key="i"
                          >{{ feature.name }}</span
                        >
                      </div>

                      <div class="facilities mb-4">
                        <h6 class="mb-1">Facilities</h6>
                        <span
                          class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                          v-for="(facility, i) in room.facilities"
                          :key="i"
                          >{{ facility.name }}</span
                        >
                      </div>

                      <div class="guest mb-4">
                        <h6 class="mb-1">Guest</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                          >{{ room.adult }} Adult</span
                        >
                        <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                          >{{ room.children }} Children</span
                        >
                      </div>

                      <div class="area mb-4">
                        <h6 class="mb-1">Area</h6>
                        <span class="badge rounded-pill bg-light text-dark text-wrap"
                          >{{ room.area }}&nbsp; Squarefit</span
                        >
                      </div>
                      <div class="rating mb-4">
                        <h6 class="mb-1">Average Rating</h6>
                        <span class="badge bg-light rounded-pill">
                          <i
                            class="bi bi-star-fill text-warning"
                            v-for="s in Math.ceil(room.rating_review_avg_star)"
                            :key="s"
                          ></i>
                        </span>
                      </div>
                      <div class="d-flex mb-2 justify-content-evenly">
                        <button
                          @click="userStatus(room.id)"
                          class="btn btn-sm btn-primary text-white shadow-none"
                          v-if="!storeShutdown.shutdown"
                        >
                          Book Now
                        </button>
                        <RouterLink
                          :to="{ name: 'room-details', params: { id: room.id } }"
                          class="btn btn-sm btn-outline-dark shadow-none"
                          >More Details
                        </RouterLink>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="text-center mx-3">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
      <!-- show some rooms end-->

      <!-- show facility start -->
      <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">OUR FACILITIES</h2>
      <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
          <template v-if="facilityReloader">
            <template v-if="facilityResults.data">
              <template v-for="(facility, i) in facilityResults.data.facilities" :key="facility.id">
                <template v-if="i < 5">
                  <div class="col-lg-2 col-md-2 text-center rounded shadow bg-white py-4 my-3">
                    <img :src="facility.image" alt="facilities img" width="50px" />
                    <h5 class="mt-3">{{ facility.name }}</h5>
                  </div>
                </template>
              </template>
              <div class="col-md-12 text-center mt-4 my-3">
                <RouterLink
                  :to="{ name: 'facilities-page' }"
                  class="btn btn-sm fw-bold btn-outline-dark shadow-none rounded-0"
                >
                  More Facilities <i class="bi bi-chevron-double-right"></i
                ></RouterLink>
              </div>
            </template>
          </template>
          <template v-else>
            <div class="col-12 text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
      <!-- show facility end -->

      <!-- address section start -->
      <section>
        <h2 class="text-center h-fonts mt-5 mb-4 pt-4 fw-bold">REACH US</h2>
        <div class="container">
          <div class="row">
            <template v-if="addressReloader">
              <template v-if="address">
                <div class="col-lg-8 col-md-8 bg-white p-4 rounded mb-3 mb-lg-0">
                  <iframe
                    class="w-100"
                    height="320"
                    :src="address.map"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                  ></iframe>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="bg-white p-4 mb-4 rounded">
                    <h5 class="mb-2">Call us</h5>
                    <div class="mb-2" v-for="(phone, i) in address.phone" :key="i">
                      <a
                        :href="`tel: ${phone}`"
                        class="d-inline-block mb-2 text-decoration-none text-dark"
                      >
                        <i class="bi bi-telephone-fill"></i> {{ phone }}
                      </a>
                    </div>
                  </div>
                  <div class="bg-white p-4 mb-4 rounded">
                    <h5>Follow us</h5>
                    <div class="flex">
                      <a
                        v-for="(social, i) in address.social"
                        :key="i"
                        :href="social"
                        target="_blank"
                        class="m-1 d-inline-block"
                      >
                        <span class="badge bg-light text-dark fs-6 p-2">
                          <i :class="'bi-' + urlBasename(social, 'globe')"></i>
                          <span class="text-capitalize ms-1">{{
                            urlBasename(social, 'social')
                          }}</span>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </template>
            </template>
            <template v-else>
              <div class="col-12 text-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </template>
          </div>
        </div>
      </section>
      <!-- address section end -->
    </template>
  </LayoutView>
  <ToastMessage />
</template>

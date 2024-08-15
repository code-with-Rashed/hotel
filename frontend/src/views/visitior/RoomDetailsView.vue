<script setup>
import LayoutView from './layout/LayoutView.vue'
import { useRoute, useRouter } from 'vue-router'
import { ref, onMounted, watch } from 'vue'
import useRoomApi from '@/composables/visitor/roomApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const { params } = useRoute()
const router = useRouter()
const { results: roomResults, room } = useRoomApi()
const storeToastMessage = useToastMessageStore()
const { isUserAuthenticate } = useUserCredentialsStore()

// if any user is logedin ? then access specific routes
const userStatus = (roomId) => {
  if (isUserAuthenticate) {
    router.push({ name: 'confirm-booking', params: { id: roomId } })
  } else {
    storeToastMessage.showToastMessage(true, "Please Login you'r account.", 3000)
  }
}
// -------------------------------

// show single room related records
const roomDetails = ref(null)
const roomReloader = ref(true)
const showRoom = async () => {
  roomReloader.value = false
  await room(params.id)
  roomDetails.value = roomResults.value.data.room
  roomReloader.value = true
}
// -------------------------

// first time carousel runner
const firstTimeRunCarousel = () => {
  setTimeout(() => {
    document.getElementById('nextCarousel').click()
  }, 2000)
}

watch(
  roomDetails,
  () => {
    firstTimeRunCarousel()
  },
  { once: true }
)
// -------------------------

onMounted(() => {
  showRoom()
})
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row">
          <template v-if="roomReloader">
            <template v-if="roomDetails">
              <!-- breadcrumb & room name -->
              <div class="col-12 mb-4 my-5 px-4">
                <h3 class="fw-bold">{{ roomDetails.name }}</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <RouterLink :to="{ name: 'home-page' }">Home</RouterLink>
                  </li>
                  <li class="breadcrumb-item">
                    <RouterLink :to="{ name: 'rooms-page' }">Rooms</RouterLink>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Room Details</li>
                </ol>
              </div>

              <!-- room image carousel -->
              <div class="col-lg-7 col-md-12 px-4">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    <template v-for="(image, i) in roomDetails.images" :key="i">
                      <div class="carousel-item" data-bs-interval="2000" :class="{ active: !i }">
                        <img :src="image.image" class="d-block w-100 rounded" alt="room img" />
                      </div>
                    </template>
                  </div>
                  <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev"
                  >
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next"
                  >
                    <span
                      class="carousel-control-next-icon"
                      aria-hidden="true"
                      id="nextCarousel"
                    ></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              </div>

              <!-- room details -->
              <div class="col-lg-5 col-md-12 px-3">
                <div class="card mb-4 border-0 shadow-sm p-2">
                  <div class="card-body">
                    <h4 class="mb-3">
                      <strong class="me-1 fs-1">&#2547;</strong>{{ roomDetails.price }} Per Night
                    </h4>
                    <div class="features mb-3">
                      <h6 class="mb-1">Features</h6>
                      <span
                        class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                        v-for="(feature, i) in roomDetails.features"
                        :key="i"
                        >{{ feature.name }}</span
                      >
                    </div>
                    <div class="facilities mb-3">
                      <h6 class="mb-1">Facilities</h6>
                      <span
                        class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                        v-for="(facility, i) in roomDetails.facilities"
                        :key="i"
                        >{{ facility.name }}</span
                      >
                    </div>
                    <div class="guest mb-3">
                      <h6 class="mb-1">Guest</h6>
                      <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                        >{{ roomDetails.adult }} Adult</span
                      >
                      <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                        >{{ roomDetails.children }} Children</span
                      >
                    </div>
                    <div class="area mb-3">
                      <h6 class="mb-1">Area</h6>
                      <span class="badge rounded-pill bg-light text-dark text-wrap"
                        >{{ roomDetails.area }} Squarefit</span
                      >
                    </div>
                    <button
                      class="btn w-100 btn-primary shadow-none mb-1"
                      @click="userStatus(roomDetails.id)"
                    >
                      Book Now
                    </button>
                  </div>
                </div>
              </div>

              <!-- room description -->
              <div class="col-12 mt-4">
                <h5>Description</h5>
                <div>
                  <p>{{ roomDetails.description }}</p>
                </div>
              </div>
            </template>
          </template>
          <template v-else>
            <div class="text-center my-5">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

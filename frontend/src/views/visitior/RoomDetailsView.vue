<script setup>
import LayoutView from './layout/LayoutView.vue'
import { useRoute, useRouter } from 'vue-router'
import { ref, onMounted, watch } from 'vue'
import useRoomApi from '@/composables/visitor/roomApi'
import useRatingReviewApi from '@/composables/visitor/ratingReviewApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import { useShutdownStore } from '@/stores/shutdown'
import { dateFormatter } from '@/helpers/dateTime'

const { params } = useRoute()
const router = useRouter()
const { results: roomResults, room } = useRoomApi()
const { results: ratingReviewResults, get: getRatingReview } = useRatingReviewApi()
const storeToastMessage = useToastMessageStore()
const storeUserCredentials = useUserCredentialsStore()
const storeShutdown = useShutdownStore()

// if any user is logedin ? then access specific routes
const userStatus = (roomId) => {
  if (storeUserCredentials.isUserAuthenticate) {
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

// show rating & review for room
const showRatingReview = async () => {
  await getRatingReview(params.id)
}
// -----------------------------

onMounted(() => {
  showRoom()
  showRatingReview()
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
                    <div class="area mb-3" v-if="roomDetails.rating_review_avg_star">
                      <h6 class="mb-1">Average Rating</h6>
                      <span class="badge rounded-pill bg-light text-dark text-wrap">
                        <i
                          class="bi bi-star-fill text-warning"
                          v-for="s in Math.ceil(roomDetails.rating_review_avg_star)"
                          :key="s"
                        ></i>
                      </span>
                    </div>
                    <button
                      class="btn w-100 btn-primary shadow-none mb-1"
                      @click="userStatus(roomDetails.id)"
                      v-if="!storeShutdown.shutdown"
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
        <!-- Render Rating & Review Start -->
        <template v-if="ratingReviewResults.data && ratingReviewResults.data.rating_review.length">
          <div class="row">
            <div class="col-12 mt-4">
              <h5>Ratings & Riviews</h5>
              <div class="accordion" id="accordionPanelsStayOpenExample">
                <template
                  v-for="(ratingReview, i) in ratingReviewResults.data.rating_review"
                  :key="ratingReview.id"
                >
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button"
                        :class="{ collapsed: i == 0 ? false : true }"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="`#panelsStayOpen-collapse-${i}`"
                        aria-expanded="true"
                        :aria-controls="`panelsStayOpen-collapse-${i}`"
                      >
                        <img
                          :src="ratingReview.user.photo"
                          alt="profile"
                          width="36px"
                          class="rounded-circle"
                        /><strong class="text-dark ms-2">{{ ratingReview.user.name }}</strong>
                      </button>
                    </h2>
                    <div
                      :id="`panelsStayOpen-collapse-${i}`"
                      class="accordion-collapse collapse"
                      :class="{ show: i == 0 ? true : false }"
                    >
                      <div class="accordion-body">
                        <span class="badge rounded-pill bg-light text-dark text-wrap"
                          ><i class="bi bi-calendar3 me-1"></i
                          >{{ dateFormatter(ratingReview.created_at) }}
                        </span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                          <i class="text-primary fw-bold">Ratings : </i>
                          <i
                            class="bi bi-star-fill text-warning"
                            v-for="s in ratingReview.star"
                            :key="s"
                          ></i>
                        </span>
                        <p class="m-3">{{ ratingReview.message }}</p>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </template>
        <!-- Render Rating & Review End -->
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

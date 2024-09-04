<script setup>
import LayoutView from './layout/LayoutView.vue'
import { ref, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import useFacilityApi from '@/composables/visitor/facilityApi'
import useRoomApi from '@/composables/visitor/roomApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import { useShutdownStore } from '@/stores/shutdown'
import { urlSplit } from '@/helpers/urlSplit'

const router = useRouter()
const route = useRoute()
const storeToastMessage = useToastMessageStore()
const storeUserCredentials = useUserCredentialsStore()
const { results: facilityResults, get: getFacility } = useFacilityApi()
const { results: roomResults, allRoom } = useRoomApi()
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

// show all facility record
const facilityReloader = ref(true)
const showFacilities = async () => {
  facilityReloader.value = false
  await getFacility()
  facilityReloader.value = true
}
// -------------------------

// show all room related record
const roomReloader = ref(true)
const showRooms = async () => {
  roomReloader.value = false
  await allRoom(route.query.page)
  roomReloader.value = true
}
// -------------------------

// page switching for pagination
watch(route, () => showRooms())
//------------------------------

onMounted(() => {
  showRooms()
  showFacilities()
})
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
                  <!-- facility listing start -->
                  <div class="bg-light rounded p-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-3 fs-5">FACILITIES</h5>
                      <button type="button" class="btn btn-sm shadow-none btn-warning">
                        Reset
                      </button>
                    </div>
                    <template v-if="facilityReloader">
                      <template v-if="facilityResults.data">
                        <template
                          v-for="facility in facilityResults.data.facilities"
                          :key="facility.id"
                        >
                          <div class="mb-2">
                            <input
                              type="checkbox"
                              :id="`f-${facility.id}`"
                              class="form-check-input me-1"
                              :value="facility.id"
                            />
                            <label
                              class="form-check-label text-capitalize ms-1"
                              :for="`f-${facility.id}`"
                              >{{ facility.name }}</label
                            >
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
                  <!-- facility listing end -->
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
            <template v-if="roomReloader">
              <template v-if="roomResults.data">
                <template v-for="room in roomResults.data.rooms.data" :key="room.id">
                  <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 align-items-center p-3">
                      <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img :src="room.images[0].image" alt="rooms" class="img-fluid rounded" />
                      </div>
                      <div class="col-md-5 px-lg-3 px-md-3 px-0">
                        <h5 class="mb-2">{{ room.name }}</h5>
                        <div class="features mb-3">
                          <h6 class="mb-1">Features</h6>
                          <span
                            class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                            v-for="(feature, i) in room.features"
                            :key="i"
                            >{{ feature.name }}</span
                          >
                        </div>
                        <div class="facilities mb-3">
                          <h6 class="mb-1">Facilities</h6>
                          <span
                            class="badge text-wrap text-dark bg-light rounded-pill me-1 mb-1"
                            v-for="(facility, i) in room.facilities"
                            :key="i"
                            >{{ facility.name }}</span
                          >
                        </div>
                        <div class="guest">
                          <h6 class="mb-1">Guest</h6>
                          <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                            >{{ room.adult }} Adult</span
                          >
                          <span class="badge rounded-pill bg-light text-dark text-wrap me-1 mb-1"
                            >{{ room.children }} Children</span
                          >
                        </div>
                        <div class="area">
                          <h6 class="mb-1">Area</h6>
                          <span class="badge rounded-pill bg-light text-dark text-wrap"
                            >{{ room.area }} &nbsp; Squarefit</span
                          >
                        </div>
                      </div>
                      <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                        <h6 class="mb-3">
                          <span class="badge rounded-pill bg-light text-dark text-wrap"
                            ><strong>&#2547;</strong> {{ room.price }} Per Night</span
                          >
                        </h6>
                        <button
                          type="button"
                          class="btn btn-primary shadow-none w-100 mb-2"
                          @click="userStatus(room.id)"
                          v-if="!storeShutdown.shutdown"
                        >
                          Book Now
                        </button>
                        <RouterLink
                          :to="{ name: 'room-details', params: { id: room.id } }"
                          class="btn btn-outline-dark shadow-none w-100"
                          >More Details
                        </RouterLink>
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
            <!-- pagination template start -->
            <template v-if="roomResults.data">
              <div class="mt-4">
                {{
                  `Showing ${roomResults.data.rooms.from ?? 0} to ${roomResults.data.rooms.to ?? 0} of
                  ${roomResults.data.rooms.total} entries`
                }}
              </div>
              <ul class="pagination mt-2">
                <li class="page-item">
                  <RouterLink
                    :to="{
                      query: {
                        page: urlSplit(roomResults.data.rooms.prev_page_url, '?page=')
                          ? urlSplit(roomResults.data.rooms.prev_page_url, '?page=').pop()
                          : urlSplit(roomResults.data.rooms.first_page_url, '?page=').pop()
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
                        page: urlSplit(roomResults.data.rooms.next_page_url, '?page=')
                          ? urlSplit(roomResults.data.rooms.next_page_url, '?page=').pop()
                          : urlSplit(roomResults.data.rooms.last_page_url, '?page=').pop()
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
          <!-- End Rooms -->
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
</template>

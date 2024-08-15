<script setup>
import LayoutView from './layout/LayoutView.vue'
import { useRoute } from 'vue-router'
import { ref, onMounted, reactive } from 'vue'
import useRoomApi from '@/composables/visitor/roomApi'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const { results: results, confirmRoom } = useRoomApi()
const storeUserCredentials = useUserCredentialsStore()
const { params } = useRoute()

const userInfo = reactive({
  name: '',
  email: '',
  number: '',
  pincode: '',
  address: '',
  check_in: '',
  check_out: ''
})
for (const key in userInfo) {
  userInfo[key] = storeUserCredentials.user[key]
}

// show single room related records
const roomDetails = ref(null)
const roomReloader = ref(true)
const showRoom = async () => {
  roomReloader.value = false
  await confirmRoom(params.id)
  roomDetails.value = results.value.data.room
  roomReloader.value = true
}
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
          <div class="col-12 mb-4 my-5 px-4">
            <h3 class="fw-bold">Confirm Booking</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <RouterLink :to="{ name: 'home-page' }">Home</RouterLink>
              </li>
              <li class="breadcrumb-item">
                <RouterLink :to="{ name: 'rooms-page' }">Rooms</RouterLink>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Confirm Booking</li>
            </ol>
          </div>
          <template v-if="roomReloader">
            <template v-if="roomDetails">
              <div class="col-lg-7 col-md-12 px-3 mb-2">
                <div class="card border-0 shadow-sm p-2">
                  <img
                    :src="roomDetails.images[0].image"
                    class="d-block w-100 rounded"
                    alt="room img"
                  />
                  <div class="m-2">
                    <h6 class="mt-3">{{ roomDetails.name }}</h6>
                    <span class="mb-1">&#2547; {{ roomDetails.price }} Per Night</span>
                  </div>
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
          <div class="col-lg-5 col-md-12 px-3">
            <div class="card mb-4 border-0 shadow-sm p-2">
              <div class="card-body">
                <h6 class="mb-3">Booking Details</h6>
                <form>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Name</label>
                      <input
                        type="text"
                        class="form-control shadow-none mb-3"
                        maxlength="50"
                        required
                        v-model.trim="userInfo.name"
                      />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email</label>
                      <input
                        type="email"
                        readonly
                        class="form-control shadow-none mb-3"
                        required
                        v-model.trim="userInfo.email"
                      />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Phone Number</label>
                      <input
                        type="number"
                        maxlength="15"
                        class="form-control shadow-none mb-3"
                        required
                        v-model.trim="userInfo.number"
                      />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Pincode</label>
                      <input
                        type="text"
                        class="form-control shadow-none mb-3"
                        maxlength="20"
                        required
                        v-model.trim="userInfo.pincode"
                      />
                    </div>
                    <div class="col-12">
                      <label class="form-label">Address</label>
                      <textarea
                        rows="1"
                        class="form-control shadow-none mb-3"
                        required
                        maxlength="255"
                        v-model.trim="userInfo.address"
                      ></textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                      <label class="form-label">Check-in</label>
                      <input
                        type="date"
                        class="form-control shadow-none"
                        required
                        v-model="userInfo.check_in"
                      />
                    </div>
                    <div class="col-md-6 mb-4">
                      <label class="form-label">Check-out</label>
                      <input
                        type="date"
                        class="form-control shadow-none"
                        required
                        v-model="userInfo.check_out"
                      />
                    </div>
                    <div class="col-12">
                      <h6 class="text-danger mb-3" id="date_info">
                        Provide Check-in &amp; Check-out date !
                      </h6>
                      <button
                        type="submit"
                        class="btn w-100 btn-primary text-white shadow-none"
                        disabled
                      >
                        Payment
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

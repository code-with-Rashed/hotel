<script setup>
import LayoutView from './layout/LayoutView.vue'
import { useRoute } from 'vue-router'
import { ref, onMounted, reactive } from 'vue'
import useRoomApi from '@/composables/visitor/roomApi'
import useBookingInformationApi from '@/composables/visitor/bookingInformation'
import { useUserCredentialsStore } from '@/stores/userCredentials'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const { results, confirmRoom } = useRoomApi()
const { results: bookingInfoResult, checkBookingInfo } = useBookingInformationApi()
const storeUserCredentials = useUserCredentialsStore()
const { params } = useRoute()
const storeToastMessage = useToastMessageStore()

// set logedin user info
const userInfo = reactive({
  name: '',
  email: '',
  number: '',
  address: ''
})
for (const key in userInfo) {
  userInfo[key] = storeUserCredentials.user[key]
}
//---------------------

// handle date wise message & booking summary
const dateValidationMessage = ref('Provide Check-in & Check-out date !')
const bookingSummary = ref()
// ------------------

// payment button status
const active = ref(false)
// ----------------------------

// booking information
const bookingInfo = reactive({
  checkin: '',
  checkout: '',
  total_day: '',
  room_id: params.id,
  room_name: '',
  price: '',
  total_pay: ''
})
//--------------------

// compare checkin & checkout date
const compareDate = () => {
  active.value = false // payment button is in-active now
  bookingSummary.value = '' // remove booking summary message. if user is compare date.

  const today = new Date()
  const format = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`

  if (bookingInfo.checkin != '' && bookingInfo.checkout != '') {
    if (bookingInfo.checkin == bookingInfo.checkout) {
      dateValidationMessage.value = 'You cannot Check-out of same day !'
    } else if (new Date(bookingInfo.checkin) < new Date(format)) {
      dateValidationMessage.value = "Check-in date is earlier than Today's date !"
    } else if (bookingInfo.checkout < bookingInfo.checkin) {
      dateValidationMessage.value = 'Check-out date is earlier than Check-in date !'
    } else {
      dateValidationMessage.value = ''
      bookingInfo.total_day =
        new Date(bookingInfo.checkout).getDate() - new Date(bookingInfo.checkin).getDate()
      prepareBookingInfo()
    }
  }
}
// -------------------------------

// prepare booking information
const prepareBookingInfo = async () => {
  bookingInfo.room_name = roomDetails.value.name
  bookingInfo.price = roomDetails.value.price
  bookingInfo.total_pay = Number(bookingInfo.price) * Number(bookingInfo.total_day)
  checkBookingInformation()
}
// ----------------------------------------

// check booking info is valid & room is available
const reloader = ref(true)
const checkBookingInformation = async () => {
  reloader.value = false
  await checkBookingInfo(bookingInfo)
  reloader.value = true
  if (bookingInfoResult.value.success) {
    bookingSummary.value = `No. of Days : ${bookingInfo.total_day}<br>Total Amount to Pay : ${bookingInfo.total_pay} <strong class="fs-5">&#2547;</strong>` // display booking summary
    active.value = true // active payment button
  } else if (!bookingInfoResult.value.success) {
    let message = ''
    message += '<strong>' + bookingInfoResult.value.message + '</strong><br>'
    bookingInfoResult.value.data.forEach((element) => {
      message += element + '<br>'
    })
    storeToastMessage.showToastMessage(bookingInfoResult.value.success, message, 10000)
  }
}
// -----------------------------------------------

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
                      <label class="form-label">Phone Number</label>
                      <input
                        type="number"
                        maxlength="15"
                        class="form-control shadow-none mb-3"
                        required
                        v-model.trim="userInfo.number"
                      />
                    </div>
                    <div class="col-12">
                      <label class="form-label">Email</label>
                      <input
                        type="email"
                        readonly
                        class="form-control shadow-none mb-3"
                        required
                        v-model.trim="userInfo.email"
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
                        v-model="bookingInfo.checkin"
                        @change="compareDate"
                      />
                    </div>
                    <div class="col-md-6 mb-4">
                      <label class="form-label">Check-out</label>
                      <input
                        type="date"
                        class="form-control shadow-none"
                        required
                        v-model="bookingInfo.checkout"
                        @change="compareDate"
                      />
                    </div>
                    <div class="col-12">
                      <div class="text-danger mb-3" v-if="dateValidationMessage">
                        {{ dateValidationMessage }}
                      </div>
                      <template v-if="reloader">
                        <div
                          class="text-primary mb-3"
                          v-if="bookingSummary"
                          v-html="bookingSummary"
                        ></div>
                      </template>
                      <template v-else>
                        <div class="text-center mb-3">
                          <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                      </template>
                      <button
                        type="button"
                        class="btn w-100 shadow-none"
                        :disabled="!active"
                        :class="{ 'btn-primary': active, 'btn-secondary': !active }"
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
  <ToastMessage />
</template>

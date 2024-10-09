<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import useUserApi from '@/composables/admin/userApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { urlSplit } from '@/helpers/urlSplit'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'

const route = useRoute()
const { results, errors, get, userStatus, userDetails } = useUserApi()
const storeToastMessage = useToastMessageStore()

// update user status
const updateUserStatus = async (id) => {
  await userStatus(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await userRecords()
}
//------------------------------

// show user activity details
const userDetailsRecord = ref(null)
const showUserDetails = async (userid) => {
  await userDetails(userid)
  if (results.value.success) {
    userDetailsRecord.value = results.value.data?.details
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//------------------------------

// get all user records
const userRecordResults = ref(null)
const reloader = ref(true)
const userRecords = async () => {
  reloader.value = false
  await get(route.query.page)
  reloader.value = true
  if (results.value.success) {
    userRecordResults.value = results.value.data.users
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
onMounted(() => userRecords())
//--------------------------

// page switching for pagination
watch(route, () => userRecords())
//------------------------------
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>User Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">User Records</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="userRecords">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addRoomModal"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row px-3">
              <div class="table-responsive-lg">
                <table class="table border table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Status</th>
                      <th>Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <template v-if="reloader">
                      <template v-if="userRecordResults">
                        <template v-for="user in userRecordResults.data" :key="user.id">
                          <tr>
                            <td>{{ user.id }}</td>
                            <td>
                              <img
                                :src="user.photo"
                                alt="photo"
                                class="rounded rounded-circle"
                                width="40"
                              />
                            </td>
                            <td>{{ user.name }}</td>
                            <td>
                              <strong>Email : </strong>{{ user.email }}
                              <span
                                class="badge bg-primary"
                                v-if="user.email_verified_at"
                                title="This emeil is verified"
                                >verified</span
                              >
                              <span class="badge bg-info" v-else title="This email is unverified"
                                >unverified</span
                              >
                              <br />
                              <strong>Number : </strong>{{ user.number }}
                            </td>
                            <td>
                              <strong>Pincode : </strong>{{ user.pincode }}
                              <br />
                              <strong>Address : </strong>{{ user.address }}
                            </td>
                            <td>
                              <button
                                class="btn btn-sm shadow-none btn-primary"
                                @click="updateUserStatus(user.id)"
                                v-if="user.status"
                              >
                                Aactive
                              </button>
                              <button
                                class="btn btn-sm shadow-none btn-warning"
                                @click="updateUserStatus(user.id)"
                                v-else
                              >
                                Inactive
                              </button>
                            </td>
                            <td>
                              <button
                                type="button"
                                class="btn btn-sm shadow-none btn-primary"
                                title="Details"
                                data-bs-toggle="modal"
                                data-bs-target="#userActivityDetailsModal"
                                @click="showUserDetails(user.id)"
                              >
                                <i class="bi bi-file-break"></i>
                              </button>
                            </td>
                          </tr>
                        </template>
                      </template>
                    </template>
                    <template v-else>
                      <tr class="text-center">
                        <td colspan="7">
                          <div class="spinner-border my-4" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
                <!-- pagination template start -->
                <template v-if="userRecordResults">
                  <span>{{
                    `Showing ${userRecordResults.from ?? 0} to ${userRecordResults.to ?? 0} of
                    ${userRecordResults.total} entries`
                  }}</span>
                  <ul class="pagination mt-2">
                    <li class="page-item">
                      <RouterLink
                        :to="{
                          query: {
                            page: urlSplit(userRecordResults.prev_page_url, '?page=')
                              ? urlSplit(userRecordResults.prev_page_url, '?page=').pop()
                              : urlSplit(userRecordResults.first_page_url, '?page=').pop()
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
                            page: urlSplit(userRecordResults.next_page_url, '?page=')
                              ? urlSplit(userRecordResults.next_page_url, '?page=').pop()
                              : urlSplit(userRecordResults.last_page_url, '?page=').pop()
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
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />
  <!-- User Activity Details Modal Start -->
  <div
    class="modal fade"
    id="userActivityDetailsModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">User Activity Details</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <template v-if="userDetailsRecord && userDetailsRecord.length">
            <div class="accordion" id="accordionPanelsStayOpenExample">
              <template v-for="(details, i) in userDetailsRecord" :key="details.id">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button
                      class="accordion-button bg-primary text-white"
                      :class="{ collapsed: i == 0 ? false : true }"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="`#panelsStayOpen-collapse-${i}`"
                      aria-expanded="true"
                      :aria-controls="`panelsStayOpen-collapse-${i}`"
                    >
                      User Booking Details
                    </button>
                  </h2>
                  <div
                    :id="`panelsStayOpen-collapse-${i}`"
                    class="accordion-collapse collapse"
                    :class="{ show: i == 0 ? true : false }"
                  >
                    <div class="accordion-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <strong>Order ID : </strong>{{ details.id }}
                        </li>
                        <li class="list-group-item">
                          <strong>Transection ID : </strong>{{ details.tran_id }}
                        </li>
                        <li class="list-group-item">
                          <strong>Booking Status : </strong
                          >{{ details.booking_status.toUpperCase() }}
                        </li>
                        <li class="list-group-item">
                          <strong>Transection Status : </strong
                          >{{ details.tran_status.toUpperCase() }}
                        </li>
                        <li class="list-group-item">
                          <strong>Arrival Status : </strong
                          >{{ details.arrival ? 'arrived' : 'not arrived' }}
                        </li>
                        <li class="list-group-item">
                          <strong>Room Name : </strong>{{ details.booking_details.room_name }}
                        </li>
                        <li class="list-group-item">
                          <strong>Room Ratings : </strong>{{ details.booking_details.rating }}
                        </li>
                        <li class="list-group-item">
                          <strong>Room No : </strong
                          >{{ details.booking_details.room_no ?? 'not assign' }}
                        </li>
                        <li class="list-group-item">
                          <strong>Checkin : </strong>{{ dateFormatter(details.checkin) }}
                        </li>
                        <li class="list-group-item">
                          <strong>Checkin : </strong>{{ dateFormatter(details.checkout) }}
                        </li>
                        <li class="list-group-item">
                          <strong>Order Date : </strong>{{ dateFormatter(details.created_at) }} |
                          {{ timeFormatter(details.created_at) }}
                        </li>
                        <li class="list-group-item">
                          <strong>Cost : </strong>{{ details.booking_details.price }}
                          {{ details.currency }} per night.
                        </li>
                        <li class="list-group-item">
                          <strong>Total Cost : </strong>{{ details.booking_details.total_pay }}
                          {{ details.currency }}
                        </li>
                        <li class="list-group-item">
                          <strong>User Name : </strong>{{ details.booking_details.user_name }}
                        </li>
                        <li class="list-group-item">
                          <strong>User Email : </strong>{{ details.booking_details.email }}
                        </li>
                        <li class="list-group-item">
                          <strong>User Phone : </strong>{{ details.booking_details.phone }}
                        </li>
                        <li class="list-group-item">
                          <strong>User Address : </strong>{{ details.booking_details.address }}
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
  <!-- User Actibity Details Modal End -->
</template>

<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref, watch } from 'vue'
import useRatingReviewApi from '@/composables/admin/ratingReviewApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { urlSplit } from '@/helpers/urlSplit'
import { useRoute } from 'vue-router'
import { dateFormatter, timeFormatter } from '@/helpers/dateTime'

const route = useRoute()
const { results, errors, get, put, destroy } = useRatingReviewApi()
const storeToastMessage = useToastMessageStore()

// show all rating & review record
const reloader = ref(true)
const showRatingReviewRecord = async () => {
  reloader.value = false
  await get(route.query.page)
  reloader.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
onMounted(() => showRatingReviewRecord())
// ------------------------------

// page switching for pagination
watch(route, () => showRatingReviewRecord())
//------------------------------

// update rating & review status
const updateRatingReviewStatus = async (id) => {
  await put(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
  await showRatingReviewRecord()
}
//------------------------------

// delete Rating & Review
const deleteId = ref(null)
const setDeleteId = (id) => {
  deleteId.value = id
}
const deleteNow = async () => {
  await destroy(deleteId.value)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  await showRatingReviewRecord()
}
// -----------------------
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Ratings & Reviews Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Rating & Review List</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="showRatingReviewRecord">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th width="5%">No.</th>
                    <th>Roomname</th>
                    <th>Username</th>
                    <th>Message</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template
                        v-for="rating_review in results.data.ratings_reviews.data"
                        :key="rating_review.id"
                      >
                        <tr>
                          <td>{{ rating_review.id }}</td>
                          <td>{{ rating_review.room.name }}</td>
                          <td>{{ rating_review.user.name }}</td>
                          <td>{{ rating_review.message }}</td>
                          <td>
                            {{ dateFormatter(rating_review.created_at) }} |
                            {{ timeFormatter(rating_review.created_at) }}
                          </td>
                          <td>
                            <Button
                              class="btn btn-sm btn-success rounded shadow-none m-1"
                              v-if="rating_review.seen"
                              @click="updateRatingReviewStatus(rating_review.id)"
                              ><i class="bi bi-eye"></i> Active</Button
                            >
                            <Button
                              class="btn btn-sm btn-warning rounded shadow-none m-1"
                              v-else
                              @click="updateRatingReviewStatus(rating_review.id)"
                              ><i class="bi bi-eye"></i> In-Active</Button
                            >
                            <Button
                              class="btn btn-sm btn-danger rounded shadow-none m-1"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteRatingReviewModal"
                              @click="setDeleteId(rating_review.id)"
                              ><i class="bi bi-trash"></i> Delete</Button
                            >
                          </td>
                        </tr>
                      </template>
                    </template>
                  </template>
                  <template v-else>
                    <tr class="text-center">
                      <td colspan="6">
                        <div class="spinner-border my-4" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <!-- pagination template start -->
              <template v-if="results.data">
                <span>{{
                  `Showing ${results.data.ratings_reviews.from ?? 0} to ${results.data.ratings_reviews.to ?? 0} of
                  ${results.data.ratings_reviews.total} entries`
                }}</span>
                <ul class="pagination mt-2">
                  <li class="page-item">
                    <RouterLink
                      :to="{
                        query: {
                          page: urlSplit(results.data.ratings_reviews.prev_page_url, '?page=')
                            ? urlSplit(results.data.ratings_reviews.prev_page_url, '?page=').pop()
                            : urlSplit(results.data.ratings_reviews.first_page_url, '?page=').pop()
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
                          page: urlSplit(results.data.ratings_reviews.next_page_url, '?page=')
                            ? urlSplit(results.data.ratings_reviews.next_page_url, '?page=').pop()
                            : urlSplit(results.data.ratings_reviews.last_page_url, '?page=').pop()
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
    </template>
  </LayoutView>
  <ToastMessage />
  <!-- Delete Rating & Review Modal Start -->
  <div class="modal fade" id="deleteRatingReviewModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <strong>Are You Sure You Wan't to Delete this Rating & Review ?</strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="deleteNow">
            Yes
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Rating & Review Modal End -->
</template>

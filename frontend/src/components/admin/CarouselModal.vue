<script setup>
import { ref, watch } from 'vue'
import useCarouselApi from '@/composables/admin/carouselApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  editCarouselId: Number,
  deleteCarouselId: Number
})

const { results, errors, post, show, put, destroy } = useCarouselApi()
const storeToastMessage = useToastMessageStore()

// handle carousel image
const carouselImage = ref()
const showCarouselImage = ref()
const selectCarouselImage = (event) => {
  carouselImage.value = event.target.files[0]
  showCarouselImage.value = URL.createObjectURL(carouselImage.value)
}
//------------------------

// add carousel record
const addCarouselSubmitBtn = ref(true)
const postCarouselRecord = async () => {
  addCarouselSubmitBtn.value = false
  await post(carouselImage)
  addCarouselSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('addCarouselModal')
    carouselImage.value = null
    showCarouselImage.value = null
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//-------------------

// handle update & delete instruction for carousel image record
const currentEditCarouselId = ref()
watch(props, (foundedIds) => {
  if (foundedIds.editCarouselId && foundedIds.editCarouselId != currentEditCarouselId.value) {
    getCarouselRecord(foundedIds.editCarouselId)
  }
  currentEditCarouselId.value = foundedIds.editCarouselId
  currentDeleteCarouselId.value = foundedIds.deleteCarouselId
})
//----------------

// get single carousel image record
const getCarouselRecord = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    showCarouselImage.value = results.value.data.carousel.image
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// ----------------------------------

// update carousel record
const updateCarouselSubmitBtn = ref(true)

const updateCarouselRecord = async () => {
  updateCarouselSubmitBtn.value = false
  await put(currentEditCarouselId.value, carouselImage)
  updateCarouselSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editCarouselModal')
    carouselImage.value = null
    showCarouselImage.value = null
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//--------------------------

// delete facility record
const currentDeleteCarouselId = ref()
const deleteCarouselSubmitBtn = ref(true)

const deleteCarouselRecord = async () => {
  deleteCarouselSubmitBtn.value = false
  await destroy(currentDeleteCarouselId.value)
  deleteCarouselSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteCarouselModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//---------------------
</script>
<template>
  <!-- add carousel record modal start -->
  <div
    class="modal fade"
    id="addCarouselModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form @submit.prevent="postCarouselRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Carousel Image</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="carousel_picture">Carousel Picture</label>
              <input
                type="file"
                id="carousel_picture"
                class="form-control shadow-none"
                title="Enter a new Carousel Picture"
                accept="image/*"
                required
                @change="selectCarouselImage"
              />
            </div>
            <div class="mb-3" v-if="showCarouselImage">
              <img :src="showCarouselImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="addCarouselSubmitBtn"
            >
              SUBMIT
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status"> Proccssing...</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- add carousel record modal end -->

  <!-- edit carousel record modal start -->
  <div
    class="modal fade"
    id="editCarouselModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateCarouselRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Update Carousel Image</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="carousel_picture">Carousel Picture</label>
              <input
                type="file"
                id="carousel_picture"
                class="form-control shadow-none"
                title="Enter another Carousel Picture"
                accept="image/*"
                required
                @change="selectCarouselImage"
              />
            </div>
            <div class="mb-3" v-if="showCarouselImage">
              <img :src="showCarouselImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateCarouselSubmitBtn"
            >
              UPDATE
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status"> Proccssing...</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- edit carousel record modal end -->

  <!-- delete carousel modal start -->
  <div
    class="modal fade"
    id="deleteCarouselModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Delete Carousel Image Record</h5>
          <button
            type="button"
            class="btn-close shadow-none"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <p class="fw-bold text-center text-danger">
              Are you sure ? you wan't to delete this carousel image !
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-danger text-white shadow-none"
            @click="deleteCarouselRecord"
            v-if="deleteCarouselSubmitBtn"
          >
            DELETE
          </button>
          <button class="btn btn-primary" type="button" disabled v-else>
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status"> Proccssing...</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- delete carousel modal end -->
  <ToastMessage />
</template>

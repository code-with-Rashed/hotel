<script setup>
import LayoutView from './layout/LayoutView.vue'
import CarouselModal from '@/components/admin/CarouselModal.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useCarouselApi from '@/composables/admin/carouselApi'

const storeToastMessage = useToastMessageStore()
const { results, errors, get } = useCarouselApi()

// send instruction props
const instruction = ref('')

// send carousel id to child (CarouselModal) component for editing by carousel record
const editCarouselId = ref(0)
const editCarousel = (id) => {
  editCarouselId.value = id
  instruction.value = 'show'
}

// send carousel id to child (CarouselModal) component for deleting by carousel record
const deleteCarouselId = ref(0)
const deleteCarousel = (id) => {
  deleteCarouselId.value = id
  instruction.value = 'delete'
}

// get all carousel image record
const reloader = ref(true)
const carouselRecord = async () => {
  reloader.value = false
  await get()
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
onMounted(() => carouselRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Carousel Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Carousel Images</h5>
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="carouselRecord"
                title="Reload carousel image record list ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addCarouselModal"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row">
              <template v-if="reloader">
                <template v-if="results.data">
                  <template v-for="carousel in results.data.carousel" :key="carousel.id">
                    <div class="col-md-4 mb-4">
                      <div class="card bg-dark text-white">
                        <img class="card-img" :src="carousel.image" alt="team image" />
                        <div class="card-img-overlay text-end">
                          <button
                            class="btn btn-primary btn-sm shadow-none card-title mx-1"
                            type="button"
                            data-bs-target="#editCarouselModal"
                            data-bs-toggle="modal"
                            @click="editCarousel(carousel.id)"
                          >
                            <i class="bi bi-pencil-square"></i> Edit
                          </button>
                          <button
                            class="btn btn-danger btn-sm shadow-none card-title"
                            type="button"
                            data-bs-target="#deleteCarouselModal"
                            data-bs-toggle="modal"
                            @click="deleteCarousel(carousel.id)"
                          >
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>
                      </div>
                    </div>
                  </template>
                </template>
              </template>
              <template v-else>
                <div class="d-flex justify-content-center my-3">
                  <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <CarouselModal
    :editCarousel-id="editCarouselId"
    :deleteCarousel-id="deleteCarouselId"
    :instruction="instruction"
  />
  <ToastMessage />
</template>

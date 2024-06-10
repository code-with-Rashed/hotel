<script setup>
import LayoutView from './layout/LayoutView.vue'
import CarouselModal from '@/components/admin/CarouselModal.vue'
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
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#carousel-s"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row" id="carousel-data">
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG96524.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG45894.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG43122.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG60733.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG46968.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                  <img
                    class="card-img"
                    src="http://localhost/hotel/images/carousel/IMG48604.png"
                    alt="team image"
                  />
                  <div class="card-img-overlay text-end">
                    <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <CarouselModal />
</template>

<script setup>
import LayoutView from './layout/LayoutView.vue'
import FacilitiesModal from '@/components/admin/FacilitiesModal.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Facility Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Facilities</h5>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#facility-s"
              >
                <i class="bi bi-plus-square"></i>
                Add Facility
              </button>
            </div>
            <div class="row mt-5" id="facilitie-data">
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG51592.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">wifi</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG96089.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">Telivision</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG87388.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">Ac</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG30732.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">Cleaner</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG77436.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">Hitter</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                  <div class="mb-1 text-end">
                    <button class="btn btn-danger btn-sm shadow-none" type="button">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <img
                      src="http://localhost/hotel/images/facilities/IMG81256.svg"
                      alt="facilities"
                      width="40px"
                    />
                    <h5 class="m-0 ms-3">Micro oven</h5>
                  </div>
                  <p class="card-title">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur minus dicta
                    error. Minus repudiandae optio voluptas.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <FacilitiesModal />
</template>

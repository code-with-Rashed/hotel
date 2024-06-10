<script setup>
import LayoutView from './layout/LayoutView.vue'
import SettingsModal from '@/components/admin/SettingsModal.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Settings Management</h3>
        <!-- Genarel Settings -->
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">General Settings</h5>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#general-s"
              >
                <i class="bi bi-pencil-square"></i>
                Edit
              </button>
            </div>
            <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
            <p class="card-text" id="site_title">My Hotel</p>
            <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
            <p class="card-text" id="site_about">
              About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error
              voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem
              ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus
            </p>
          </div>
        </div>
        <!-- Favicon Settings -->
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Fav Icon</h5>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#favicon-s"
              >
                <i class="bi bi-pencil-square"></i>
                Edit
              </button>
            </div>
            <div class="m-3" id="favicon">
              <img
                src="http://localhost/hotel/images/favicon/IMG41746.png"
                alt="favicon"
                width="50px"
                title="favicon"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Shutdown Settings -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Shutdown Website</h5>
            <div class="form-check form-switch">
              <form>
                <input type="checkbox" title="Shutdown Button" class="form-check-input" checked />
              </form>
            </div>
          </div>
          <p class="card-text">
            No customers will be allowed to book hotel room, when shutdown mode is turned on.
          </p>
        </div>
      </div>

      <!-- Team Settings -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Team Management</h5>
            <!-- Button trigger modal -->
            <button
              type="button"
              class="btn btn-dark btn-sm shadow-none"
              data-bs-toggle="modal"
              data-bs-target="#team-s"
            >
              <i class="bi bi-plus-square"></i>
              Add
            </button>
          </div>
          <div class="row" id="team-data">
            <div class="col-md-2 mb-4">
              <div class="card bg-dark text-white">
                <img
                  class="card-img"
                  src="http://localhost/hotel/images/about/IMG26969.png"
                  alt="team image"
                />
                <div class="card-img-overlay text-end">
                  <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </div>
                <p class="card-text px-3 py-2 text-center">Rashed alam</p>
              </div>
            </div>
            <div class="col-md-2 mb-4">
              <div class="card bg-dark text-white">
                <img
                  class="card-img"
                  src="http://localhost/hotel/images/about/IMG89419.png"
                  alt="team image"
                />
                <div class="card-img-overlay text-end">
                  <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </div>
                <p class="card-text px-3 py-2 text-center">Kethrin</p>
              </div>
            </div>
            <div class="col-md-2 mb-4">
              <div class="card bg-dark text-white">
                <img
                  class="card-img"
                  src="http://localhost/hotel/images/about/IMG14983.png"
                  alt="team image"
                />
                <div class="card-img-overlay text-end">
                  <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </div>
                <p class="card-text px-3 py-2 text-center">Mujahid islam</p>
              </div>
            </div>
            <div class="col-md-2 mb-4">
              <div class="card bg-dark text-white">
                <img
                  class="card-img"
                  src="http://localhost/hotel/images/about/IMG55395.png"
                  alt="team image"
                />
                <div class="card-img-overlay text-end">
                  <button class="btn btn-danger btn-sm shadow-none card-title" type="button">
                    <i class="bi bi-trash"></i> Delete
                  </button>
                </div>
                <p class="card-text px-3 py-2 text-center">Menila</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <SettingsModal />
</template>

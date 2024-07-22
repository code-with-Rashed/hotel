<script setup>
import LayoutView from './layout/LayoutView.vue'
import SettingsModal from '@/components/admin/SettingsModal.vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import useSettingsApi from '@/composables/admin/settingsApi'
import { ref, onMounted } from 'vue'

const storeToastMessage = useToastMessageStore()
const { results, errors, get, shutdown } = useSettingsApi()

// fetch site settings record
const settingsResult = ref(null)
const settingsResultReloader = ref(true)

const getSettingsData = async () => {
  settingsResultReloader.value = false
  await get()
  settingsResult.value = results.value
  settingsResultReloader.value = true

  if (settingsResult.value.success) {
    storeToastMessage.showToastMessage(settingsResult.value.success, settingsResult.value.message)
  } else {
    storeToastMessage.showToastMessage(settingsResult.value.success, settingsResult.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// --------------------------

// the web shutdown or running proccess
const shutdownResult = ref(null)
const shutdownProccess = async () => {
  await shutdown()
  shutdownResult.value = results.value
  if (shutdownResult.value.success) {
    storeToastMessage.showToastMessage(shutdownResult.value.success, shutdownResult.value.message)
  } else {
    storeToastMessage.showToastMessage(shutdownResult.value.success, shutdownResult.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// -----------------------------------

onMounted(() => {
  getSettingsData()
})
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
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="getSettingsData"
                title="Reload settings record ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#editSettingsRecordModal"
              >
                <i class="bi bi-pencil-square"></i>
                Edit
              </button>
            </div>
            <div v-if="settingsResultReloader">
              <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
              <p class="card-text" id="site_about" v-if="settingsResult">
                {{ settingsResult.data.setting.description }}
              </p>
            </div>
            <div v-else>
              <div class="d-flex justify-content-center my-3">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Shutdown Settings -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Shutdown Website</h5>
              <div class="form-check form-switch" v-if="settingsResult">
                <input
                  type="checkbox"
                  title="Shutdown Button"
                  class="form-check-input"
                  :checked="settingsResult.data.setting.shutdown"
                  @change="shutdownProccess"
                />
              </div>
            </div>
            <p class="card-text">
              No customers will be allowed to book hotel room, when shutdown mode is turned on.
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
  <ToastMessage />
</template>

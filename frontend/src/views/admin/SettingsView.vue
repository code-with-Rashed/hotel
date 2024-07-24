<script setup>
import LayoutView from './layout/LayoutView.vue'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import useSettingsApi from '@/composables/admin/settingsApi'
import useFaviconApi from '@/composables/admin/faviconApi'
import useLogoApi from '@/composables/admin/logoApi'
import { hideBsModal } from '@/helpers/hideBsModal'
import { ref, onMounted, reactive } from 'vue'

const storeToastMessage = useToastMessageStore()
const { results, errors, get, shutdown, put } = useSettingsApi()

// update site description
const siteDescription = reactive({
  description: ''
})

const updateSettingsBtn = ref(true)
const updateSettings = async () => {
  updateSettingsBtn.value = false
  await put(siteDescription)
  updateSettingsBtn.value = true
  if (results.value.success) {
    hideBsModal('editSettingsRecordModal')
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
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
// ----------------

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
    siteDescription.description = settingsResult.value.data.setting.description
  } else {
    storeToastMessage.showToastMessage(settingsResult.value.success, settingsResult.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// --------------------------

// the web shutdown or running proccess
const shutdownProccess = async () => {
  await shutdown()
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// -----------------------------------

// manage favicon
const {
  results: faviconResults,
  errors: faviconErrors,
  get: getFavicon,
  put: updateFavicon
} = useFaviconApi()
const favicon = ref(null)

// fetch favicon
const faviconResultReloader = ref(true)
const getFaviconData = async () => {
  faviconResultReloader.value = false
  await getFavicon()
  faviconResultReloader.value = true
  if (faviconResults.value.success) {
    favicon.value = faviconResults.value.data.favicon.icon
    storeToastMessage.showToastMessage(faviconResults.value.success, faviconResults.value.message)
  } else {
    storeToastMessage.showToastMessage(faviconResults.value.success, faviconResults.value.message)
  }
  if (faviconErrors.value) {
    storeToastMessage.showToastMessage(false, faviconErrors.value.message)
  }
}
// -------------

// update favicon record
const newFavicon = ref(null)
const selectFavicon = (event) => {
  newFavicon.value = event.target.files[0]
  favicon.value = URL.createObjectURL(newFavicon.value)
}
const updateFaviconBtn = ref(true)
const updateFaviconRecord = async () => {
  updateFaviconBtn.value = false
  await updateFavicon(newFavicon)
  updateFaviconBtn.value = true
  if (faviconResults.value.success) {
    hideBsModal('updateFavicon')
    storeToastMessage.showToastMessage(faviconResults.value.success, faviconResults.value.message)
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(faviconResults.value.success, message, 10000)
  }
  if (faviconErrors.value) {
    storeToastMessage.showToastMessage(false, faviconErrors.value.message)
  }
}
//---------------------

// manage logo
const { results: logoResults, errors: logoErrors, get: getLogo, put: updateLogo } = useLogoApi()
const logo = ref(null)

// fetch logo
const logoResultReloader = ref(true)
const getLogoData = async () => {
  logoResultReloader.value = false
  await getLogo()
  logoResultReloader.value = true
  if (logoResults.value.success) {
    logo.value = logoResults.value.data.logo.logo
    storeToastMessage.showToastMessage(logoResults.value.success, logoResults.value.message)
  } else {
    storeToastMessage.showToastMessage(logoResults.value.success, logoResults.value.message)
  }
  if (logoErrors.value) {
    storeToastMessage.showToastMessage(false, logoErrors.value.message)
  }
}
// -------------

// update logo record
const newLogo = ref(null)
const selectLogo = (event) => {
  newLogo.value = event.target.files[0]
  logo.value = URL.createObjectURL(newLogo.value)
}
const updateLogoBtn = ref(true)
const updateLogoRecord = async () => {
  updateLogoBtn.value = false
  await updateLogo(newLogo)
  updateLogoBtn.value = true
  if (logoResults.value.success) {
    hideBsModal('updateLogo')
    storeToastMessage.showToastMessage(logoResults.value.success, logoResults.value.message)
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(logoResults.value.success, message, 10000)
  }
  if (logoErrors.value) {
    storeToastMessage.showToastMessage(false, logoErrors.value.message)
  }
}
//---------------------

onMounted(() => {
  getSettingsData()
  getFaviconData()
  getLogoData()
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
              <p class="card-text">{{ siteDescription.description }}</p>
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
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="getFaviconData"
                title="Reload favicon record ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#updateFavicon"
              >
                <i class="bi bi-pencil-square"></i>
                Edit
              </button>
            </div>
            <div class="m-3" v-if="faviconResultReloader">
              <img :src="favicon" alt="favicon" width="50px" title="favicon" />
            </div>
            <div class="d-flex justify-content-center my-3" v-else>
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Logo Settings -->
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Logo</h5>
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="getLogoData"
                title="Reload favicon record ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#updateLogo"
              >
                <i class="bi bi-pencil-square"></i>
                Edit
              </button>
            </div>
            <div class="m-3" v-if="logoResultReloader">
              <img :src="logo" alt="logo" width="100px" title="logo" />
            </div>
            <div class="d-flex justify-content-center my-3" v-else>
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <ToastMessage />

  <!-- modals -->

  <!-- edit site description modal start -->
  <div
    class="modal fade"
    id="editSettingsRecordModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateSettings">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">General Settings</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="about">About us</label>
              <textarea
                name="about"
                id="about"
                rows="6"
                class="form-control shadow-none"
                title="About description your site "
                maxlength="255"
                required
                v-model.trim="siteDescription.description"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateSettingsBtn"
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
  <!-- edit site description modal end -->

  <!-- Update Favicon Modal start -->
  <div
    class="modal fade"
    id="updateFavicon"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateFaviconRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Set Favicon</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="favicon">Chose a Favicon</label>
              <input
                type="file"
                id="favicon"
                class="form-control shadow-none"
                title="Set your favicon"
                accept="image/*"
                required
                @change="selectFavicon"
              />
            </div>
            <div class="mb-3" v-if="favicon">
              <strong class="d-block mb-1">Favicon</strong>
              <img :src="favicon" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateFaviconBtn"
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
  <!-- Update Favicon Modal end -->

  <!-- Update Logo Modal start -->
  <div
    class="modal fade"
    id="updateLogo"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form @submit.prevent="updateLogoRecord">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Set Logo</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold" for="favicon">Chose a Logo</label>
              <input
                type="file"
                id="favicon"
                class="form-control shadow-none"
                title="Set your favicon"
                accept="image/*"
                required
                @change="selectLogo"
              />
            </div>
            <div class="mb-3" v-if="logo">
              <strong class="d-block mb-1">Logo</strong>
              <img :src="logo" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateLogoBtn"
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
  <!-- Update Logo Modal end -->
</template>

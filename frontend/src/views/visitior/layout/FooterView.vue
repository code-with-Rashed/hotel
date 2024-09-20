<script setup>
import { RouterLink } from 'vue-router'
import { ref, onMounted } from 'vue'
import { urlBasename } from '@/helpers/urlBasename'
import useSettingApi from '@/composables/visitor/settingApi'
import useAddressApi from '@/composables/visitor/addressApi'

const { results: settingResults, get: getSetting } = useSettingApi()
const { results: addressResults, get } = useAddressApi()

// show site description
const descriptionReloader = ref(true)
const showDescription = async () => {
  descriptionReloader.value = false
  await getSetting()
  descriptionReloader.value = true
}
// --------------------

// show social links
const socials = ref(null)
const reloader = ref(true)
const showSocialLinks = async () => {
  reloader.value = false
  await get()
  reloader.value = true
  socials.value = addressResults.value.data.company_information.social
}
//-----------------

onMounted(() => {
  showDescription()
  showSocialLinks()
})
</script>
<template>
  <!-- Footer Start -->
  <footer class="d-print-none">
    <div class="container-fluid bg-white mt-5">
      <div class="row">
        <!-- show site description start -->
        <div class="col-md-4 p-4">
          <h3 class="h-fonts fw-bold fs-3 mb-2">My Hotel</h3>
          <template v-if="descriptionReloader">
            <template v-if="settingResults.data">
              <p class="fw-normal">{{ settingResults.data.setting.description }}</p>
            </template>
          </template>
          <template v-else>
            <div class="text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
        <!-- show site description end -->
        <div class="col-md-4 p-4">
          <h3 class="h-fonts fw-bold fs-3 mb-3">Links</h3>
          <RouterLink
            :to="{ name: 'home-page' }"
            class="d-block text-dark text-decoration-none mb-2"
            >Home</RouterLink
          >
          <RouterLink
            :to="{ name: 'rooms-page' }"
            class="d-block text-dark text-decoration-none mb-2"
            >Rooms
          </RouterLink>
          <RouterLink
            :to="{ name: 'contact-page' }"
            class="d-block text-dark text-decoration-none mb-2"
            >Contact us
          </RouterLink>
          <RouterLink :to="{ name: 'about-page' }" class="d-block text-dark text-decoration-none"
            >About us</RouterLink
          >
        </div>
        <div class="col-md-4 p-4">
          <h3 class="h-fonts fw-bold fs-3 mb-3">Fllow us</h3>
          <template v-if="reloader">
            <template v-if="socials">
              <template v-for="(social, i) in socials" :key="i">
                <a
                  :href="social"
                  target="_blank"
                  class="d-block text-dark text-decoration-none mb-2"
                >
                  <i :class="'bi-' + urlBasename(social, 'globe')"></i>
                  <span class="text-capitalize ms-1">{{ urlBasename(social, 'social') }}</span>
                </a>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
    <p class="text-center h-fonts bg-dark text-white p-3 m-0">www.hotel.com</p>
  </footer>
  <!-- Footer End -->
</template>

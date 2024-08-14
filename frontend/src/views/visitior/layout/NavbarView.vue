<script setup>
import { RouterLink } from 'vue-router'
import LoginModal from '@/components/visitior/LoginModal.vue'
import RegisterModal from '@/components/visitior/RegisterModal.vue'
import { ref, onMounted } from 'vue'
import useLogoApi from '@/composables/visitor/logoApi'
import { useUserCredentialsStore } from '@/stores/userCredentials'

const { results, get } = useLogoApi()
const storeAdminCredentials = useUserCredentialsStore()

// show site logo
const reloader = ref(true)
const showLogo = async () => {
  reloader.value = false
  await get()
  reloader.value = true
}
// --------------------
onMounted(() => showLogo())
</script>
<template>
  <!-- Navbar start -->
  <nav
    id="nav-bar"
    class="navbar navbar-expand-lg bg-white navbar-light px-lg-3 py-lg-2 shadow-sm sticky-top"
  >
    <div class="container-fluid">
      <!-- show logo -->
      <template v-if="reloader">
        <template v-if="results.data">
          <RouterLink :to="{ name: 'home-page' }" class="navbar-brand me-5">
            <img :src="results.data.logo.logo" alt="logo" height="50" width="50" class="rounded" />
          </RouterLink>
        </template>
      </template>
      <template v-else>
        <RouterLink :to="{ name: 'home-page' }" class="navbar-brand me-5 fs-3 fw-bold h-fonts">
          Hotel
        </RouterLink>
      </template>
      <!-- nav links -->
      <button
        class="navbar-toggler shadow-none"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink :to="{ name: 'home-page' }" class="nav-link me-2" aria-current="page"
              >Home</RouterLink
            >
          </li>
          <li class="nav-item">
            <RouterLink :to="{ name: 'rooms-page' }" class="nav-link me-2">Rooms</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink :to="{ name: 'facilities-page' }" class="nav-link me-2"
              >Facilities</RouterLink
            >
          </li>
          <li class="nav-item">
            <RouterLink :to="{ name: 'contact-page' }" class="nav-link me-2">Contact us</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink :to="{ name: 'about-page' }" class="nav-link">About</RouterLink>
          </li>
        </ul>
        <template v-if="storeAdminCredentials.isUserAuthenticate">
          <div class="d-flex">
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-outline-dark shadow-none dropdown-toggle"
                data-bs-toggle="dropdown"
                data-bs-display="static"
                area-expanded="false"
                aria-expanded="false"
              >
                <img
                  :src="storeAdminCredentials.user.photo"
                  alt="profile"
                  width="30px"
                  class="rounded-circle"
                />
                {{ storeAdminCredentials.user.name }}
              </button>
              <ul class="dropdown-menu dropdown-menu-lg-end">
                <li>
                  <RouterLink :to="{ name: 'user-profile-page' }" class="dropdown-item"
                    >Profile</RouterLink
                  >
                </li>
                <RouterLink :to="{ name: 'user-bookings-page' }" class="dropdown-item"
                  >My Bookings</RouterLink
                >
                <RouterLink to="/logout" class="dropdown-item">Logout</RouterLink>
              </ul>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="d-flex">
            <!-- Button trigger Login & registered -->
            <button
              type="button"
              class="btn btn-dark me-lg-3 me-2 shadow-none"
              data-bs-toggle="modal"
              data-bs-target="#loginModal"
            >
              Login
            </button>
            <button
              type="button"
              class="btn btn-dark shadow-none"
              data-bs-toggle="modal"
              data-bs-target="#registerModal"
            >
              Register
            </button>
          </div>
        </template>
      </div>
    </div>
  </nav>
  <!-- Navbar end -->
  <LoginModal />
  <RegisterModal />
</template>
<style scoped>
a.router-link-active {
  color: rgb(2, 2, 2);
}
</style>

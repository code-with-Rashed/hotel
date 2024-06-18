<script setup>
import { RouterLink } from 'vue-router'
import LoginModal from '@/components/visitior/LoginModal.vue'
import RegisterModal from '@/components/visitior/RegisterModal.vue'
</script>
<template>
  <!-- Navbar start -->
  <nav
    id="nav-bar"
    class="navbar navbar-expand-lg bg-white navbar-light px-lg-3 py-lg-2 shadow-sm sticky-top"
  >
    <div class="container-fluid">
      <RouterLink :to="{ name: 'home-page' }" class="navbar-brand me-5 fs-3 fw-bold h-fonts"
        >My Hotel</RouterLink
      >
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
        <div class="d-flex d-none">
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
                src="http://localhost/hotel/images/profile/IMG38857.png"
                alt="profile"
                width="30px"
                class="rounded-circle"
              />
              Rashed islam
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end">
              <li><a href="profile.php" class="dropdown-item">Profile</a></li>
              <li><a href="bookings.php" class="dropdown-item">Bookings</a></li>
              <li><a href="logout.php" class="dropdown-item">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar end -->
  <LoginModal />
  <RegisterModal />
</template>

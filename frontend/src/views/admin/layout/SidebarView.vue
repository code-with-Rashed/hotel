<script setup>
import { ref, watch } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import useAdminProfileApi from '@/composables/admin/adminProfileApi'
import { useAdminCredentialsStore } from '@/stores/adminCredentials'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'

const router = useRouter()
const { results, errors, logout } = useAdminProfileApi()
const storeAdminCredentials = useAdminCredentialsStore()
const storeToastMessage = useToastMessageStore()
const profilePhoto = storeAdminCredentials.admin.photo
const profileName = storeAdminCredentials.admin.name

const adminLogout = async () => {
  const authorizationToken = `${storeAdminCredentials.tokenType} ${storeAdminCredentials.adminAccessToken}`
  await logout(authorizationToken)
  if (results.value.success) {
    storeAdminCredentials.destroyAdminCredentials()
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    router.push({ name: 'login' })
  } else {
    storeToastMessage.showToastMessage(false, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}

// handle sidebar collapse
const expand = ref(false)

const emit = defineEmits(['layout'])
watch(expand, (status) => {
  if (status) {
    emit('layout', 'width:calc(100% - 260px)')
  } else {
    emit('layout', 'width:calc(100% - 70px)')
  }
})

if (innerWidth > 1100) {
  expand.value = true
}
</script>
<template>
  <aside id="sidebar" :class="{ expand }">
    <div>
      <button class="toggle-btn" type="button" @click="expand = !expand">
        <i class="bi bi-ui-radios-grid"></i>
      </button>
    </div>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'dashboard' }" class="sidebar-link" title="Dashboard">
          <i class="bi bi-diagram-3 fs-5 me-1"></i>
          <span>Dashboard</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'rooms' }" class="sidebar-link" title="Rooms">
          <i class="bi bi-door-open fs-5 me-1"></i>
          <span>Rooms</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <a
          title="Bookings Details"
          class="sidebar-link btn text-white text-start"
          data-bs-toggle="collapse"
          data-bs-target="#bookingLinks"
        >
          <i class="bi bi-grid-1x2 fs-5"></i>
          Bookings Details
        </a>
        <div class="px-3 small mb-1 collapse" id="bookingLinks">
          <ul class="nav nav-pills flex-column rounded border border-1 border-secondary">
            <li class="sidebar-link">
              <RouterLink class="sidebar-link" :to="{ name: 'new-bookings' }" title="New Bookings"
                >New Bookings
              </RouterLink>
            </li>
            <li class="sidebar-link">
              <RouterLink
                class="sidebar-link"
                :to="{ name: 'refund-bookings' }"
                title="Refund Bookings"
                >Refund Bookings
              </RouterLink>
            </li>
            <li class="sidebar-link">
              <RouterLink class="sidebar-link" :to="{ name: 'all-bookings' }" title="All Bookings"
                >All Bookings
              </RouterLink>
            </li>
          </ul>
        </div>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'features' }" class="sidebar-link" title="Room Features">
          <i class="bi bi-layers fs-5 me-1"></i>
          <span>Featuers</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'facilities' }" class="sidebar-link" title="Room Facilities">
          <i class="bi bi-layers-half fs-5 me-1"></i>
          <span>Facilities</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink
          :to="{ name: 'ratings-reviews' }"
          class="sidebar-link"
          title="Room related Ratings & Reviews"
        >
          <i class="bi bi-list-stars fs-5 me-1"></i>
          <span>Ratings & Reviews</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'user-records' }" class="sidebar-link" title="Uasers Record">
          <i class="bi bi-people fs-5 me-1"></i>
          <span>Users</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'contact-us' }" class="sidebar-link" title="Visitior Contact Us">
          <i class="bi bi-envelope fs-5 me-1"></i>
          <span>Contact Us</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink
          :to="{ name: 'carousel' }"
          class="sidebar-link"
          title="Carousel image Management ."
        >
          <i class="bi bi-sliders fs-5 me-1"></i>
          <span>Carousel</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'settings' }" class="sidebar-link" title="Settings Management .">
          <i class="bi bi-gear fs-5 me-1"></i>
          <span>Settings</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'team' }" class="sidebar-link" title="Team Profile Management .">
          <i class="bi bi-person-lines-fill fs-5 me-1"></i>
          <span>Team Profile</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink
          :to="{ name: 'achievements' }"
          class="sidebar-link"
          title="Team Profile Management ."
        >
          <i class="bi bi-graph-up-arrow fs-5 me-1"></i>
          <span>Achievements</span>
        </RouterLink>
      </li>
      <li class="sidebar-item">
        <RouterLink :to="{ name: 'address' }" class="sidebar-link" title="Address Management .">
          <i class="bi bi-geo-alt fs-5 me-1"></i>
          <span>Address</span>
        </RouterLink>
      </li>
    </ul>
    <div class="sidebar-footer">
      <RouterLink :to="{ name: 'profile' }" class="sidebar-link" title="Profile Management .">
        <img :src="profilePhoto" alt="profile" width="30px" height="30px" class="rounded-circle" />
        <span class="ms-1">{{ profileName }}</span>
      </RouterLink>
      <a href="javascript:void(0)" @click="adminLogout()" class="sidebar-link">
        <i class="bi bi-box-arrow-left"></i>
        <span>Logout</span>
      </a>
    </div>
  </aside>
  <ToastMessage />
</template>

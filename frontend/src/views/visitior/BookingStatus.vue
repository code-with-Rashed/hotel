<script setup>
import LayoutView from './layout/LayoutView.vue'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
const { query } = useRoute()
const router = useRouter()
const alert = ref('')
const message = ref('')
if (query.s) {
  switch (query.s) {
    case 'success':
      alert.value = 'alert-success'
      message.value = 'Payment Done ! So Your Booking is Successful.'
      break
    case 'failure':
      alert.value = 'alert-danger'
      message.value = 'Transection failure ! So Your Booking is Failure.'
      break
    case 'cancel':
      alert.value = 'alert-danger'
      message.value = 'Payment Canceled ! So Your Booking is Cancele.'
      break

    default:
      alert.value = 'alert-warning'
      message.value =
        'This page is non accessable before transection. and you have provid invalid query.'
      break
  }
} else {
  router.push({ name: 'home-page' })
}
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row">
          <div class="col-12 mt-4 px-4">
            <h3 class="fw-bold">Booking Status</h3>
          </div>
          <div class="col-12 my-4 px-4 alert" :class="alert">
            <p class="fw-bold">
              <i class="bi bi-wallet2"></i>
              {{ message }}
            </p>
            <RouterLink :to="{ name: 'user-bookings-page' }" class="mt-3"
              >Go to my Bookings</RouterLink
            >
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

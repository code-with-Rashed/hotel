<script setup>
import { useToastMessageStore } from '@/stores/toastMessage'
const store = useToastMessageStore()
</script>
<template>
  <div class="toast-container position-fixed top-0 end-0 p-2">
    <div
      class="toast fade"
      :class="{
        show: store.toggleToast,
        hide: !store.toggleToast,
        'text-bg-primary': store.successStatus,
        'text-bg-danger': !store.successStatus
      }"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
    >
      <div class="d-flex">
        <div class="toast-body" v-html="store.messages"></div>
        <button
          type="button"
          class="btn-close btn-close-white me-2 m-auto"
          data-bs-dismiss="toast"
          aria-label="Close"
        ></button>
      </div>
    </div>
  </div>
</template>

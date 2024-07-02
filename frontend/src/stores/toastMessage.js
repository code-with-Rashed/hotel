import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useToastMessageStore = defineStore('toastMessage', () => {
  const toggleToast = ref(false)
  const success = ref(false)
  const message = ref(null)
  watch(toggleToast, () => {
    setTimeout(() => {
      toggleToast.value = false
    }, 6000)
  })
  return { toggleToast, success, message }
})

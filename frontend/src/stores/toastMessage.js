import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useToastMessageStore = defineStore('toastMessage', () => {
  const toggleToast = ref(false)
  const successStatus = ref(false)
  const messages = ref(null)
  const runTimes = ref(null)
  function showToastMessage(success, message, time = 5000) {
    toggleToast.value = true
    successStatus.value = success
    messages.value = message
    runTimes.value = time
  }
  watch(toggleToast, () => {
    setTimeout(() => {
      toggleToast.value = false
    }, runTimes.value)
  })
  return { toggleToast, successStatus, messages, showToastMessage }
})

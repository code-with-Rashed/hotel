import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useShutdownStore = defineStore('shutdown', () => {
  const shutdown = ref(false)
  return { shutdown }
})

<script setup>
import { RouterView } from 'vue-router'
import { onMounted } from 'vue'
import useFaviconApi from '@/composables/visitor/faviconApi'

// show favicon
const { results: faviconResults, get: getFavicon } = useFaviconApi()
const faviconLink = document.querySelector("link[rel='icon']")
const showFavicon = async () => {
  await getFavicon()
  faviconLink.href = faviconResults.value.data.favicon.icon
}
onMounted(() => {
  showFavicon()
})
</script>
<template>
  <RouterView />
</template>

<script setup>
import { ref } from 'vue'
import SidebarView from './SidebarView.vue'
const layoutExtand = ref(null)
</script>
<template>
  <div class="wrapper">
    <SidebarView @layout="(style) => (layoutExtand = style)" />
    <div class="main p-3" :style="layoutExtand">
      <slot name="main"></slot>
    </div>
  </div>
</template>
<style>
@import '../../../assets/admin_layout.css';
</style>

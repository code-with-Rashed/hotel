<script setup>
import NavbarView from './NavbarView.vue'
import FooterView from './FooterView.vue'
</script>
<template>
  <NavbarView />
  <slot name="page"></slot>
  <FooterView />
</template>

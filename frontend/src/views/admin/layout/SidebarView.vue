<script setup>
import { ref, watch } from 'vue'
import { RouterLink } from 'vue-router'

const expand = ref(false)

const emit = defineEmits(['layout'])
watch(expand, (status) => {
  if (status) {
    emit('layout', 'width:calc(100% - 260px)')
  } else {
    emit('layout', 'width:calc(100% - 70px)')
  }
})
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
        <RouterLink :to="{ name: dashboard }" class="sidebar-link">
          <i class="bi bi-diagram-3 fs-5 me-1"></i>
          <span>Dashboard</span>
        </RouterLink>
      </li>
    </ul>
  </aside>
</template>

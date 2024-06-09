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
    </ul>
  </aside>
</template>

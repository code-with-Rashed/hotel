<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row my-5">
          <div class="col-12 px-4 alert alert-danger">
            <p class="fw-bold">
              <i class="bi bi-exclamation-triangle"></i>
              404 Page Not Found
            </p>
            <RouterLink :to="{ name: 'home-page' }" class="mt-3">Go to Home Page</RouterLink>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

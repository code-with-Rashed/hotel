<script setup>
import LayoutView from './layout/LayoutView.vue'
import useFacilityApi from '@/composables/visitor/facilityApi'
import { ref, onMounted } from 'vue'
const { results, get } = useFacilityApi()

// show all facility record
const reloader = ref(true)
const showFacilities = async () => {
  reloader.value = false
  await get()
  reloader.value = true
}
onMounted(() => showFacilities())
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="my-5 px-4">
        <h2 class="fw-bold text-center h-fonts">OUR FACILITIES</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Excepturi odit saepe et eveniet
          dolor id aspernatur natus sapiente cum at? <br />
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, pariatur?
        </p>
      </div>
      <div class="container">
        <div class="row">
          <template v-if="reloader">
            <template v-if="results.data">
              <template v-for="facility in results.data.facilities" :key="facility.id">
                <div class="col-lg-4 col-md-6 mb-5 px-4">
                  <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                      <img :src="facility.image" alt="facility image" width="40px" />
                      <h5 class="m-0 ms-3">{{ facility.name }}</h5>
                    </div>
                    <p>{{ facility.description }}</p>
                  </div>
                </div>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="col-12 mb-5 px-4 text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

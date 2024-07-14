<script setup>
import LayoutView from './layout/LayoutView.vue'
import { onMounted, ref } from 'vue'
import useFeaturesApi from '@/composables/admin/featuresApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import FeaturesModal from '@/components/admin/FeaturesModal.vue'

const { results, errors, get } = useFeaturesApi()
const storeToastMessage = useToastMessageStore()

const editFeatureId = ref(0)
const deleteFeatureId = ref(0)

const editFeature = (id) => {
  editFeatureId.value = id
}
const deleteFeature = (id) => {
  deleteFeatureId.value = id
}

// get all feature record
const reloader = ref(true)
const featureRecord = async () => {
  reloader.value = false
  await get()
  reloader.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
onMounted(() => featureRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Feature Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Features</h5>
              <button type="button" class="btn btn-sm btn-primary" @click="featureRecord">
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addFeatureModal"
              >
                <i class="bi bi-plus-square"></i>
                Add Featur
              </button>
            </div>
            <div class="row px-3">
              <table class="table">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>Featur Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="reloader">
                    <template v-if="results.data">
                      <template v-for="feature in results.data.features" :key="feature.id">
                        <tr>
                          <td>{{ feature.name }}</td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-sm btn-primary shadow-none me-2"
                              @click="editFeature(feature.id)"
                              data-bs-toggle="modal"
                              data-bs-target="#editFeatureModal"
                            >
                              <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button
                              type="button"
                              class="btn btn-sm btn-danger shadow-none"
                              @click="deleteFeature(feature.id)"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteFeatureModal"
                            >
                              <i class="bi bi-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </template>
                    </template>
                  </template>
                  <template v-else>
                    <div class="d-flex justify-content-center my-3">
                      <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                    </div>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <FeaturesModal :editFeatureId="editFeatureId" :deleteFeatureId="deleteFeatureId" />
  <ToastMessage />
</template>

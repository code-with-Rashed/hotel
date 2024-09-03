<script setup>
import LayoutView from './layout/LayoutView.vue'
import FacilitiesModal from '@/components/admin/FacilitiesModal.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useFacilityApi from '@/composables/admin/facilityApi'

const storeToastMessage = useToastMessageStore()
const { results, errors, get } = useFacilityApi()

// send instruction props
const instruction = ref('')

// send facility id to child (FacilityModal) component for editing by facility record
const editFacilityId = ref(0)
const editFacility = (id) => {
  editFacilityId.value = id
  instruction.value = 'show'
}

// send facility id to child (FacilityModal) component for deleting by facility record
const deleteFacilityId = ref(0)
const deleteFacility = (id) => {
  deleteFacilityId.value = id
  instruction.value = 'delete'
}

// get all facility record
const reloader = ref(true)
const facilityRecord = async () => {
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
onMounted(() => facilityRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Facility Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="row">
              <h5 class="col-md-4 card-title mb-2">Facilities</h5>
              <div class="col-md-4 mb-2 text-md-center">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="facilityRecord"
                  title="Reload facility record list ."
                >
                  Reload
                  <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
                </button>
              </div>
              <div class="col-md-4 mb-2 text-md-end">
                <button
                  type="button"
                  class="btn btn-dark btn-sm shadow-none"
                  data-bs-toggle="modal"
                  data-bs-target="#addFacilityRecord"
                >
                  <i class="bi bi-plus-square"></i>
                  Add Facility
                </button>
              </div>
            </div>
            <hr />
            <div class="row mt-3" id="facilitie-data">
              <template v-if="reloader">
                <template v-if="results.data">
                  <template v-for="facility in results.data.facilities" :key="facility.id">
                    <div class="col-lg-4 col-md-6 mb-5 px-4">
                      <div class="bg-white shadow p-4 rounded border-4 border-top border-dark pop">
                        <div class="mb-1 text-end">
                          <button
                            class="btn btn-primary btn-sm shadow-none mx-1"
                            type="button"
                            data-bs-target="#editFacilityRecord"
                            data-bs-toggle="modal"
                            @click="editFacility(facility.id)"
                          >
                            <i class="bi bi-pencil-square"></i> Edit
                          </button>
                          <button
                            class="btn btn-danger btn-sm shadow-none"
                            type="button"
                            data-bs-target="#deleteFacilityModal"
                            data-bs-toggle="modal"
                            @click="deleteFacility(facility.id)"
                          >
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                          <img :src="facility.image" alt="facilities" width="40px" />
                          <h5 class="m-0 ms-3">{{ facility.name }}</h5>
                        </div>
                        <p class="card-title">{{ facility.description }}</p>
                      </div>
                    </div>
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
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <FacilitiesModal
    :editFacilityId="editFacilityId"
    :deleteFacilityId="deleteFacilityId"
    :instruction="instruction"
  />
  <ToastMessage />
</template>

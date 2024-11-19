<script setup>
import LayoutView from './layout/LayoutView.vue'
import AchievementModal from '@/components/admin/AchievementModal.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useAchievementApi from '@/composables/admin/achievementApi'

const storeToastMessage = useToastMessageStore()
const { results, errors, get } = useAchievementApi()

// send instruction props
const instruction = ref('')

// send Achievement id to child (AchievementModal) component for editing by Achievement record
const editAchievementId = ref(0)
const editAchievement = (id) => {
  editAchievementId.value = id
  instruction.value = 'show'
}

// send Achievement id to child (AchievementModal) component for deleting by Achievement record
const deleteAchievementId = ref(0)
const deleteAchievement = (id) => {
  deleteAchievementId.value = id
  instruction.value = 'delete'
}

// get all Achievement record
const reloader = ref(true)
const achievementRecord = async () => {
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
onMounted(() => achievementRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Manage Our Achievements</h3>
        <!-- Manage Achievement  -->
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="row">
              <h5 class="card-title col-md-4 mb-2">Manage Achievement</h5>
              <div class="col-md-4 mb-2 text-md-center">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="achievementRecord"
                  title="Reload Achievement record list ."
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
                  data-bs-target="#addAchievementModal"
                >
                  <i class="bi bi-plus-square"></i>
                  Add
                </button>
              </div>
            </div>
            <hr />
            <div class="row mt-3">
              <template v-if="reloader">
                <template v-if="results.data">
                  <template v-for="achievement in results.data.achievement" :key="achievement.id">
                    <div class="col-md-3 mb-4">
                      <div class="card">
                        <img
                          :src="achievement.photo"
                          alt="achievement photo"
                          class="card-img-top w-50 m-auto mt-2"
                        />
                        <div class="card-body text-center">
                          <h4 class="card-title">{{ achievement.achievement }}</h4>
                          <button
                            type="button"
                            data-bs-target="#editAchievementModal"
                            data-bs-toggle="modal"
                            class="btn btn-sm btn-primary m-1"
                            @click="editAchievement(achievement.id)"
                          >
                            <i class="bi bi-pencil-square"></i> Edit
                          </button>
                          <button
                            type="button"
                            data-bs-target="#deleteAchievementModal"
                            data-bs-toggle="modal"
                            class="btn btn-sm btn-danger m-1"
                            @click="deleteAchievement(achievement.id)"
                          >
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>
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
  <AchievementModal
    :editAchievementId="editAchievementId"
    :deleteAchievementId="deleteAchievementId"
    :instruction="instruction"
  />
  <ToastMessage />
</template>

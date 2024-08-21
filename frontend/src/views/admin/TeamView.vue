<script setup>
import LayoutView from './layout/LayoutView.vue'
import TeamModal from '@/components/admin/TeamModal.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useTeamApi from '@/composables/admin/teamApi'

const storeToastMessage = useToastMessageStore()
const { results, errors, get } = useTeamApi()

// send instruction props
const instruction = ref('')

// send team member id to child (TeamModal) component for editing by team profile record
const editTeamMemberId = ref(0)
const editTeamMember = (id) => {
  editTeamMemberId.value = id
  instruction.value = 'show'
}

// send team member id to child (TeamModal) component for deleting by team profile record
const deleteTeamMemberId = ref(0)
const deleteTeamMember = (id) => {
  deleteTeamMemberId.value = id
  instruction.value = 'delete'
}

// get all team member record
const reloader = ref(true)
const teamRecord = async () => {
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
onMounted(() => teamRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Team Profile Management</h3>
        <!-- Team Settings -->
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Team Management</h5>
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="teamRecord"
                title="Reload team profile record list ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addTeamMemberModal"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row" id="team-data">
              <template v-if="reloader">
                <template v-if="results.data">
                  <template v-for="team in results.data.team" :key="team.id">
                    <div class="col-md-3 mb-4">
                      <div class="card">
                        <img :src="team.photo" alt="team member photo" class="card-img-top" />
                        <div class="card-body">
                          <h4 class="card-title">{{ team.name }}</h4>
                          <p class="card-text">{{ team.designation.toUpperCase() }}</p>
                          <button
                            type="button"
                            data-bs-target="#editTeamMemberModal"
                            data-bs-toggle="modal"
                            class="btn btn-sm btn-primary m-1"
                            @click="editTeamMember(team.id)"
                          >
                            <i class="bi bi-pencil-square"></i> Edit
                          </button>
                          <button
                            type="button"
                            data-bs-target="#deleteTeamMemberModal"
                            data-bs-toggle="modal"
                            class="btn btn-sm btn-danger m-1"
                            @click="deleteTeamMember(team.id)"
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
  <TeamModal
    :editTeamMemberId="editTeamMemberId"
    :deleteTeamMemberId="deleteTeamMemberId"
    :instruction="instruction"
  />
  <ToastMessage />
</template>

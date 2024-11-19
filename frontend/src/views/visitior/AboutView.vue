<script setup>
import LayoutView from './layout/LayoutView.vue'
import useTeamMemberApi from '@/composables/visitor/teamMemberApi'
import useAchievementApi from '@/composables/visitor/achievementApi'
import { ref, onMounted } from 'vue'

const { results, get } = useTeamMemberApi()
const { results: achievementResults, get: getAchievement } = useAchievementApi()

// show team member records
const reloader = ref(true)
const showTeamMembers = async () => {
  reloader.value = false
  await get()
  reloader.value = true
}

// show achievement records
const achievementReloader = ref(true)
const showAchievements = async () => {
  achievementReloader.value = false
  await getAchievement()
  achievementReloader.value = true
}

onMounted(() => {
  showAchievements()
  showTeamMembers()
})
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="my-5 px-4">
        <h2 class="fw-bold text-center h-fonts">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Excepturi odit saepe et eveniet
          dolor id aspernatur natus sapiente cum at? <br />
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, pariatur?
        </p>
      </div>

      <div class="container">
        <div class="row mt-5">
          <template v-if="achievementReloader">
            <template v-if="achievementResults.data">
              <template
                v-for="achievement in achievementResults.data.achievement"
                :key="achievement.id"
              >
                <div class="col-lg-3 col-md-6 mb-4 px-4">
                  <div class="bg-white text-center shadow rounded border-top border-4 p-4 box">
                    <img :src="achievement.photo" alt="about hotel" width="70px" />
                    <h6 class="mt-3">{{ achievement.achievement }}</h6>
                  </div>
                </div>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="col-12 px-4 text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
      <!-- show team profile start -->
      <h3 class="text-center fw-bold my-5 h-fonts">MANAGEMENT TEAM</h3>
      <div class="container">
        <div class="row">
          <template v-if="reloader">
            <template v-if="results.data">
              <template v-for="member in results.data.team" :key="member.id">
                <div class="col-lg-3 col-md-6 mb-4">
                  <div class="card shadow rounded border-0">
                    <img class="card-img-top" :src="member.photo" alt="Card image cap" />
                    <div class="card-body">
                      <h5 class="card-title text-center">{{ member.name }}</h5>
                      <p class="card-title text-center text-uppercase">{{ member.designation }}</p>
                    </div>
                  </div>
                </div>
              </template>
            </template>
          </template>
          <template v-else>
            <div class="col-12 px-4 text-center">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </template>
        </div>
      </div>
      <!-- show team profile end -->
    </template>
  </LayoutView>
</template>

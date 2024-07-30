<script setup>
import LayoutView from './layout/LayoutView.vue'
import AddressModal from '@/components/admin/AddressModal.vue'
import { onMounted, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useAddressApi from '@/composables/admin/addressApi'
import { urlBasename } from '@/helpers/urlBasename'

const storeToastMessage = useToastMessageStore()
const { results, errors, get } = useAddressApi()

// get company address information record
const reloader = ref(true)
const address = ref(null)
const addressRecord = async () => {
  reloader.value = false
  await get()
  reloader.value = true
  if (results.value.success) {
    address.value = results.value.data.company_information
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
onMounted(() => addressRecord())
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Address Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
              <h5 class="card-title m-0">Contact Details</h5>
              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click="addressRecord"
                title="Reload carousel image record list ."
              >
                Reload
                <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
              </button>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#addressModal"
              >
                <i class="bi bi-pencil-square"></i> Edit
              </button>
            </div>
            <div class="row">
              <template v-if="reloader">
                <template v-if="address">
                  <div class="col-md-6">
                    <div class="mb-4">
                      <div class="card-subtitle fw-bold mb-1">Address</div>
                      <p class="card-text">
                        <i class="bi bi-geo-alt me-1"></i><span>{{ address.address }}</span>
                      </p>
                    </div>
                    <div class="mb-4">
                      <div class="card-subtitle fw-bold mb-1">Contact number</div>
                      <template v-for="(phone, i) in address.phone" :key="i">
                        <p class="card-text">
                          <i class="bi bi-telephone-fill me-1"></i>
                          <span>+88 {{ phone }}</span>
                        </p>
                      </template>
                    </div>
                    <div class="mb-4">
                      <div class="card-subtitle fw-bold mb-1">E-mail</div>
                      <template v-for="(email, i) in address.email" :key="i">
                        <p class="card-text">
                          <i class="bi bi-envelope-fill me-1"></i>
                          <span>{{ email }}</span>
                        </p>
                      </template>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <div class="card-subtitle fw-bold mb-1">Social links</div>
                      <template v-for="(social, i) in address.social" :key="i">
                        <p class="card-text">
                          <i
                            class="bi fw-bold fs-6 me-1"
                            :class="'bi-' + urlBasename(social, 'globe')"
                          ></i>
                          <span class="text-dark">{{ social }}</span>
                        </p>
                      </template>
                    </div>
                  </div>
                  <div class="mb-4">
                    <div class="card-subtitle fw-bold mb-1">Location</div>
                    <iframe
                      :src="address.map"
                      loading="lazy"
                      class="w-100 border p-2"
                      id="iframe"
                    ></iframe>
                  </div>
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
  <AddressModal :address="address" />
  <ToastMessage />
</template>

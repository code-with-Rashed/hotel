<script setup>
import { reactive, watch, ref } from 'vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import ToastMessage from '@/components/ToastMessage.vue'
import useAddressApi from '@/composables/admin/addressApi'
import { urlBasename } from '@/helpers/urlBasename'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps(['address'])

const storeToastMessage = useToastMessageStore()
const { results, errors, put } = useAddressApi()

// company email addressess
const emails = reactive([{ email: '' }])
const addEmail = () => {
  emails.push({ email: '' })
}
const removeEmail = (index) => {
  if (emails.length > 1) emails.splice(index, 1)
}

// company phone numbers
const phones = reactive([{ phone: '' }])
const addPhone = () => {
  phones.push({ phone: '' })
}
const removePhone = (index) => {
  if (phones.length > 1) phones.splice(index, 1)
}

// company social links
const socials = reactive([{ social: '' }])
const addSocial = () => {
  socials.push({ social: '' })
}
const removeSocial = (index) => {
  if (socials.length > 1) socials.splice(index, 1)
}

// final address information
const addressInformation = reactive({
  address: '',
  map: '',
  email: [],
  phone: [],
  social: []
})

watch(props, (addressData) => {
  addressInformation.address = addressData.address.address
  addressInformation.map = addressData.address.map
  if (addressData.address.email.length > 0) {
    emails.splice(0, emails.length)
    addressData.address.email.forEach((e) => emails.push({ email: e }))
  }

  if (addressData.address.phone.length > 0) {
    phones.splice(0, phones.length)
    addressData.address.phone.forEach((p) => phones.push({ phone: p }))
  }

  if (addressData.address.social.length > 0) {
    socials.splice(0, socials.length)
    addressData.address.social.forEach((s) => socials.push({ social: s }))
  }
})

// prepare form data
const formData = () => {
  addressInformation.email = []
  emails.forEach((e) => addressInformation.email.push(e.email))
  addressInformation.phone = []
  phones.forEach((p) => addressInformation.phone.push(p.phone))
  addressInformation.social = []
  socials.forEach((s) => addressInformation.social.push(s.social))
  update()
}

// update company address information
const updateAddressSubmitBtn = ref(true)
const update = async () => {
  updateAddressSubmitBtn.value = false
  await put(addressInformation)
  updateAddressSubmitBtn.value = true

  if (results.value.success) {
    hideBsModal('addressModal')
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
</script>
<template>
  <div
    class="modal fade"
    id="addressModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
    style="display: none"
  >
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Adress Update</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="formData()">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Address</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"
                      ><i class="bi bi-geo-alt me-1"></i
                    ></span>
                    <input
                      type="text"
                      name="address"
                      class="form-control shadow-none"
                      title="Enter your official Address"
                      maxlength="255"
                      v-model.trim="addressInformation.address"
                      required
                    />
                  </div>
                </div>
                <!-- email -->
                <div class="mb-3" v-for="(email, index) in emails" :key="index">
                  <label class="form-label fw-bold">E-mail</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"
                      ><i class="bi bi-envelope-fill"></i
                    ></span>
                    <input
                      type="email"
                      class="form-control shadow-none"
                      title="Write your email Address"
                      maxlength="60"
                      v-model.trim="email.email"
                      required
                    />
                    <button type="button" class="btn btn-sm btn-primary" @click="addEmail">
                      <i class="bi bi-plus-lg"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" @click="removeEmail(index)">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>
                </div>
                <!-- phone -->
                <div class="mb-3" v-for="(phone, index) in phones" :key="index">
                  <label class="form-label fw-bold">Contact Number</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text border-0"
                      ><i class="bi bi-telephone-fill"></i
                    ></span>
                    <input
                      type="text"
                      class="form-control shadow-none"
                      title="Enter your official Phone Number"
                      maxlength="15"
                      v-model.trim="phone.phone"
                      required
                    />
                    <button type="button" class="btn btn-sm btn-primary" @click="addPhone">
                      <i class="bi bi-plus-lg"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" @click="removePhone(index)">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3" v-for="(social, index) in socials" :key="index">
                  <label class="form-label fw-bold">Social link</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"
                      ><i class="bi" :class="'bi-' + urlBasename(social.social, 'globe')"></i
                    ></span>
                    <input
                      type="url"
                      class="form-control shadow-none"
                      title="Enter your social link"
                      maxlength="255"
                      v-model.trim="social.social"
                      required
                    />
                    <button type="button" class="btn btn-sm btn-primary" @click="addSocial">
                      <i class="bi bi-plus-lg"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger"
                      @click="removeSocial(index)"
                    >
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3">
                  <label class="form-label fw-bold">Iframe link</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"><i class="bi bi-map"></i></span>
                    <input
                      type="url"
                      name="map"
                      class="form-control shadow-none"
                      title="Enter your Iframe link"
                      v-model.trim="addressInformation.map"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" v-if="updateAddressSubmitBtn">
                SAVE
              </button>
              <button class="btn btn-primary" type="button" disabled v-else>
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status"> Proccssing...</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <ToastMessage />
</template>

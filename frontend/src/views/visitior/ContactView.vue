<script setup>
import LayoutView from './layout/LayoutView.vue'
import { ref, reactive, onMounted } from 'vue'
import useContactApi from '@/composables/visitor/contactApi'
import useAddressApi from '@/composables/visitor/addressApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { urlBasename } from '@/helpers/urlBasename'

const storeToastMessage = useToastMessageStore()
const { results, errors, post } = useContactApi()
const { results: addressResults, get } = useAddressApi()

// post new contact request
const postContactSubmitBtn = ref(true)
const contact = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
})
const postContact = async () => {
  postContactSubmitBtn.value = false
  await post(contact)
  postContactSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    contact.name = ''
    contact.email = ''
    contact.subject = ''
    contact.message = ''
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
//--------------------

// show address information
const address = ref(null)
const reloader = ref(true)
const showAddress = async () => {
  reloader.value = false
  await get()
  reloader.value = true
  address.value = addressResults.value.data.company_information
}

onMounted(() => showAddress())
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="my-5 px-4">
        <h2 class="fw-bold text-center h-fonts">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Excepturi odit saepe et eveniet
          dolor id aspernatur natus sapiente cum at? <br />
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, pariatur?
        </p>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white shadow p-4 rounded">
              <template v-if="reloader">
                <template v-if="address">
                  <iframe
                    class="w-100 mb-4"
                    height="320"
                    :src="address.map"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                  ></iframe>
                  <h5>Address</h5>
                  <p>
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ address.address }}
                  </p>
                  <h5 class="mt-4">Call us</h5>
                  <div class="mb-2" v-for="(phone, i) in address.phone" :key="i">
                    <a
                      :href="`tel: ${phone}`"
                      class="d-inline-block mb-2 text-decoration-none text-dark"
                    >
                      <i class="bi bi-telephone-fill"></i>
                      {{ phone }}
                    </a>
                  </div>
                  <h5 class="mt-4">Email</h5>
                  <div class="mb-2" v-for="(email, i) in address.email" :key="i">
                    <a :href="`mailto: ${email}`" class="text-decoration-none text-dark">
                      <i class="bi bi-envelope-fill"> </i>
                      {{ email }}
                    </a>
                  </div>
                  <h5 class="mt-4">Follow Us</h5>
                  <a
                    v-for="(social, i) in address.social"
                    :key="i"
                    :href="social"
                    target="_blank"
                    class="text-decoration-none text-dark fs-5 fw-bold me-2"
                  >
                    <i :class="'bi-' + urlBasename(social, 'globe')"></i>
                  </a>
                </template>
              </template>
              <template v-else>
                <div class="px-4 text-center">
                  <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </template>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white shadow p-4 rounded">
              <h5 class="fw-bold">Send a message</h5>
              <form @submit.prevent="postContact" autocomplete="off">
                <div class="mt-3">
                  <label class="form-label">Name</label>
                  <input
                    type="text"
                    maxlength="40"
                    class="form-control shadow-none"
                    required
                    v-model.trim="contact.name"
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Email</label>
                  <input
                    type="email"
                    maxlength="60"
                    class="form-control shadow-none"
                    required
                    v-model.trim="contact.email"
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Subject</label>
                  <input
                    type="text"
                    maxlength="150"
                    class="form-control shadow-none"
                    name="subject"
                    required
                    v-model.trim="contact.subject"
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Message</label>
                  <textarea
                    maxlength="255"
                    rows="8"
                    style="resize: none"
                    class="form-control shadow-none"
                    required
                    v-model.trim="contact.message"
                  ></textarea>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary" v-if="postContactSubmitBtn">
                    SEND
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
    </template>
  </LayoutView>
  <ToastMessage />
</template>

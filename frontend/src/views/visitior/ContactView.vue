<script setup>
import LayoutView from './layout/LayoutView.vue'
import { ref, reactive } from 'vue'
import useContactApi from '@/composables/visitor/contactApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'

const storeToastMessage = useToastMessageStore()
const { results, errors, post } = useContactApi()

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
              <iframe
                class="w-100 mb-4"
                height="320"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b:0xc80b8f06e177fe62!2sNew York, NY, USA!5e0!3m2!1sen!2sbd!4v171"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
              <h5>Address</h5>
              <a
                href="https://map.com"
                target="_blank"
                class="text-decoration-none text-dark d-inline-block mb-2"
              >
                <i class="bi bi-geo-alt me-1"></i>
                Dhaka Bangladesh
              </a>
              <h5 class="mt-4">Call us</h5>
              <div class="mb-2">
                <a
                  href="tel: +01860491387"
                  class="d-inline-block mb-2 text-decoration-none text-dark"
                >
                  <i class="bi bi-telephone-fill"></i> + 01860491387
                </a>
              </div>
              <div class="mb-2">
                <a
                  href="tel: +01921083214"
                  class="d-inline-block mb-2 text-decoration-none text-dark"
                >
                  <i class="bi bi-telephone-fill"></i> + 01921083214
                </a>
              </div>

              <h5 class="mt-4">Email</h5>
              <a
                href="mailto: hotel@gmail.com"
                class="d-inline-block mb-2 text-decoration-none text-dark"
              >
                <i class="bi bi-envelope-fill"> </i>
                hotel@gmail.com
              </a>

              <h5 class="mt-4">Follow Us</h5>
              <a
                href="https://twitter.com"
                target="_blank"
                class="text-decoration-none text-dark fs-5 fw-bold me-2"
              >
                <i class="bi bi-twitter"></i>
              </a>
              <a
                href="https://facebook.com"
                target="_blank"
                class="text-decoration-none text-dark fs-5 fw-bold me-2"
              >
                <i class="bi bi-facebook"></i>
              </a>
              <a
                href="https://instagram.com"
                target="_blank"
                class="text-decoration-none text-dark fs-5 fw-bold"
              >
                <i class="bi bi-instagram"></i>
              </a>
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

<script setup>
import LayoutView from './layout/LayoutView.vue'
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
              <form action="/hotel/contact.php" method="POST" autocomplete="off">
                <input type="hidden" name="CSRF_TOKEN" value="5a007fe00f3c437481a31ceec01915eb" />
                <div class="mt-3">
                  <label class="form-label">Name</label>
                  <input
                    type="text"
                    maxlength="30"
                    class="form-control shadow-none"
                    name="name"
                    required=""
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Email</label>
                  <input
                    type="email"
                    maxlength="50"
                    class="form-control shadow-none"
                    name="email"
                    required=""
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Subject</label>
                  <input
                    type="text"
                    maxlength="100"
                    class="form-control shadow-none"
                    name="subject"
                    required=""
                  />
                </div>
                <div class="mt-3">
                  <label class="form-label">Message</label>
                  <textarea
                    maxlength="250"
                    rows="5"
                    style="resize: none"
                    class="form-control shadow-none"
                    name="message"
                    required=""
                  ></textarea>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn custom-bg text-white" name="send">SEND</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

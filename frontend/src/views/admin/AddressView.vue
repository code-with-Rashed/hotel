<script setup>
import LayoutView from './layout/LayoutView.vue'
import AddressModal from '@/components/admin/AddressModal.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Address Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Contact Details</h5>
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
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="card-subtitle fw-bold mb-1">Address</div>
                  <p class="card-text">
                    <i class="bi bi-geo-alt me-1"></i
                    ><span id="address">XYZ Road , ABC Building New Yourk, USA</span>
                  </p>
                </div>
                <div class="mb-4">
                  <div class="card-subtitle fw-bold mb-1">Contact number</div>
                  <p class="card-text">
                    <i class="bi bi-telephone-fill"></i>
                    <span>+88 01921042138</span>
                  </p>
                </div>
                <div class="mb-4">
                  <div class="card-subtitle fw-bold mb-1">E-mail</div>
                  <p class="card-text">
                    <i class="bi bi-envelope-fill"></i>
                    <span id="email"> hotel@support.com</span>
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <div class="card-subtitle fw-bold mb-1">Social links</div>
                  <p class="card-text">
                    <i class="bi bi-facebook fw-bold fs-6 me-1"></i>
                    <span id="facebook" class="text-dark" title="Facebook link"
                      >https://facebook.com</span
                    >
                  </p>
                  <p class="card-text">
                    <i class="bi bi-twitter fw-bold fs-6 me-1"></i>
                    <span id="twitter" class="text-dark" title="Twitter link"
                      >https://twitter.com</span
                    >
                  </p>
                  <p class="card-text">
                    <i class="bi bi-linkedin fw-bold fs-6 me-1"></i>
                    <span
                      id="instagram"
                      class="text-decoration-none text-dark"
                      title="Instagram link"
                      >https://linkedin.com</span
                    >
                  </p>
                </div>
              </div>
              <div class="mb-4">
                <div class="card-subtitle fw-bold mb-1">iframe link</div>
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387194.06225701555!2d-74.30932678804537!3d40.697019288954785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1700986766942!5m2!1sen!2sbd"
                  loading="lazy"
                  class="w-100 border p-2"
                  id="iframe"
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <AddressModal />
</template>

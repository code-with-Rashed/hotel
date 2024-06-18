<script setup>
import AccountRecoveryModal from '@/components/visitior/AccountRecoveryModal.vue'
</script>
<template>
  <!-- Login Modal start -->
  <div
    class="modal fade"
    id="loginModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle fs-3 me-2"></i>User login
            </h5>
            <button
              type="reset"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input
                type="email"
                name="email"
                class="form-control shadow-none"
                maxlength="58"
                required
              />
            </div>
            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control shadow-none" required />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none" id="loginBtn">Login</button>
              <button
                type="button"
                class="btn text-secondary text-decoration-none"
                data-bs-toggle="modal"
                data-bs-dismiss="modal"
                data-bs-target="#accountRecoveryModal"
              >
                Forgot Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Login Modal end -->
  <AccountRecoveryModal />
</template>

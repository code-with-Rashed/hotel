<template>
  <!-- Account Recovery Modal start -->
  <div
    class="modal fade"
    id="accountRecoveryModal"
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
              <i class="bi bi-person-circle fs-3 me-2"></i>Account Recovery
            </h5>
            <button
              type="reset"
              class="btn-close"
              aria-label="Close"
              data-bs-toggle="modal"
              data-bs-dismiss="modal"
              data-bs-target="#loginModal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Enter your registered email</label>
              <input
                type="email"
                name="email"
                class="form-control shadow-none"
                maxlength="58"
                required
              />
            </div>
            <div class="mb-2 d-flex align-items-center justify-content-between">
              <button type="submit" class="btn btn-dark shadow-none">SEND RESET LINK</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Account Recovery Modal end -->
</template>

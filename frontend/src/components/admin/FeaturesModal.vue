<template>
  <div
    class="modal fade"
    id="featur-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form id="featur-frm">
        <input
          type="hidden"
          name="CSRF_TOKEN"
          id="CSRF_TOKEN"
          value="d43f70ba414fabe4d0d1182f06f26a11"
        />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Featur</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Featur Name</label>
              <input
                type="text"
                id="featur_name"
                class="form-control shadow-none"
                title="Enter a new Feauter Name"
                maxlength="20"
                required
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary text-white shadow-none">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

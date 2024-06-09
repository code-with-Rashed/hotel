<template>
  <div
    class="modal fade"
    id="facility-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form id="facility-frm">
        <input
          type="hidden"
          name="CSRF_TOKEN"
          id="CSRF_TOKEN"
          value="d43f70ba414fabe4d0d1182f06f26a11"
        />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Facility</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Picture</label>
              <input
                type="file"
                id="facility_picture_inp"
                class="form-control shadow-none"
                title="Enter a new Facility Picture (svg format)"
                accept=".svg"
                required
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Name</label>
              <input
                type="text"
                id="facility_name_inp"
                class="form-control shadow-none"
                title="Enter a new Facility Name"
                maxlength="20"
                required
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Facility Description</label>
              <textarea
                id="facility_description_inp"
                class="form-control shadow-none"
                rows="5"
                maxlength="250"
              ></textarea>
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

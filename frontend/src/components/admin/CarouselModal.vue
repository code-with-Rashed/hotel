<template>
  <div
    class="modal fade"
    id="carousel-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <form id="carousel-frm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Carousel Image</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Carousel Picture</label>
              <input
                type="file"
                name="carousel_picture"
                id="carousel_picture_inp"
                class="form-control shadow-none"
                title="Enter a new Carousel Picture"
                accept="image/*"
                required
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary text-white shadow-none">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

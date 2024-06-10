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
          <form>
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
                      required
                      value="XYZ Road , ABC Building New Yourk, USA"
                    />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">E-mail</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"
                      ><i class="bi bi-envelope-fill"></i
                    ></span>
                    <input
                      type="email"
                      name="email"
                      class="form-control shadow-none"
                      title="Enter your location Address link"
                      maxlength="255"
                      required
                      value="hotel@support.com"
                    />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Contact Number</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text border-0"
                      ><i class="bi bi-telephone-fill"></i
                    ></span>
                    <input
                      type="text"
                      name="phone"
                      class="form-control shadow-none"
                      title="Enter your official Phone Number"
                      maxlength="15"
                      value="88 01921042138"
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Facebook link</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"><i class="bi bi-facebook"></i></span>
                    <input
                      type="url"
                      name="facebook"
                      class="form-control shadow-none"
                      title="Enter your Facebook link"
                      maxlength="255"
                      required
                      value="https://facebook.com"
                    />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Twitter link</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"><i class="bi bi-twitter"></i></span>
                    <input
                      type="url"
                      name="twitter"
                      class="form-control shadow-none"
                      title="Enter your Twitter link"
                      maxlength="255"
                      required
                      value="https://twitter.com"
                    />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Linkedin link</label>
                  <div class="input-group">
                    <span class="input-group-text border-0"><i class="bi bi-instagram"></i></span>
                    <input
                      type="url"
                      name="instagram"
                      class="form-control shadow-none"
                      title="Enter your Instagram link"
                      maxlength="255"
                      required
                      value="https://linkedin.com"
                    />
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
                      name="iframe_link"
                      class="form-control shadow-none"
                      title="Enter your Iframe link"
                      required
                      value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387194.06225701555!2d-74.30932678804537!3d40.697019288954785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1700986766942!5m2!1sen!2sbd"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">SAVE</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

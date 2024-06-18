<template>
  <!-- Register Modal start -->
  <div
    class="modal fade"
    id="registerModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-lines-fill fs-3 me-2"></i>User Registration
            </h5>
            <button
              type="reset"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note : Your details must match with your Id (Passport , Driving license , etc.) that
              will be required during check-in.
            </span>
            <div class="container-flued">
              <div class="row">
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Name</label>
                  <input
                    type="name"
                    name="name"
                    class="form-control shadow-none"
                    maxlength="38"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Email</label>
                  <input
                    type="email"
                    name="email"
                    class="form-control shadow-none"
                    maxlength="58"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Phone Number</label>
                  <input
                    type="number"
                    name="phone"
                    class="form-control shadow-none"
                    maxlength="15"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Pincode</label>
                  <input
                    type="number"
                    name="pincode"
                    class="form-control shadow-none"
                    maxlength="10"
                    required
                  />
                </div>
                <div class="col-md-12 mb-3 p-0">
                  <label class="form-label">Address</label>
                  <textarea
                    class="form-control shadow-none"
                    name="address"
                    rows="1"
                    maxlength="248"
                    required
                  ></textarea>
                </div>
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" name="dob" class="form-control shadow-none" required />
                </div>
                <div class="col-md-6 mb-3 p-0">
                  <label class="form-label">Profile Picture</label>
                  <input
                    type="file"
                    name="profile"
                    accept=".jpeg,.png,.webp,.jpg"
                    class="form-control shadow-none"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3 ps-0">
                  <label class="form-label">Password</label>
                  <input
                    type="password"
                    name="password"
                    class="form-control shadow-none"
                    required
                  />
                </div>
                <div class="col-md-6 mb-4 p-0">
                  <label class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    name="confirm_password"
                    class="form-control shadow-none"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-dark" id="registerBtn">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Register Modal end -->
</template>

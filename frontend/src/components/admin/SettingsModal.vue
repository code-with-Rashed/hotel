<template>
  <!-- Genarel Modal -->
  <div
    class="modal fade"
    id="general-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form id="general-frm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">General Settings</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Site Title</label>
              <input
                type="text"
                name="site_title"
                id="site_title_inp"
                class="form-control shadow-none"
                title="Enter your site title"
                maxlength="50"
                required
                value="Hotel"
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">About us</label>
              <textarea
                name="site_about"
                id="site_about_inp"
                rows="6"
                class="form-control shadow-none"
                title="About description your site "
                maxlength="250"
                required
              >
About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus .
              </textarea>
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

  <!-- Favicon Modal -->
  <div
    class="modal fade"
    id="favicon-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form id="favicon-frm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Set Favicon</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Favicon</label>
              <input
                type="file"
                name="favicon"
                class="form-control shadow-none"
                title="Set your favicon"
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

  <!-- Team Modal -->
  <div
    class="modal fade"
    id="team-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <form id="team-frm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Team Member</h5>
            <button
              type="button"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Member Name</label>
              <input
                type="text"
                name="member_name"
                class="form-control shadow-none"
                title="Enter a new Member Name"
                maxlength="30"
                required
              />
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Member Picture</label>
              <input
                type="file"
                name="member_picture"
                class="form-control shadow-none"
                title="Enter a new Member Picture"
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

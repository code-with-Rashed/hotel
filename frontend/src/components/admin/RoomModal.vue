<template>
  <!-- Room Data Modal -->
  <div
    class="modal fade"
    id="room-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <form id="room-frm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Room</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Name</label>
                <input
                  type="text"
                  name="name"
                  class="form-control shadow-none"
                  maxlength="40"
                  title="Enter a new Room name"
                  required
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Aria</label>
                <input
                  type="number"
                  name="aria"
                  class="form-control shadow-none"
                  min="2"
                  maxlength="4"
                  title="Enter a new Room Square fit."
                  required
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Price</label>
                <input
                  type="number"
                  name="price"
                  class="form-control shadow-none"
                  min="2"
                  maxlength="6"
                  title="Enter a new Room Price"
                  required
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Quantity (max.)</label>
                <input
                  type="number"
                  name="quantity"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="3"
                  title="Enter total room quantity"
                  required
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adult (max.)</label>
                <input
                  type="number"
                  name="adult"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="2"
                  title="Enter adult quantity"
                  required
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Children (max.)</label>
                <input
                  type="number"
                  name="children"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="2"
                  title="Enter child quantity"
                  required
                />
              </div>
              <div class="col-md-12 mb-4">
                <h6 class="fw-bold">Features</h6>
                <label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="5" />
                  Belcony </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="3" />
                  Buth </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="9" />
                  Door </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="4" />
                  Window
                </label>
              </div>
              <div class="col-md-12 mb-4">
                <h6 class="fw-bold">Facilities</h6>
                <label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="4" />
                  wifi </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="5" />
                  Telivision </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="6" />
                  Ac </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="7" />
                  Cleaner </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="8" />
                  Hitter </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="9" />
                  Micro oven
                </label>
              </div>
              <div class="col mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea
                  name="description"
                  rows="3"
                  maxlength="1000"
                  class="form-control shadow-none"
                  title="Enter Room Description"
                  required
                ></textarea>
              </div>
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

  <!--Edit Room Data Modal -->
  <div
    class="modal fade"
    id="edit-room-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <form id="edit-room-frm">
        <input type="hidden" name="room_id" />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Room</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Name</label>
                <input
                  type="text"
                  name="name"
                  class="form-control shadow-none"
                  maxlength="40"
                  title="Enter a new Room name"
                  required
                  value="Dulex"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Aria</label>
                <input
                  type="number"
                  name="area"
                  class="form-control shadow-none"
                  min="2"
                  maxlength="4"
                  title="Enter a new Room Square fit."
                  required
                  value="120"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Price</label>
                <input
                  type="number"
                  name="price"
                  class="form-control shadow-none"
                  min="2"
                  maxlength="6"
                  title="Enter a new Room Price"
                  required
                  value="5000"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Quantity (max.)</label>
                <input
                  type="number"
                  name="quantity"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="3"
                  title="Enter total room quantity"
                  required
                  value="10"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adult (max.)</label>
                <input
                  type="number"
                  name="adult"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="2"
                  title="Enter adult quantity"
                  required
                  value="5"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Children (max.)</label>
                <input
                  type="number"
                  name="children"
                  class="form-control shadow-none"
                  min="1"
                  maxlength="2"
                  title="Enter child quantity"
                  required
                  value="5"
                />
              </div>
              <div class="col-md-12 mb-4">
                <h6 class="fw-bold">Features</h6>
                <label class="form-check-label me-3 pointer">
                  <input
                    type="checkbox"
                    name="features"
                    class="form-check-input"
                    value="5"
                    checked
                  />
                  Belcony </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="3" />
                  Buth </label
                ><label class="form-check-label me-3 pointer">
                  <input
                    type="checkbox"
                    name="features"
                    class="form-check-input"
                    value="9"
                    checked
                  />
                  Door </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="features" class="form-check-input" value="4" />
                  Window
                </label>
              </div>
              <div class="col-md-12 mb-4">
                <h6 class="fw-bold">Facilities</h6>
                <label class="form-check-label me-3 pointer">
                  <input
                    type="checkbox"
                    name="facilities"
                    class="form-check-input"
                    value="4"
                    checked
                  />
                  wifi </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="5" />
                  Telivision </label
                ><label class="form-check-label me-3 pointer">
                  <input
                    type="checkbox"
                    name="facilities"
                    class="form-check-input"
                    value="6"
                    checked
                  />
                  Ac </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="7" />
                  Cleaner </label
                ><label class="form-check-label me-3 pointer">
                  <input
                    type="checkbox"
                    name="facilities"
                    class="form-check-input"
                    value="8"
                    checked
                  />
                  Hitter </label
                ><label class="form-check-label me-3 pointer">
                  <input type="checkbox" name="facilities" class="form-check-input" value="9" />
                  Micro oven
                </label>
              </div>
              <div class="col mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea
                  name="description"
                  rows="3"
                  maxlength="1000"
                  class="form-control shadow-none"
                  title="Enter Room Description"
                  required
                >
About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus About Lorem
About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus About Lorem
About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus About Lorem
About Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis error voluptatem minus saepe asperiores ab, ducimus tempore optio aut exercitationem? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, voluptatibus About Lorem</textarea
                >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary text-white shadow-none">UPDATE</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Image Modal -->
  <div
    class="modal fade"
    id="room-img-s"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="room-img-frm">
          <input type="hidden" name="CSRF_TOKEN" value="<?php echo $CSRF_TOKEN;?>" />
          <input type="hidden" name="room_id" />
          <div class="modal-header">
            <h5 class="modal-title" id="room_name">Add New Room Image</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body" id="room-img-message">
            <div class="mb-3">
              <label class="form-label fw-bold">Room Picture</label>
              <input
                type="file"
                name="room_img"
                class="form-control shadow-none"
                title="Enter a new Room Picture"
                accept="image/*"
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
        </form>
        <div class="row px-4 mt-4">
          <table class="table">
            <thead class="bg-dark text-white">
              <tr>
                <th>Images</th>
                <th>Thumbnail</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="room-img-data">
              <tr>
                <td>
                  <img
                    src="http://localhost/hotel/images/rooms/IMG11314.jpg"
                    alt="img"
                    width="250px"
                  />
                </td>
                <td>
                  <button class="btn btn-primary" title="Set Thumbnail">
                    <i class="bi bi-check2-circle"></i>
                  </button>
                </td>
                <td>
                  <button class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                </td>
              </tr>
              <tr>
                <td>
                  <img
                    src="http://localhost/hotel/images/rooms/IMG80276.png"
                    alt="img"
                    width="250px"
                  />
                </td>
                <td>
                  <button class="btn btn-secondary" title="Set Thumbnail">
                    <i class="bi bi-check2-circle"></i>
                  </button>
                </td>
                <td>
                  <button class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

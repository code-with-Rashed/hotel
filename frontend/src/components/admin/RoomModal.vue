<script setup>
import { ref, reactive, watch } from 'vue'
import useRoomApi from '@/composables/admin/roomApi'
import useRoomImageApi from '@/composables/admin/roomImageApi'
import ToastMessage from '@/components/ToastMessage.vue'
import { useToastMessageStore } from '@/stores/toastMessage'
import { hideBsModal } from '@/helpers/hideBsModal'

const props = defineProps({
  instruction: String,
  deleteRoomId: Number,
  editRoomId: Number,
  roomId: Number
})

const { results, errors, post, destroy, show, put } = useRoomApi()
const {
  results: roomImageResults,
  errors: roomImageErrors,
  get,
  post: postNewRoomImage,
  put: updateImage,
  thumbnail,
  destroy: destroyRoomImage
} = useRoomImageApi()
const storeToastMessage = useToastMessageStore()

// handle props instruction
watch(props, (propsValues) => {
  if (propsValues.instruction == 'show') {
    showRoom(propsValues.editRoomId)
  }
  if (propsValues.instruction == 'manage-room-image') {
    showRoomImage(propsValues.roomId)
  }
})
//----------------

// add new room record
const addRoomSubmitBtn = ref(true)
const newRoom = reactive({
  name: '',
  price: '',
  quantity: '',
  area: '',
  adult: '',
  children: '',
  description: ''
})
const addNewRoom = async () => {
  addRoomSubmitBtn.value = false
  await post(newRoom)
  addRoomSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('addRoomModal')
    newRoom.name = ''
    newRoom.price = ''
    newRoom.quantity = ''
    newRoom.area = ''
    newRoom.adult = ''
    newRoom.children = ''
    newRoom.description = ''
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
//--------------------

// update room record
const updateRoomSubmitBtn = ref(true)
const editRoom = reactive({
  name: '',
  price: '',
  quantity: '',
  area: '',
  adult: '',
  children: '',
  description: ''
})
const updateRoom = async () => {
  updateRoomSubmitBtn.value = false
  await put(props.editRoomId, editRoom)
  updateRoomSubmitBtn.value = true
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('editRoomModal')
  } else {
    let message = ''
    message += '<strong>' + results.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(results.value.success, message, 10000)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// ----------------

// show room record
const showRoom = async (id) => {
  await show(id)
  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    editRoom.name = results.value.data.room.name
    editRoom.price = results.value.data.room.price
    editRoom.quantity = results.value.data.room.quantity
    editRoom.area = results.value.data.room.area
    editRoom.adult = results.value.data.room.adult
    editRoom.children = results.value.data.room.children
    editRoom.description = results.value.data.room.description
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// ----------------

// delete room record
const deleteRoomSubmitBtn = ref(true)
const deleteRoomRecord = async () => {
  deleteRoomSubmitBtn.value = false
  await destroy(props.deleteRoomId)
  deleteRoomSubmitBtn.value = true

  if (results.value.success) {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
    hideBsModal('deleteRoomModal')
  } else {
    storeToastMessage.showToastMessage(results.value.success, results.value.message)
  }
  if (errors.value) {
    storeToastMessage.showToastMessage(false, errors.value.message)
  }
}
// ---------------------

// manage room images

// show room imaged
const reloader = ref(true)
const showRoomImage = async (id) => {
  reloader.value = false
  await get(id)
  reloader.value = true
  if (roomImageResults.value.success) {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  } else {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  }
  if (roomImageErrors.value) {
    storeToastMessage.showToastMessage(false, roomImageErrors.value.message)
  }
}

// update room image thumbnail
const changeThumbnail = async (id) => {
  await thumbnail(id)
  if (roomImageResults.value.success) {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  } else {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  }
  if (roomImageErrors.value) {
    storeToastMessage.showToastMessage(false, roomImageErrors.value.message)
  }
  await showRoomImage(props.roomId)
}

// delete room image
const deleteRoomImage = async (id) => {
  await destroyRoomImage(id)
  if (roomImageResults.value.success) {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  } else {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
  }
  if (roomImageErrors.value) {
    storeToastMessage.showToastMessage(false, roomImageErrors.value.message)
  }
  await showRoomImage(props.roomId)
}

// handle room image
const newRoomImage = ref()
const tempRoomImage = ref()
const selectRoomImage = (event) => {
  newRoomImage.value = event.target.files[0]
  tempRoomImage.value = URL.createObjectURL(newRoomImage.value)
}
//------------------------

// post new room image
const postRoomImageSubmitBtn = ref(true)
const postRoomImage = async () => {
  postRoomImageSubmitBtn.value = false
  await postNewRoomImage(props.roomId, newRoomImage)
  postRoomImageSubmitBtn.value = true

  if (roomImageResults.value.success) {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
    newRoomImage.value = null
    tempRoomImage.value = null
  } else {
    let message = ''
    message += '<strong>' + roomImageResults.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(roomImageResults.value.success, message, 10000)
  }
  if (roomImageErrors.value) {
    storeToastMessage.showToastMessage(false, roomImageErrors.value.message)
  }
  await showRoomImage(props.roomId)
}
// --------------------

// handle room image for updating
const updatedRoomImage = ref()
const temporaryRoomImage = ref()
const changeRoomImage = (event) => {
  updatedRoomImage.value = event.target.files[0]
  temporaryRoomImage.value = URL.createObjectURL(updatedRoomImage.value)
}
//------------------------

// open modal for editing room image
const roomImageId = ref(0)
const editRoomImage = (id, imgUrl) => {
  temporaryRoomImage.value = imgUrl
  roomImageId.value = id
}

// update room image
const updateRoomImageSubmitBtn = ref(true)
const updateRoomImage = async (id) => {
  updateRoomImageSubmitBtn.value = false
  await updateImage(id, updatedRoomImage)
  updateRoomImageSubmitBtn.value = true

  if (roomImageResults.value.success) {
    storeToastMessage.showToastMessage(
      roomImageResults.value.success,
      roomImageResults.value.message
    )
    updatedRoomImage.value = null
    temporaryRoomImage.value = null
    hideBsModal('updateRoomImageModal')
  } else {
    let message = ''
    message += '<strong>' + roomImageResults.value.message + '</strong><br>'
    if (results.value.message == 'validation error') {
      results.value.data.forEach((element) => {
        message += element + '<br>'
      })
    }
    storeToastMessage.showToastMessage(roomImageResults.value.success, message, 10000)
  }
  if (roomImageErrors.value) {
    storeToastMessage.showToastMessage(false, roomImageErrors.value.message)
  }
}
</script>
<template>
  <!-- Add Room Data Modal -->
  <div
    class="modal fade"
    id="addRoomModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <form @submit.prevent="addNewRoom">
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
                  maxlength="60"
                  title="Enter a new Room name"
                  required
                  v-model.trim="newRoom.name"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Price ( per day )</label>
                <input
                  type="number"
                  name="price"
                  class="form-control shadow-none"
                  min="2"
                  maxlength="6"
                  title="Enter a new Room Price"
                  required
                  v-model.number="newRoom.price"
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
                  v-model.number="newRoom.quantity"
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
                  v-model.number="newRoom.area"
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
                  v-model.number="newRoom.adult"
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
                  v-model.number="newRoom.children"
                />
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
                  v-model.trim="newRoom.description"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="addRoomSubmitBtn"
            >
              SUBMIT
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status"> Proccssing...</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!--Edit Room Data Modal -->
  <div
    class="modal fade"
    id="editRoomModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <form @submit.prevent="updateRoom">
        <input type="hidden" name="room_id" />
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Room</h5>
            <button
              type="button"
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
                  maxlength="60"
                  title="Edit the Room name"
                  required
                  v-model.trim="editRoom.name"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Price</label>
                <input
                  type="number"
                  name="price"
                  class="form-control shadow-none"
                  min="2"
                  title="Edit Room Price"
                  required
                  v-model.number="editRoom.price"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Quantity (max.)</label>
                <input
                  type="number"
                  name="quantity"
                  class="form-control shadow-none"
                  min="1"
                  title="Edit room quantity"
                  required
                  v-model.number="editRoom.quantity"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Room Aria</label>
                <input
                  type="number"
                  name="area"
                  class="form-control shadow-none"
                  min="2"
                  title="Edit Room Square fit."
                  required
                  v-model.number="editRoom.area"
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
                  title="Edit adult quantity"
                  required
                  v-model.number="editRoom.adult"
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
                  title="Edit child quantity"
                  required
                  v-model.number="editRoom.children"
                />
              </div>
              <div class="col mb-2">
                <label class="form-label fw-bold">Description</label>
                <textarea
                  name="description"
                  rows="3"
                  maxlength="1000"
                  class="form-control shadow-none"
                  title="Edit Room Description"
                  required
                  v-model.number="editRoom.description"
                >
                </textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateRoomSubmitBtn"
            >
              UPDATE
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status"> Proccssing...</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Image Modal -->
  <div
    class="modal fade"
    id="roomImageModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="postRoomImage">
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
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Room Picture</label>
              <input
                type="file"
                class="form-control shadow-none"
                title="Enter a new Room Picture"
                accept="image/*"
                required
                @change="selectRoomImage"
              />
            </div>
            <div class="mb-3" v-if="tempRoomImage">
              <img :src="tempRoomImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="postRoomImageSubmitBtn"
            >
              SUBMIT
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status"> Proccssing...</span>
            </button>
          </div>
        </form>
        <div class="row px-4 mt-4">
          <div class="col-12 text-center my-3">
            <button type="button" class="btn btn-sm btn-primary" @click="showRoomImage(roomId)">
              Reload
              <span class="badge text-bg-secondary"> <i class="bi bi-arrow-repeat"></i> </span>
            </button>
          </div>
          <table class="table">
            <thead class="bg-dark text-white">
              <tr>
                <th>Images</th>
                <th>Thumbnail</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="reloader">
                <template v-if="roomImageResults.data">
                  <template v-for="roomImage in roomImageResults.data.images" :key="roomImage.id">
                    <tr>
                      <td>
                        <img :src="roomImage.image" alt="room-img" width="250px" />
                      </td>
                      <td>
                        <button
                          class="btn btn-primary"
                          title="This room image is active thumbnail . Change Thumbnail Status"
                          v-if="roomImage.thumbnail"
                          @click="changeThumbnail(roomImage.id)"
                        >
                          <i class="bi bi-check2-circle"></i>
                        </button>
                        <button
                          class="btn btn-secondary"
                          title="Change Thumbnail Status"
                          @click="changeThumbnail(roomImage.id)"
                          v-else
                        >
                          <i class="bi bi-check2-circle"></i>
                        </button>
                      </td>
                      <td>
                        <button
                          class="btn btn-primary me-1"
                          @click="editRoomImage(roomImage.id, roomImage.image)"
                          data-bs-target="#updateRoomImageModal"
                          data-bs-toggle="modal"
                        >
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger" @click="deleteRoomImage(roomImage.id)">
                          <i class="bi bi-trash"></i> Delete
                        </button>
                      </td>
                    </tr>
                  </template>
                </template>
              </template>
              <template v-else>
                <tr class="text-center">
                  <td colspan="3">
                    <div class="spinner-border my-4" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Room Image Modal -->
  <div
    class="modal fade"
    id="updateRoomImageModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="updateRoomImage(roomImageId)">
          <div class="modal-header">
            <h5 class="modal-title">Change Room Image</h5>
            <button
              type="reset"
              class="btn-close shadow-none"
              data-bs-dismiss="modal"
              aria-label="Close"
              data-bs-target="#roomImageModal"
              data-bs-toggle="modal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Room Picture</label>
              <input
                type="file"
                class="form-control shadow-none"
                title="Enter a new Room Picture"
                accept="image/*"
                required
                @change="changeRoomImage"
              />
            </div>
            <div class="mb-3" v-if="temporaryRoomImage">
              <img :src="temporaryRoomImage" alt="preview image" class="img-fluid" />
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="reset"
              class="btn text-secondary shadow-none"
              data-bs-dismiss="modal"
              data-bs-target="#roomImageModal"
              data-bs-toggle="modal"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="btn btn-primary text-white shadow-none"
              v-if="updateRoomImageSubmitBtn"
            >
              UPDATE
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status">Proccssing...</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- delete room modal start -->
  <div
    class="modal fade"
    id="deleteRoomModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-modal="true"
    role="dialog"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Delete Feature Record</h5>
          <button
            type="button"
            class="btn-close shadow-none"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <p class="fw-bold text-center text-danger">
              Are you sure ? you wan't to delete this room record !
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-danger text-white shadow-none"
            @click="deleteRoomRecord()"
            v-if="deleteRoomSubmitBtn"
          >
            DELETE
          </button>
          <button class="btn btn-primary" type="button" disabled v-else>
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status"> Proccssing...</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <ToastMessage />
</template>

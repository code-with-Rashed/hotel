<script setup>
import LayoutView from './layout/LayoutView.vue'
import RoomModal from '../../components/admin/RoomModal.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Rooms</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Rooms</h5>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#room-s"
              >
                <i class="bi bi-plus-square"></i>
                Add
              </button>
            </div>
            <div class="row px-3">
              <div class="table-responsive-lg">
                <table class="table border table-hover text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Area</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Guest</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="room-data">
                    <tr>
                      <td>1</td>
                      <td>Rooms</td>
                      <td>120 s-f</td>
                      <td>৳&nbsp; 2000</td>
                      <td>1</td>
                      <td>
                        <span class="badge rounded-pill bg-light text-dark text-wrap">5 Adult</span>
                        <span class="badge rounded-pill bg-light text-dark text-wrap"
                          >5 Children</span
                        >
                      </td>
                      <td>
                        <button class="btn btn-sm shadow-none btn-primary">Active</button>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-sm shadow-none btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#room-img-s"
                          title="Add Img"
                        >
                          <i class="bi bi-images"></i>
                        </button>
                        <button
                          type="button"
                          class="btn btn-sm shadow-none btn-secondary mx-1"
                          data-bs-toggle="modal"
                          data-bs-target="#edit-room-s"
                          title="Edit"
                        >
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button
                          type="button"
                          class="btn btn-sm shadow-none btn-danger"
                          title="Delete"
                        >
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- pagination start -->
                <ul class="pagination mt-2" id="pagination">
                  <li class="page-item">
                    <a class="page-link" type="button">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" type="button">Next</a>
                  </li>
                </ul>
                <!-- pagination end -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <RoomModal />
</template>

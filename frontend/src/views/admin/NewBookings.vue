<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>New Bookings Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">New Bookings</h5>
              <div class="text-end">
                <input
                  type="search"
                  id="search_new_booking"
                  class="form-control shadow-none"
                  placeholder="search"
                />
              </div>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-light">
                  <tr>
                    <th>ID</th>
                    <th>User Details</th>
                    <th>Room Details</th>
                    <th>Booking Details</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>

                    <td>
                      <span class="badge bg-primary">
                        Order Id :&nbsp;&nbsp; SSLCZ_TEST_665a32a8f0521
                      </span>
                      <br />
                      <b>Name : </b> Rashed islam
                      <br />
                      <b>Phone : </b> 01921083321
                    </td>

                    <td>
                      <b>Room : </b> Rooms
                      <br />
                      <b>Price : </b>৳ 2000
                    </td>

                    <td>
                      <b>Checkin : </b> 01/06/2024
                      <br />
                      <b>Checkout : </b> 04/06/2024
                      <br />
                      <b>Paid : </b>৳ 6000
                      <br />
                      <b>Order Date : </b> 01/06/2024
                    </td>

                    <td>
                      <button
                        class="btn text-white fw-bold btn-sm btn-primary shadow-none"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#assign_room"
                      >
                        <i class="bi bi-check2-square"></i> Assign Room
                      </button>
                      <br />
                      <button
                        class="btn text-white fw-bold btn-sm btn-danger shadow-none mt-1"
                        type="button"
                      >
                        <i class="bi bi-trash"></i> Cancel Booking
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>

                    <td>
                      <span class="badge bg-primary">
                        Order Id :&nbsp;&nbsp; SSLCZ_TEST_665a32a8f0521
                      </span>
                      <br />
                      <b>Name : </b> Rashed islam
                      <br />
                      <b>Phone : </b> 01921083321
                    </td>

                    <td>
                      <b>Room : </b> Rooms
                      <br />
                      <b>Price : </b>৳ 2000
                    </td>

                    <td>
                      <b>Checkin : </b> 01/06/2024
                      <br />
                      <b>Checkout : </b> 04/06/2024
                      <br />
                      <b>Paid : </b>৳ 6000
                      <br />
                      <b>Order Date : </b> 01/06/2024
                    </td>

                    <td>
                      <button
                        class="btn text-white fw-bold btn-sm btn-primary shadow-none"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#assign_room"
                      >
                        <i class="bi bi-check2-square"></i> Assign Room
                      </button>
                      <br />
                      <button
                        class="btn text-white fw-bold btn-sm btn-danger shadow-none mt-1"
                        type="button"
                      >
                        <i class="bi bi-trash"></i> Cancel Booking
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <ul class="pagination mt-2" id="pagination">
                <li class="page-item disabled">
                  <a href="?page=0" class="page-link" type="button">Previous</a>
                </li>
                <li class="page-item">
                  <a href="?page=2" class="page-link" type="button">Next</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

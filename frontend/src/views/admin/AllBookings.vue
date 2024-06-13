<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>All Bookings Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">All Bookings</h5>
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
                    <th>Status</th>
                    <th>Invoice</th>
                  </tr>
                </thead>
                <tbody id="table-data">
                  <tr>
                    <td>1</td>

                    <td>
                      <span class="badge bg-primary">
                        Order Id :&nbsp;&nbsp; SSLCZ_TEST_66575cf2c1d5a
                      </span>
                      <br />
                      <b>Name : </b> Rashed islam
                      <br />
                      <b>Phone : </b> 01921083214
                    </td>

                    <td>
                      <b>Room : </b> Cupple
                      <br />
                      <b>Price : </b>৳ 45654
                    </td>

                    <td>
                      <b>Checkin : </b> 01/06/2024
                      <br />
                      <b>Checkout : </b> 03/06/2024
                      <br />
                      <b>Paid : </b>৳ 91308
                      <br />
                      <b>Order Date : </b> 29/05/2024
                    </td>

                    <td>
                      <span class="btn text-white fw-bold btn-sm bg-danger shadow-none"
                        >refunded</span
                      >
                    </td>

                    <td>
                      <span
                        class="btn text-white fw-bold btn-sm bg-primary shadow-none"
                        title="Download Invoice"
                        ><i class="bi bi-file-earmark-arrow-down fw-bold"></i> Invoice</span
                      >
                    </td>
                  </tr>

                  <tr>
                    <td>2</td>

                    <td>
                      <span class="badge bg-primary">
                        Order Id :&nbsp;&nbsp; SSLCZ_TEST_66575cb0cde63
                      </span>
                      <br />
                      <b>Name : </b> Rashed alam
                      <br />
                      <b>Phone : </b> 01860491387
                    </td>

                    <td>
                      <b>Room : </b> Laxary
                      <br />
                      <b>Price : </b>৳ 3223
                    </td>

                    <td>
                      <b>Checkin : </b> 29/05/2024
                      <br />
                      <b>Checkout : </b> 31/05/2024
                      <br />
                      <b>Paid : </b>৳ 6446
                      <br />
                      <b>Order Date : </b> 29/05/2024
                    </td>

                    <td>
                      <span class="btn text-white fw-bold btn-sm bg-danger shadow-none"
                        >refunded</span
                      >
                    </td>

                    <td>
                      <span
                        class="btn text-white fw-bold btn-sm bg-primary shadow-none"
                        title="Download Invoice"
                        ><i class="bi bi-file-earmark-arrow-down fw-bold"></i> Invoice</span
                      >
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

<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Ratings & Reviews Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Rating &amp; Review List</h5>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th width="5%">No.</th>
                    <th>Roomname</th>
                    <th>Username</th>
                    <th>Message</th>
                    <th>Date &amp; Time</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Laxary</td>
                    <td>Rashed islam</td>
                    <td>This room is very comfortable.</td>
                    <td>27/05/2024 04:17 PM</td>
                    <td>
                      <Button class="btn btn-sm btn-success rounded shadow-none m-1"
                        ><i class="bi bi-eye"></i> Active</Button
                      >
                      <Button class="btn btn-sm btn-danger rounded shadow-none m-1"
                        ><i class="bi bi-trash"></i> Delete</Button
                      >
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Laxary</td>
                    <td>Rashed islam</td>
                    <td>This room is very comfortable.</td>
                    <td>27/05/2024 04:17 PM</td>
                    <td>
                      <Button class="btn btn-sm btn-warning rounded shadow-none m-1"
                        ><i class="bi bi-eye"></i> In-Active</Button
                      >
                      <Button class="btn btn-sm btn-danger rounded shadow-none m-1"
                        ><i class="bi bi-trash"></i> Delete</Button
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

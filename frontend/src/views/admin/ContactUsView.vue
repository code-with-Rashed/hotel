<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Contact Request Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Contact Us List</h5>
              <div>
                <button
                  class="btn btn-success btn-sm shadow-none m-1"
                  type="button"
                  title="Mark all readed ."
                >
                  <i class="bi bi-eye"></i> Seen All
                </button>
                <button
                  class="btn btn-danger btn-sm shadow-none m-1"
                  type="button"
                  title="Delete all messages ."
                >
                  <i class="bi bi-trash"></i> Delete All
                </button>
              </div>
            </div>
            <div class="row">
              <table class="table table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th width="5%">No.</th>
                    <th width="12%">Name</th>
                    <th width="15%">Email</th>
                    <th width="19%">Subject</th>
                    <th width="30%">Message</th>
                    <th width="10%">Date</th>
                    <th width="9%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Test</td>
                    <td>test@gmail.com</td>
                    <td>test</td>
                    <td>test</td>
                    <td>22/05/2024</td>
                    <td>
                      <button
                        class="btn btn-sm btn-danger mt-1 rounded shadow-none"
                        title="Delete this message ."
                      >
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Test</td>
                    <td>test@gmail.com</td>
                    <td>test</td>
                    <td>test</td>
                    <td>22/05/2024</td>
                    <td>
                      <button
                        class="btn btn-sm btn-danger mt-1 rounded shadow-none"
                        title="Delete this message ."
                      >
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Test</td>
                    <td>test@gmail.com</td>
                    <td>test</td>
                    <td>test</td>
                    <td>22/05/2024</td>
                    <td>
                      <button
                        class="btn btn-sm btn-danger mt-1 rounded shadow-none"
                        title="Delete this message ."
                      >
                        <i class="bi bi-trash"></i> Delete
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

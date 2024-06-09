<script setup>
import LayoutView from './layout/LayoutView.vue'
import FeaturesModal from '@/components/admin/FeaturesModal.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Feature Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Features</h5>
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn btn-dark btn-sm shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#featur-s"
              >
                <i class="bi bi-plus-square"></i>
                Add Featur
              </button>
            </div>
            <div class="row px-3">
              <table class="table">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>Featur Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="featur-data">
                  <tr>
                    <td>Belcony</td>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger shadow-none">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>Buth</td>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger shadow-none">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>Door</td>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger shadow-none">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>Window</td>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger shadow-none">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
  <FeaturesModal />
</template>

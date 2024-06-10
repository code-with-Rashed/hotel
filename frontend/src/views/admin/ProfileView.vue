<script setup>
import LayoutView from './layout/LayoutView.vue'
</script>
<template>
  <LayoutView>
    <template #main>
      <div class="row ms-1 mt-5">
        <h3>Profile Management</h3>
        <div class="card mb-4 border-0 shadow-sm">
          <div class="card-body">
            <div class="row py-3">
              <!-- Profile Update Area Start -->
              <div class="col-md-6">
                <form class="shadow rounded p-4">
                  <div class="mb-4">
                    <img
                      src="https://i.vimeocdn.com/portrait/62976452_640x640"
                      alt="Profile-Photo"
                      class="rounded-circle w-25"
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="photo" class="mb-1">Change Photo</label>
                    <input type="file" id="photo" class="form-control" accept="image/*" />
                  </div>
                  <div class="form-group mb-3">
                    <label for="name" class="mb-1">Name</label>
                    <input
                      type="text"
                      id="name"
                      class="form-control"
                      value="Rashed alam"
                      maxlength="30"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="email" class="mb-1">Email</label>
                    <input
                      type="email"
                      id="email"
                      class="form-control"
                      value="user@mail.com"
                      maxlength="50"
                      required
                    />
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>
              </div>
              <!-- Profile Update Area End -->
              <!-- Change Password Area Start -->
              <div class="col-md-6">
                <form class="shadow rounded p-4">
                  <p class="h5 fw-bold mb-3">Update Password</p>
                  <div class="form-group mb-3">
                    <label for="oldPassword" class="mb-1">Old Password</label>
                    <input
                      type="password"
                      id="oldPassword"
                      class="form-control"
                      placeholder="Enter old password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="newPassword" class="mb-1">New Password</label>
                    <input
                      type="password"
                      id="newPassword"
                      class="form-control"
                      placeholder="Enter new password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label for="confirmPassword" class="mb-1">Confirm Password</label>
                    <input
                      type="password"
                      id="confirmPassword"
                      class="form-control"
                      placeholder="Enter confirm password"
                      maxlength="25"
                      required
                    />
                  </div>
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
              </div>
              <!-- Change Password Area End -->
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

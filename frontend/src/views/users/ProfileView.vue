<script setup>
import LayoutView from '../visitior/layout/LayoutView.vue'
import { RouterLink } from 'vue-router'
</script>
<template>
  <LayoutView>
    <template #page>
      <div class="container">
        <div class="row">
          <div class="col-12 mb-4 my-5 px-4">
            <h3 class="fw-bold">Profile Details</h3>
            <div style="font-size: 14px">
              <RouterLink :to="{ name: 'home-page' }" class="text-secondary text-decoration-none"
                >Home</RouterLink
              >
              <span class="text-secondary mx-1 fw-bold">&gt;</span>
              <a href="javascript:void(0)" class="text-secondary text-decoration-none">Profile</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 px-3 mb-2">
            <div class="card border-0 shadow-sm p-3">
              <h5>Update Profile Details</h5>
              <form id="profile-form">
                <div class="row p-2">
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Name</label>
                    <input
                      type="name"
                      name="name"
                      class="form-control shadow-none"
                      value="Rashed islam"
                      maxlength="38"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Phone Number</label>
                    <input
                      type="number"
                      name="phone"
                      class="form-control shadow-none"
                      value="01921083453"
                      maxlength="15"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Pincode</label>
                    <input
                      type="number"
                      name="pincode"
                      class="form-control shadow-none"
                      value="123456"
                      maxlength="10"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3 ps-0">
                    <label class="form-label">Date of Birth</label>
                    <input
                      type="date"
                      name="dob"
                      class="form-control shadow-none"
                      value="1999-01-01"
                      required
                    />
                  </div>
                  <div class="col-md-12 mb-3 p-0">
                    <label class="form-label">Address</label>
                    <textarea
                      class="form-control shadow-none"
                      name="address"
                      rows="1"
                      maxlength="248"
                      required
                    >
Dhaka , Bangladesh.
                    </textarea>
                  </div>
                </div>
                <button type="submit" class="btn custom-bg text-white shadow-none">
                  Save Changes
                </button>
              </form>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-6 px-3 mb-2">
            <div class="card border-0 shadow-sm p-3">
              <h5>Update Profile Picture</h5>
              <form id="profile-picture">
                <div class="row p-2">
                  <img
                    src="http://localhost/hotel/images/profile/IMG38857.png"
                    alt="profile"
                    class="rounded-circle mx-auto"
                    style="width: 200px"
                  />
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">New Profile Picture</label>
                    <input
                      type="file"
                      name="profile"
                      accept=".jpeg,.png,.webp,.jpg"
                      class="form-control shadow-none"
                      required
                    />
                  </div>
                </div>
                <button type="submit" class="btn custom-bg text-white shadow-none">
                  Change Profile Image
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 px-3 mb-2">
            <div class="card border-0 shadow-sm p-3">
              <h5>Update Password</h5>
              <form id="password-form">
                <div class="row p-2">
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">Password</label>
                    <input
                      type="password"
                      name="password"
                      class="form-control shadow-none"
                      required
                    />
                  </div>
                  <div class="col-md-12 my-3 ps-0">
                    <label class="form-label">Confirm Password</label>
                    <input
                      type="password"
                      name="confirm-password"
                      class="form-control shadow-none"
                      required
                    />
                  </div>
                </div>
                <button type="submit" class="btn custom-bg text-white shadow-none">
                  Change Password
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </template>
  </LayoutView>
</template>

<template class="bg-light">
  <div class="w-50 m-auto shadow-sm p-4 bg-white mt-5 rounded">
    <img
      src="https://img.freepik.com/premium-vector/hotel-logo-simple-illustration_434503-736.jpg?w=2000"
      alt="logo"
      class="d-block m-auto mb-3 w-25 rounded-circle"
    />
    <p class="h5 text-center mb-4">Login Your Account</p>
    <form>
      <div class="form-group mb-3">
        <label for="email" class="mb-2">Email</label>
        <input
          type="email"
          id="email"
          class="form-control"
          placeholder="Enter your email"
          maxlength="50"
          required
          autofocus
        />
      </div>
      <div class="form-group mb-3">
        <label for="password" class="mb-2">Password</label>
        <input
          type="password"
          id="password"
          class="form-control"
          placeholder="Enter your password"
          maxlength="25"
          required
        />
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</template>

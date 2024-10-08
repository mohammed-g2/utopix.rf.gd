<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-12">
      <form class="glass-bg p-5" action="" method="POST">
        <h4 class="text-center">&#8213; Create a new account &#8213;</h4>
        <hr>
        <div class="mb-3 mt-4">
          <label for="email" class="form-label">Email</label>
          <input value="<?= htmlspecialchars($variables['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" name="email" type="email" class="form-control" id="email" placeholder="email@example.com">
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input value="<?= htmlspecialchars($variables['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" name="username" type="text" class="form-control" id="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input name="password" type="password" class="form-control" id="password">
        </div>
        <div class="text-center mt-5">
          <button type="submit" class="btn btn-red px-5">Sign up</button>
        </div>
      </form>
    </div>
  </div>
</div>
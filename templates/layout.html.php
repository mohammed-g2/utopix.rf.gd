<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Utopix">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Utopix</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
  <!-- Third-party CSS -->
  <link rel="stylesheet" href="/assets/libs/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/libs/css/material-design-iconic-font.min.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body>
  <div class="bg-black py-2 px-3 d-flex justify-content-between text-white">
    <div>
      <?php if ($isAuthenticated): ?>
        <small class="me-2">Welcome, <?= $currentUser->username ?></small> /
        <div class="btn-group">
          <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="zmdi zmdi-settings"></i>
          </button>
          <ul class="dropdown-menu">
            <?php if ($currentUser->hasPermission($permissions['EDIT_POST'])): ?>
              <li><a class="dropdown-item" href="/posts/create">Write</a></li>
            <?php endif; ?>
            <?php if ($currentUser->hasPermission($permissions['EDIT_CATEGORY'])): ?>
              <li><a class="dropdown-item" href="/categories/create">New Category</a></li>
              <li><a class="dropdown-item" href="/categories/list">All Categories</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
          </ul>
        </div>
          <?php else: ?>
            <small><a href="/auth/login" class="text-white"><i class="zmdi zmdi-account"></i> Login</a></small> /
            <small><a href="/users/create" class="text-white">Sign up</a></small>
          <?php endif; ?>
    </div>
    <div>
      <small class="mx-2"><a href="#" class="text-white"><i class="zmdi zmdi-hc-lg zmdi-facebook-box"></i></a></small>
      <small class="mx-2"><a href="#" class="text-white"><i class="zmdi zmdi-hc-lg zmdi-twitter"></i></a></small>
      <small class="mx-2"><a href="#" class="text-white"><i class="zmdi zmdi-hc-lg zmdi-email"></i></a></small>
    </div>
  </div>

  <div class="container-fluid p-0 h-100">
    <div class="row p-0 m-0">
      <div class="col mt-4 mb-4 d-flex justify-content-center p-0 m-0">
        <h1 style="font-size:5em;">
          <a href="/" class="text-black">
            <span style="color:#c00100;">𝖀</span>𝖙𝖔𝖕𝖎𝖝
          </a>
        </h1>
      </div>
    </div>

    <?php include __DIR__ . '/../templates/fragments/flashedmsgs.html.php'; ?>

    <?php include __DIR__ . '/../templates/fragments/navbar.html.php'; ?>

    <div>
      <?= $content ?>
    </div>

    <?php include __DIR__ . '/../templates/fragments/footer.html.php'; ?>

  </div>

  <!-- third part js -->
  <script src="/assets/libs/js/popper.min.js"></script>
  <script src="/assets/libs/js/bootstrap.min.js"></script>
  <!-- app js -->
  <script src="/assets/js/main.js"></script>
</body>

</html>
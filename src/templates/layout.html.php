<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Utopix">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Utopix</title>
  <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
  <!-- Third-party CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"> 
  <!-- App CSS -->
  <link rel="stylesheet" href="/assets/css/base.css">

  <!-- Third-part Scripts -->
  <script src="https://unpkg.com/htmx.org@2.0.2" integrity="sha384-Y7hw+L/jvKeWIRRkqWYfPcvVxHzVzn5REgzbawhxAuQGwX1XWe70vji+VSeHOThJ" crossorigin="anonymous"></script>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-L6N915S8QD"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-L6N915S8QD');
  </script>
</head>

<body>
  <!-- Spinner -->
  <img  id="spinner" class="htmx-indicator" src="/assets/images/800.svg"/>

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
            <img src="/assets/images/header.png" alt="utopix">
          </a>
        </h1>
      </div>
    </div>

    <?php include __DIR__ . '/../templates/fragments/flashedmsgs.html.php'; ?>

    <?php include __DIR__ . '/../templates/fragments/navbar.html.php'; ?>

    <div id="content">
      <?= $content ?>
    </div>

    <?php include __DIR__ . '/../templates/fragments/footer.html.php'; ?>

  </div>

  <!-- third part js -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- app js -->
  <script src="/assets/js/main.js"></script>
</body>

</html>
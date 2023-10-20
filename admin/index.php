<?php require_once '../classes/middlewares.php'; ?>
<?php middleware::session(["id"], "admin/dashboard.php", true); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../assets/imgs/favicon.png"> -->
  <title>Login to dashboard</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Signin page css -->
  <link rel="stylesheet" href="assets/css/signin.css">
  <!-- Custom -->
  <link href="assets/css/custom.css" rel="stylesheet">

</head>

<body>
  <form class="form-signin text-center" id="login">
    <h1 class="mb-3 font-weight-bolder"><b>LMS</b></h1>
    <h5 class="mb-3 font-weight-normal">Login to your account</h5>
    <label for="email" class="sr-only">Email address</label>
    <input type="email" id="email" name="email" class="form-control form-control-sm shadow-none font-12" placeholder="Email address" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password"  class="form-control form-control-sm shadow-none font-12" placeholder="Password" required>
    <div class="checkbox d-flex mb-3">
      <label class="font-12"><input type="checkbox" value="remember-me"> Remember me</label>
      <!-- <a href="forgot-password.php" class="ml-auto text-dark font-12">Forgot password?</a> -->
    </div>
    <button class="btn btn-lg font-12 font-weight-bolder btn-dark btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
  </form>

  <div id="response"></div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="modules/message.js"></script>
  <script src="modules/account/login/js/data.js"></script>

</body>

</html>
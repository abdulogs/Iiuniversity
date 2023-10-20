<?php require_once '../classes/middlewares.php'; ?>
<?php middleware::session(["id", "role"], "admin/dashboard.php", true); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../assets/imgs/favicon.png"> -->
  <title>Forgot password</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Signin page css -->
  <link rel="stylesheet" href="assets/css/signin.css">
  <!-- Custom -->
  <link href="assets/css/custom.css" rel="stylesheet">

</head>

<body>
  <form class="form-signin text-center" id="recovery">
    <h1 class="mb-3 font-weight-bolder"><b>LMS</b></h1>
    <h5 class="mb-3 font-weight-normal">Forgot password</h5>
    <div class="form-group text-left">
      <input type="email" id="email" name="email" class="form-control rounded shadow-none border font-12" placeholder="Email address" required autofocus>
    </div>
    <div class="checkbox d-flex mb-3">
      <a href="index.php" class="ml-auto text-dark font-12">Back to home?</a>
    </div>
    <button class="btn btn-lg font-12 font-weight-bolder btn-dark btn-block" type="submit">proceed</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
  </form>

  <div id="response"></div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="modules/message.js"></script>
  <script src="modules/account/forgotpass/js/data.js"></script>

</body>

</html>
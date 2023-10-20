<?php
require_once '../classes/crud.php';
require_once '../classes/middlewares.php';
require_once '../classes/utilities.php';
middleware::get(["token", "uid"], "admin/404.php", false);
middleware::session(["id", "role"], "admin/dashboard.php", true); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../assets/imgs/favicon.png"> -->
  <title>Confirm password</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Signin page css -->
  <link rel="stylesheet" href="assets/css/signin.css">
  <!-- Custom -->
  <link href="assets/css/custom.css" rel="stylesheet">

</head>

<body>

  <?php

  $check = crud::select();
  $check = crud::columns(["id"]);
  $check = crud::table("account_reset");
  $check = crud::where(["user_id" => $_GET["uid"], "token" => $_GET["token"]]);
  $check = crud::execute();
  $check = crud::fetch("one");

  if (!$check) {
    utility::redirect("404.php");
  }
  ?>

  <form class="form-signin text-center" id="changepass">
    <h1 class="mb-3 font-weight-bolder"><b>LMS</b></h1>
    <h5 class="mb-3 font-weight-normal">Change password</h5>
    <label for="password" class="sr-only">Email address</label>
    <input type="password" id="password" name="password" class="form-control rounded" placeholder="New password" required autofocus>
    <label for="cpassword" class="sr-only">Password</label>
    <input type="password" id="cpassword" name="cpassword" class="form-control rounded" placeholder="Confirm Password" required>
    <input type="hidden" name="uid" id="uid" value="<?php echo $_GET["uid"]; ?>">
    <button class="btn btn-lg font-12 font-weight-bolder btn-dark btn-block" type="submit">Change</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
  </form>

  <div id="response"></div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="modules/message.js"></script>
  <script src="modules/account/changepass/js/data.js"></script>

</body>

</html>
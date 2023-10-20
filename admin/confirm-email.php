<?php require_once '../classes/middlewares.php'; ?>
<?php middleware::session(["id", "role"],"admin/dashboard.php", true); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Confirm email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon fonts-->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Signin page css -->
    <link rel="stylesheet" href="assets/css/signin.css">
    <!-- Custom -->
    <link href="assets/css/custom.css" rel="stylesheet">

</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="text-center mb-3">
          <a href="index.php" class="logo">
            <img class="mb-4" src="../assets/imgs/logo.png" alt="" width="72" height="72">
          </a>
        </div>
        <div class="card shadow rounded">
          <div class="card-body p-4">
              <div class="mb-4 text-center">
                  <h3 class="text-uppercase font-12 mt-0">Email Sent</h3>
              </div>
              <p class="text-muted mt-2">
                 A email has been send to <b><?php echo $_GET["email"]; ?></b>.
                  Please check for an email from company and click on the included link to
                  reset your password. </p>
            <a href="index.php" class="btn btn-block btn-dark btn-sm mt-3">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

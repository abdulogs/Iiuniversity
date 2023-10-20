<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Class enrollment</title>
  <!-- Bootstrap core CSS-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Main styles -->
  <link href="assets/css/admin.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


  <!-- Your custom styles -->
  <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer" id="page-top">

  <?php require_once 'includes/navigation.php'; ?>

  <?php
  if (in_array(date("m"), [3, 4, 5, 6, 7, 8])) {
    $classType = "Fall";
  } else if (in_array(date("m"), [9, 10, 11, 12, 1, 2])) {
    $classType = "Spring";
  }
  $time = crud::select()::columns(["SemesterName", "reg_time", "drop_time"])::table("semesteryear");
  $time = crud::where(["Year" => date("Y"), "SemesterName" => $classType])::execute();
  $time = crud::fetch("one");

  $hold = crud::select()::columns(["h.HoldType"])::table("student_hold as s");
  $hold = crud::join(["hold AS h" => ["h.HoldID" => "s.HoldID"]], "LEFT");
  $hold = crud::and(["s.StudentID" => $_SESSION["id"]])::execute();
  $hold = crud::fetch("one");
  ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Enrollment</li>
      </ol>

      <div class="row">
        <?php if ($_SESSION["role"] == "Student") : ?>
          <div class="col-12">
            <?php if (strtotime(date("m/d/Y")) <= strtotime($time["reg_time"]) || strtotime(date("m/d/Y")) <= strtotime($time["drop_time"])) : ?>
              <div class="alert alert-warning alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Notice!</b> Registeration for courses is available till this date
                <b><?php echo date('F d, Y', strtotime($time['reg_time'])); ?></b>
                and you can drop courses till this date
                <b><?php echo date('F d, Y', strtotime($time['drop_time'])); ?></b>
              </div>
            <?php endif; ?>
            <?php if ($hold) : ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Alert!</b> You cannot enroll courses because your account is in hold due to
                <b>(<?php echo $hold['HoldType']; ?>) </b>.
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="col-12">
          <!-- Content -->
          <div class="card shadow p-0 bg-white">
            <div class="d-flex align-items-center p-3 border-bottom">
              <h4 class="m-0 font-20 align-middle">
                <i class="fa fa-list text-success"></i> Enrollment
              </h4>
              <?php if (!$hold) : ?>
                <?php if (strtotime(date("m/d/Y")) <= strtotime($time["reg_time"]) || strtotime(date("m/d/Y")) <= strtotime($time["drop_time"]) && $_SESSION["role"]  == "Student") : ?>
                  <button class="btn btn-success font-12 rounded ml-auto createBtn" type="button" data-toggle="modal" data-target="#modalForm">
                    <span class="fa fa-plus-circle"></span> Create
                  </button>
                <?php endif; ?>
              <?php endif; ?>
            </div>
            <form class="px-2 py-1" id="filter">
              <div class="form-row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12  p-1">
                  <div class="input-group mb-0">
                    <div class="input-group-prepend">
                      <span class="input-group-text  bg-white font-12">Search</span>
                    </div>
                    <input type="text" class="form-control font-12" id="search" placeholder="Search...">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-6 py-1">
                  <div class="input-group mb-0">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white font-12">Sort</span>
                    </div>
                    <select id="sort" class="custom-select font-12">
                      <option value="recent">Recents</option>
                      <option value="oldest">Oldest</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-6 py-1">
                  <div class="input-group mb-0">
                    <div class="input-group-prepend">
                      <span class="input-group-text font-12 bg-white">Records</span>
                    </div>
                    <select id="limit" class="custom-select font-12">
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="60">60</option>
                      <option value="70">70</option>
                      <option value="80">80</option>
                      <option value="90">90</option>
                      <option value="100">100</option>
                      <option value="all">All</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-12 py-1">
                  <button type="submit" class="btn font-12 btn-outline-dark rounded btn-block filter-btn">
                    <span class="fas fa-sliders-h"></span>
                    Filter
                  </button>
                </div>
              </div>
            </form>
            <table class="table table-card table-sm mb-0">
              <thead class="bg-light border-top">
                <tr>
                  <th class="px-3 border-0" scope="col">ID</th>
                  <th class="border-0" scope="col">Student</th>
                  <th class="border-0" scope="col">Professor</th>
                  <th class="border-0" scope="col">Course</th>
                  <th class="border-0" scope="col">Department</th>
                  <th class="border-0" scope="col">Building</th>
                  <th class="border-0" scope="col">Room</th>
                  <th class="border-0" scope="col">Semester</th>
                  <th class="border-0" scope="col">Period</th>
                  <th class="border-0" scope="col">Grade</th>
                  <th class="px-3 border-0" scope="col">Controls</th>
                </tr>
              </thead>
              <tbody id="data" class="font-12"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
  </div>

  <div class="modal fade" id="modalForm" data-keyboard="false" data-backdrop="static" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" id="form" role="Form"></div>
  </div>


  <?php require_once 'includes/footer.php'; ?>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Custom scripts for all pages-->

  <script src="assets/js/admin.js"></script>
  <script src="modules/classes/enrollment/js/data.js"></script>
</body>

</html>
<?php require_once '../classes/crud.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Profile</title>
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
    $profile = crud::select();
    $profile = crud::columns(["phone","gender","age","address","fullname","email","avatar","about"]);
    $profile = crud::table("users");
    $profile = crud::execute();
    $profile = crud::fetch("one");
     ?>

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item">
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
            <div class="row">
                 <div class="col-sm-3"></div>
                 <div class="col-lg-6">
                   <form class="card shadow mb-3" method="post" id="profile">
                     <div class="card-header border-bottom">
                       <h4 class="m-0 card-title"><b>Change profile</b></h4>
                     </div>
                     <div class="card-body">
                       <div class="form-group mb-2">
                         <div class="mb-3 text-center">
                         <?php if (empty($profile["avatar"]) || !file_exists("../uploads/avatars/{$profile["avatar"]}")): ?>
                         <img id="output" src="./assets/imgs/avatar.png" style="height:150px;width:150px;" class="rounded-circle shadow-sm">
                         <?php else: ?>
                         <img id="output" src="../uploads/avatars/<?php echo $profile['avatar']; ?>" style="height:180px;width:180px;" class="rounded-circle img-thumbnail shadow-sm">
                         <?php endif; ?>
                         </div>
                         <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" type="file" onchange="loadFile(event)" accept="image/*">
                            <input type="hidden" name="avatar" value="<?php echo $profile["avatar"]; ?>">
                            <label class="custom-file-label" id="image" >Choose file</label>
                          </div>
                       </div>
                     </div>
                     <div class="card-footer text-right">
                       <button class="btn btn-success" id="profilesubmit" type="submit">Update</button>
                     </div>
                   </form>
                   <form class="card shadow mb-3" method="post" id="basic">
                     <div class="card-header border-bottom">
                       <h4 class="m-0 card-title"><b>Basic info</b></h4>
                     </div>
                     <div class="card-body">
                       <div class="form-row">
                         <div class="form-group mb-2 col-sm-12">
                           <label for="" class="m-0">Fullname</label>
                           <div class="input-group">
                             <input type="text" class="form-control form-control-sm" name="fname" value="<?php echo $profile["fullname"]; ?>">
                           </div>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">Email</label>
                           <div class="input-group">
                             <input type="text" class="form-control form-control-sm" name="email" value="<?php echo $profile["email"]; ?>">
                           </div>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">Phone</label>
                           <div class="input-group">
                             <input type="text" class="form-control form-control-sm" name="phone" value="<?php echo $profile["phone"]; ?>">
                           </div>
                         </div>
                         <div class="form-group col-sm-6 mb-2">
                           <label class="form-label mb-0" for="gender">Gender</label>
                           <select class="custom-select font-12" id="gender" name="gender" required>
                             <optgroup label="Selected">
                               <option value="<?php echo $profile["gender"]; ?>">
                                 <?php echo ($profile["gender"] == 1) ? "Male" : "Female" ; ?>
                               </option>
                             </optgroup>
                             <option value="1">Male</option>
                             <option value="0">Female</option>
                           </select>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">Age</label>
                           <div class="input-group">
                             <input type="text" class="form-control form-control-sm" name="age" value="<?php echo $profile["age"]; ?>">
                           </div>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">Address</label>
                           <div class="input-group">
                             <textarea class="form-control form-control-sm" name="address" rows="5"><?php echo $profile["address"]; ?></textarea>
                           </div>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">About</label>
                           <div class="input-group">
                             <textarea class="form-control form-control-sm" name="about" rows="5"><?php echo $profile["about"]; ?></textarea>
                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="card-footer border-top text-right">
                       <button class="btn btn-success" id="contactsubmit" type="submit">Update</button>
                     </div>
                   </form>
                   <form class="card shadow mb-3" method="post" id="pass">
                     <div class="card-header border-bottom">
                       <h4 class="m-0 card-title"><b>Change password</b></h4>
                     </div>
                     <div class="card-body">
                       <div class="form-row">
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">Old password</label>
                           <div class="input-group">
                             <input type="password" class="form-control form-control-sm" name="oldpass">
                           </div>
                         </div>
                         <div class="form-group mb-2 col-sm-6">
                           <label for="" class="m-0">New password</label>
                           <div class="input-group">
                             <input type="password" class="form-control form-control-sm" name="password">
                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="card-footer border-top text-right">
                       <button class="btn btn-success" id="passwordsubmit" type="submit">Update</button>
                     </div>
                   </form>
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
    <script src="assets/js/admin.js"></script>
    <script src="assets/js/imagePreview.js"></script>
    <script src="modules/account/profile/js/data.js"></script>
</body>

</html>

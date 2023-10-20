<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $fname = htmlentities(htmlspecialchars(strip_tags($_POST['fname'])));
  $lname = htmlentities(htmlspecialchars(strip_tags($_POST['lname'])));
  $email = htmlentities(htmlspecialchars(strip_tags($_POST['email'])));
  $oemail = htmlentities(htmlspecialchars(strip_tags($_POST['oemail'])));
  $phone = htmlentities(htmlspecialchars(strip_tags($_POST['phone'])));
  $password = htmlentities(htmlspecialchars(strip_tags($_POST['password'])));
  $opassword = htmlentities(htmlspecialchars(strip_tags($_POST['opassword'])));
  $dob = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['dob'])))));
  $department = htmlentities(htmlspecialchars(strip_tags($_POST['department'])));
  $type = htmlentities(htmlspecialchars(strip_tags($_POST['type'])));
  $min = htmlentities(htmlspecialchars(strip_tags($_POST['min'])));
  $max = htmlentities(htmlspecialchars(strip_tags($_POST['max'])));


  if ($email == $oemail) {
    $mail = $oemail;
  } elseif ($email != $oemail) {
    $mail = $email;
  }

  if (!empty($password)) {
    $pass = $password;
  } elseif (empty($password) && $password == "") {
    $pass = $opassword;
  }

  $user = crud::update("users");
  $user = crud::updatedata([
    "F_Name" => $fname,
    "L_Name" => $lname,
    "DOB" => $dob,
    "Phone" => $phone,
    "Email" => $mail,
    "Password" => $pass,
  ]);
  $user = crud::where(["UserID" => $id]);
  $user = crud::execute();

  $faculty = crud::update("faculty");
  $faculty = crud::updatedata([
    "DeptID" => $department,
    "FacultyType" => $type,
    "MinCourse" => $min,
    "MaxCourse" => $max,
  ]);
  $faculty = crud::where(["FacultyID" => $id]);
  $faculty = crud::execute();

  if ($user &&  $faculty) {
    utility::reload(1000);
    message::success("1 row created successfully");
  }
}

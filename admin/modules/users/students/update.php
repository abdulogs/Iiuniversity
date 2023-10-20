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
  $graduate = htmlentities(htmlspecialchars(strip_tags($_POST['graduate'])));
  $type = htmlentities(htmlspecialchars(strip_tags($_POST['type'])));
  $holdid = htmlentities(htmlspecialchars(strip_tags($_POST['hold'])));
  $credits = htmlentities(htmlspecialchars(strip_tags($_POST['credits'])));

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


  $student = crud::update("student");
  $student = crud::updatedata([
    "StudentType" => $type,
    "CreditEarned" => $credits,
    "StudentStatus" => $graduate,
  ]);
  $student = crud::where(["StudentID" => $id]);
  $student = crud::execute();


  if (!empty($holdid)) {
    $delete = crud::delete("student_hold")::where(["StudentID" => $id])::execute();
    $hold = crud::insert("student_hold");
    $hold = crud::insertdata([
      "HoldID" => $holdid,
      "StudentID" => $id,
    ]);
    $hold = crud::execute();
  } elseif (empty($holdid)) {
    $delete = crud::delete("student_hold")::where(["StudentID" => $id])::execute();
  }

  if ($user && $student) {
    utility::reload(1000);
    message::success("1 row created successfully");
  }
}

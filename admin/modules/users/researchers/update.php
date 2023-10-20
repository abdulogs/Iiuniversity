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
    "DateCreated" => date("m/d/Y"),
    "Email" => $mail,
    "Password" => $pass,
  ]);
  $user = crud::where(["UserID" => $id]);
  $user = crud::execute();

  if ($user) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

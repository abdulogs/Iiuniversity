<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $fname = htmlentities(htmlspecialchars(strip_tags($_POST['fname'])));
  $lname = htmlentities(htmlspecialchars(strip_tags($_POST['lname'])));
  $email = htmlentities(htmlspecialchars(strip_tags($_POST['email'])));
  $password = htmlentities(htmlspecialchars(strip_tags($_POST['password'])));
  $phone = htmlentities(htmlspecialchars(strip_tags($_POST['phone'])));
  $dob = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['dob'])))));

  if (crud::check("users", ["UserID"], ["UserID" => $id])) {
    message::error("This id already exists");
  } else if (crud::check("users", ["UserID"], ["Email" => $email])) {
    message::error("This email address aleady exists");
  } else {
    $user = crud::insert("users");
    $user = crud::insertdata([
      "UserID" => $id,
      "F_Name" => $fname,
      "L_Name" => $lname,
      "Email" => $email,
      "Password" => $password,
      "DOB" => $dob,
      "Phone" => $phone,
      "DateCreated" => date("m/d/Y"),
      "UserType" => "Researcher",

    ]);
    $user = crud::execute();

    if ($user) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

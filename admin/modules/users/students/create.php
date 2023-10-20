<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $fname = htmlentities(htmlspecialchars(strip_tags($_POST['fname'])));
  $lname = htmlentities(htmlspecialchars(strip_tags($_POST['lname'])));
  $email = htmlentities(htmlspecialchars(strip_tags($_POST['email'])));
  $phone = htmlentities(htmlspecialchars(strip_tags($_POST['phone'])));
  $password = htmlentities(htmlspecialchars(strip_tags($_POST['password'])));
  $dob = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['dob'])))));
  $graduate = htmlentities(htmlspecialchars(strip_tags($_POST['graduate'])));
  $type = htmlentities(htmlspecialchars(strip_tags($_POST['type'])));
  $holdid = htmlentities(htmlspecialchars(strip_tags($_POST['hold'])));
  $credits = htmlentities(htmlspecialchars(strip_tags($_POST['credits'])));

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
      "DOB" => $dob,
      "Phone" => $phone,
      "DateCreated" => date("m/d/Y"),
      "UserType" => "Student",
      "Email" => $email,
      "Password" => $password,
    ]);
    $user = crud::execute();

    $student = crud::insert("student");
    $student = crud::insertdata([
      "StudentID" => $id,
      "StudentType" => $type,
      "CreditEarned" => $credits,
      "StudentStatus" => $graduate,
    ]);
    $student = crud::execute();


    if (!empty($holdid)) {
      $hold = crud::insert("student_hold");
      $hold = crud::insertdata([
        "HoldID" => $holdid,
        "StudentID" => $id,
      ]);
      $hold = crud::execute();
    }

    if ($user && $student) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['class'])));
  $student = htmlentities(htmlspecialchars(strip_tags($_POST['student'])));
  $status = htmlentities(htmlspecialchars(strip_tags($_POST['sstatus'])));


  $present = crud::select()::columns(["CRN"])::table("attendence")::where(["StudentID" => $student, "CRN" => $course])::execute();
  $present = crud::fetch("one");

  if ($present) {
    message::error("You already mark this student attendence");
  } else {

    $class = crud::insert("attendence");
    $class = crud::insertdata([
      "CRN" => $course,
      "StudentID" => $student,
      "Present" => $status,
      "DateAtt" => date("Y-m-d"),
    ]);
    $class = crud::execute();


    if ($class) {
      message::success("1 row added successfully");
      utility::reload(1000);
    }
  }
}

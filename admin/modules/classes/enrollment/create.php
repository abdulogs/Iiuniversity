<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));

  $enrollment = crud::select()
  ::columns(["CRN"])::table("enrollment")
  ::where(["StudentID" => $_SESSION["id"], "CRN" => $course])
  ::execute();
  $enrollment = crud::fetch("one");

  if ($enrollment) {
    message::error("You already selected this course");
  } else {
    $insert = crud::insert("enrollment");
    $insert = crud::insertdata([
      "StudentID" => $_SESSION["id"],
      "CRN" => $course,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

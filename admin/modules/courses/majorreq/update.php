<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $major = htmlentities(htmlspecialchars(strip_tags($_POST['major'])));

  $update = crud::update("major_req");
  $update = crud::updatedata([
    "MajorID" => $major,
    "CourseID" => $course,
  ]);
  $update = crud::where(["MajorReqID" => $id]);
  $update = crud::execute();

  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

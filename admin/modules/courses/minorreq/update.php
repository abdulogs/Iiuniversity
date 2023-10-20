<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $minor = htmlentities(htmlspecialchars(strip_tags($_POST['minor'])));

  $update = crud::update("minor_req");
  $update = crud::updatedata([
    "MinorID" => $minor,
    "CourseID" => $course,
  ]);
  $update = crud::where(["MinorReqID" => $id]);
  $update = crud::execute();

  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

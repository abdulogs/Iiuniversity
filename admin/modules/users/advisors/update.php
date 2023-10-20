<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $student = htmlentities(htmlspecialchars(strip_tags($_POST['student'])));
  $faculty = htmlentities(htmlspecialchars(strip_tags($_POST['faculty'])));

  $update = crud::update("student_advisor");
  $update = crud::updatedata([
    "FacultyID" => $faculty,
    "StudentID" => $student,
  ]);
  $update = crud::where(["AdvisorID " => $id]);
  $update = crud::execute();

  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

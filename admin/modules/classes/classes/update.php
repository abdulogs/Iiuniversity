<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $faculty = htmlentities(htmlspecialchars(strip_tags($_POST['faculty'])));
  $timing = htmlentities(htmlspecialchars(strip_tags($_POST['timing'])));
  $room = htmlentities(htmlspecialchars(strip_tags($_POST['room'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $semester = htmlentities(htmlspecialchars(strip_tags($_POST['semester'])));

  $class = crud::update("class");
  $class = crud::updatedata([
    "TimeslotID" => $timing,
    "FacultyID" => $faculty,
    "RoomID" => $room,
    "CourseID" => $course,
    "SemesterID" => $semester,
  ]);
  $class = crud::where(["CRN" => $id]);
  $class = crud::execute();

  if ($class) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

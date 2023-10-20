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

  if (crud::check("class", ["CRN"], ["CRN" => $id])) {
    message::error("This id already exixts");
  } else {
    $class = crud::insert("class");
    $class = crud::insertdata([
      "CRN" => $id,
      "TimeslotID" => $timing,
      "FacultyID" => $faculty,
      "RoomID" => $room,
      "CourseID" => $course,
      "SemesterID" => $semester,
    ]);
    $class = crud::execute();

    $history = crud::insert("profhistory");
    $history = crud::insertdata([
      "FacultyID" => $faculty,
      "CRN" => $id,
      "SemesterID" => $semester,
    ]);
    $history = crud::execute();

    if ($class && $history) {
      message::success("1 row added successfully");
      utility::reload(1000);
    }
  }
}

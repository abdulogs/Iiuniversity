<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $student = htmlentities(htmlspecialchars(strip_tags($_POST['student'])));
  $faculty = htmlentities(htmlspecialchars(strip_tags($_POST['faculty'])));

  if (crud::check("student_advisor", ["AdvisorID"], ["AdvisorID" => $id])) {
    message::error("This id already exists");
  } else {
    $insert = crud::insert("student_advisor");
    $insert = crud::insertdata([
      "AdvisorID " => $id,
      "FacultyID" => $faculty,
      "StudentID" => $student,
      "AssignDate" => date("d-m-Y")
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

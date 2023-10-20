<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  $hours = htmlentities(htmlspecialchars(strip_tags($_POST['hours'])));
  $department = htmlentities(htmlspecialchars(strip_tags($_POST['department'])));
  $section = htmlentities(htmlspecialchars(strip_tags($_POST['section'])));

  $course = crud::update("courses");
  $course = crud::updatedata([
    "Title" => $name,
    "CreditHours" => $hours,
    "DeptID" => $department,
    "Section" => $section,
  ]);
  $course = crud::where(["CourseID" => $id]);
  $course = crud::execute();


  if ($course) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  $hours = htmlentities(htmlspecialchars(strip_tags($_POST['hours'])));
  $section = htmlentities(htmlspecialchars(strip_tags($_POST['section'])));
  $department = htmlentities(htmlspecialchars(strip_tags($_POST['department'])));

  if (crud::check("courses", ["CourseID"], ["CourseID" => $id])) {
    message::error("This id already exixts");
  } else {
    $course = crud::insert("courses");
    $course = crud::insertdata([
      "CourseID" => $id,
      "Section" => $section,
      "Title" => $name,
      "CreditHours" => $hours,
      "DeptID" => $department,
    ]);
    $course = crud::execute();

    if ($course) {
      message::success("1 row added successfully");
      utility::reload(1000);
    }
  }
}

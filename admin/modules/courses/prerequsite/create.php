<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $grade = htmlentities(htmlspecialchars(strip_tags($_POST['grade'])));

  if (crud::check("prerequsite", ["PreReqID"], ["PreReqID" => $id])) {
    message::error("This id already exixts");
  } else {
    $insert = crud::insert("prerequsite");
    $insert = crud::insertdata([
      "PreReqID" => $id,
      "CourseID" => $course,
      "MinGrade" => $grade,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

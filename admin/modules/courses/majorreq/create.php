<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $major = htmlentities(htmlspecialchars(strip_tags($_POST['major'])));

  if (crud::check("major_req", ["MajorReqID"], ["MajorReqID" => $id])) {
    message::error("This id already exixts");
  } else {

    $insert = crud::insert("major_req");
    $insert = crud::insertdata([
      "MajorReqID" => $id,
      "MajorID" => $major,
      "CourseID" => $course,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

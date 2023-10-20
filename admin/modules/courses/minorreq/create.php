<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = htmlentities(htmlspecialchars(strip_tags($_POST['course'])));
  $minor = htmlentities(htmlspecialchars(strip_tags($_POST['minor'])));

  if (crud::check("minor_req", ["MinorReqID"], ["MinorReqID" => $id])) {
    message::error("This id already exixts");
  } else {
    $insert = crud::insert("minor_req");
    $insert = crud::insertdata([
      "MinorReqID" => $id,
      "MinorID" => $minor,
      "CourseID" => $course,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

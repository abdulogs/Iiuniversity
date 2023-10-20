<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $delete = crud::delete("faculty")::where(["FacultyID" => $id])::execute();
  $delete = crud::delete("class")::where(["FacultyID" => $id])::execute();
  $delete = crud::delete("profhistory")::where(["FacultyID" => $id])::execute();
  $delete = crud::delete("student_advisor")::where(["FacultyID" => $id])::execute();
  $delete = crud::delete("users")::where(["UserID" => $id])::execute();

  if ($delete) {
    utility::reload(1000);
    message::success("1 row deleted successfully");
  }
}

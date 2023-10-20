<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  $department = htmlentities(htmlspecialchars(strip_tags($_POST['department'])));

  $update = crud::update("major");
  $update = crud::updatedata([
    "Name" => $name,
    "DeptID" => $department,
  ]);
  $update = crud::where(["MajorID" => $id]);
  $update = crud::execute();


  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

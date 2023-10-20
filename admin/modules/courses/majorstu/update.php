<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $major = htmlentities(htmlspecialchars(strip_tags($_POST['major'])));

  $update = crud::update("studentmajor");
  $update = crud::updatedata([
    "MajorID" => $major,
  ]);
  $update = crud::where(["id" => $id]);
  $update = crud::execute();

  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

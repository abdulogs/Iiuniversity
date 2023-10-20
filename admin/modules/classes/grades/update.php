<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $grade = htmlentities(htmlspecialchars(strip_tags($_POST['grade'])));

  $update = crud::update("enrollment");
  $update = crud::updatedata([
    "GRADE" => $grade,
  ]);
  $update = crud::where(["id" => $id]);
  $update = crud::execute();

  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

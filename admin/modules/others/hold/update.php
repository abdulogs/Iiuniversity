<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = htmlentities(htmlspecialchars(strip_tags($_POST['name'])));

  $update = crud::update("hold");
  $update = crud::updatedata([
    "HoldType" => $name,
  ]);
  $update = crud::where(["HoldID" => $id]);
  $update = crud::execute();


  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

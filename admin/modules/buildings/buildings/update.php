<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = htmlentities(htmlspecialchars(strip_tags($_POST['name'])));

  $building = crud::update("building");
  $building = crud::updatedata([
    "Name" => $name,
  ]);
  $building = crud::where(["BuildingID" => $id]);
  $building = crud::execute();


  if ($building) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

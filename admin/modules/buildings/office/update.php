<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $number = htmlentities(htmlspecialchars(strip_tags($_POST['number'])));
  $capacity = htmlentities(htmlspecialchars(strip_tags($_POST['capacity'])));
  $seats = htmlentities(htmlspecialchars(strip_tags($_POST['seats'])));
  $building = htmlentities(htmlspecialchars(strip_tags($_POST['building'])));

  $room = crud::update("room");
  $room = crud::updatedata([
    "RoomNumber" => $number,
    "BuildingID" => $building,
    "Capacity" => $capacity,
    "Seats" => $seats,
  ]);
  $room = crud::where(["RoomID" => $id]);
  $room = crud::execute();

  if ($room) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

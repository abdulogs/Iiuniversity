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


  if (crud::check("room", ["RoomID"], ["RoomID" => $id])) {
    message::error("This id already exixts");
  } else {

    $room = crud::insert("room");
    $room = crud::insertdata([
      "RoomID" => $id,
      "RoomType" => "Lab",
      "RoomNumber" => $number,
      "BuildingID" => $building,
      "Capacity" => $capacity,
      "Seats" => $seats,
    ]);
    $room = crud::execute();

    if ($room) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

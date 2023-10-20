<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  if (crud::check("building", ["BuildingID"], ["BuildingID" => $id])) {
    message::error("This id already exixts");
  } else {
    $building = crud::insert("building");
    $building = crud::insertdata([
      "BuildingID" => $id,
      "Name" => $name,
    ]);
    $building = crud::execute();
    if ($building) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

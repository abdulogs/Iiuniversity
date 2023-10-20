<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = htmlentities(htmlspecialchars(strip_tags($_POST['name'])));

  if (crud::check("hold", ["HoldID"], ["HoldID" => $id])) {
    message::error("This id already exixts");
  } else {
    $insert = crud::insert("hold");
    $insert = crud::insertdata([
      "HoldID" => $id,
      "HoldType" => $name,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

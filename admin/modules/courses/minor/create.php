<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  $department = htmlentities(htmlspecialchars(strip_tags($_POST['department'])));

  if (crud::check("minor", ["MinorID"], ["MinorID" => $id])) {
    message::error("This id already exixts");
  } else {

    $insert = crud::insert("minor");
    $insert = crud::insertdata([
      "MinorID" => $id,
      "Name" => $name,
      "DeptID" => $department,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

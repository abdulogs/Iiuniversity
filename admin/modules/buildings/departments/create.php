<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = $_POST['name'];
  $contact = htmlentities(htmlspecialchars(strip_tags($_POST['contact'])));
  $chairman = htmlentities(htmlspecialchars(strip_tags($_POST['chairman'])));
  $manager = htmlentities(htmlspecialchars(strip_tags($_POST['manager'])));
  $room = htmlentities(htmlspecialchars(strip_tags($_POST['room'])));

  if (crud::check("department", ["DeptID"], ["DeptID" => $id])) {
    message::error("This id already exixts");
  } else {
    $department = crud::insert("department");
    $department = crud::insertdata([
      "DeptID" => $id,
      "Name" => $name,
      "Contact" => $contact,
      "Chairman" => $chairman,
      "Manager" => $manager,
      "RoomID" => $room,
    ]);
    $department = crud::execute();

    if ($department) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

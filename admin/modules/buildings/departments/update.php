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

  $department = crud::update("department");
  $department = crud::updatedata([
    "Name" => $name,
    "Contact" => $contact,
    "Chairman" => $chairman,
    "Manager" => $manager,
    "RoomID" => $room,
  ]);
  $department = crud::where(["DeptID" => $id]);
  $department = crud::execute();

  if ($department) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

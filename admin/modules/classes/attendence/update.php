<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $cclass = htmlentities(htmlspecialchars(strip_tags($_POST['class'])));
  $student = htmlentities(htmlspecialchars(strip_tags($_POST['student'])));
  $status = htmlentities(htmlspecialchars(strip_tags($_POST['sstatus'])));

  $class = crud::update("attendence");
  $class = crud::updatedata([
    "Present" => $status,
    "CRN" => $cclass,
  ]);
  $class = crud::where(["id" => $id]);
  $class = crud::execute();


  if ($class) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

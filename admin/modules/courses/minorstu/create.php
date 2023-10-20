<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $minor = htmlentities(htmlspecialchars(strip_tags($_POST['minor'])));

  $insert = crud::insert("studentminor");
  $insert = crud::insertdata([
    "MinorID" => $minor,
    "StudentID" => $_SESSION["id"],
    "DateDeclaration" => date("d-m-Y")
  ]);
  $insert = crud::execute();

  if ($insert) {
    utility::reload(1000);
    message::success("1 row created successfully");
  }
}

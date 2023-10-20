<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/media.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));

  $delete = crud::delete("minor_req")::where(["id" => $id])::execute();

  if ($delete) {
    utility::reload(1000);
    message::success("1 row deleted successfully");
  }
}

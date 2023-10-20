<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $start = date("h:i:s A", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['start'])))));
  $end = date("h:i:s A", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['end'])))));

  $period = crud::update("period");
  $period = crud::updatedata([
    "Start_Time" => $start,
    "End_Time" => $end,
  ]);
  $period = crud::where(["PeriodID" => $id]);
  $period = crud::execute();


  if ($period) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

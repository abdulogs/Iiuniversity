<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $day = htmlentities(htmlspecialchars(strip_tags($_POST['day'])));
  $pre = htmlentities(htmlspecialchars(strip_tags($_POST['pre'])));

  $update = crud::update("timeslot");
  $update = crud::updatedata([
    "DayID" => $day,
    "PeriodID" => $pre,
  ]);
  $update = crud::where(["TimeSlotID" => $id]);
  $update = crud::execute();


  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

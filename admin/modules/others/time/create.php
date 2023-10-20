<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $day = htmlentities(htmlspecialchars(strip_tags($_POST['day'])));
  $pre = htmlentities(htmlspecialchars(strip_tags($_POST['pre'])));

  if (crud::check("timeslot", ["TimeSlotID"], ["TimeSlotID" => $id])) {
    message::error("This id already exixts");
  } else {
    $insert = crud::insert("timeslot");
    $insert = crud::insertdata([
      "TimeSlotID" => $id,
      "DayID" => $day,
      "PeriodID" => $pre,
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }
}

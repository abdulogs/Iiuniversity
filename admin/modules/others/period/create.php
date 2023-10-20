<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $start = date("h:i:s A", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['start'])))));
  $end = date("h:i:s A", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['end'])))));

  if (crud::check("period", ["PeriodID"], ["PeriodID" => $id])) {
    message::error("This id already exixts");
  } else {

    $period = crud::insert("period");
    $period = crud::insertdata([
      "PeriodID" => $id,
      "Start_Time" => $start,
      "End_Time" => $end,
    ]);
    $period = crud::execute();

    if ($period) {
      message::success("1 row added successfully");
      utility::reload(1000);
    }
  }
}

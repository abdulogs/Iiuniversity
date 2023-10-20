<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $name = htmlentities(htmlspecialchars(strip_tags($_POST['name'])));
  $year = htmlentities(htmlspecialchars(strip_tags($_POST['year'])));
  $start = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['start'])))));
  $end = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['end'])))));
  $grade = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['grade'])))));
  $reg = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['reg'])))));
  $drop = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['drop'])))));

  $update = crud::update("semesteryear");
  $update = crud::updatedata([
    "SemesterName" => $name,
    "Year" => $year,
    "StartDate " => $start,
    "EndDate" => $end,
    "grade_time" => $grade, 
    "reg_time" => $reg,
    "drop_time" => $drop
  ]);
  $update = crud::where(["SemesterID" => $id]);
  $update = crud::execute();


  if ($update) {
    message::success("1 row updated successfully");
    utility::reload(1000);
  }
}

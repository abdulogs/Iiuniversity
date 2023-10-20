<?php
require_once "../../../../classes/utilities.php";
require_once "../../../../classes/messages.php";
require_once "../../../../classes/crud.php";

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $name = htmlentities(htmlspecialchars(strip_tags($_POST['name'])));
  $year = htmlentities(htmlspecialchars(strip_tags($_POST['year'])));
  $start = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['start'])))));
  $end = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['end'])))));
  $grade = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['grade'])))));
  $reg = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['reg'])))));
  $drop = date("m/d/Y", strtotime(htmlentities(htmlspecialchars(strip_tags($_POST['drop'])))));
    $insert = crud::insert("semesteryear");
    $insert = crud::insertdata([
      "SemesterName" => $name,
      "Year" => $year,
      "StartDate " => $start,
      "EndDate" => $end,
      "grade_time" => $grade, 
      "reg_time" => $reg,
      "drop_time" => $drop
    ]);
    $insert = crud::execute();

    if ($insert) {
      utility::reload(1000);
      message::success("1 row created successfully");
    }
  }

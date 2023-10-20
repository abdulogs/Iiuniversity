<?php
  require_once "../../../../classes/utilities.php";
  require_once "../../../../classes/messages.php";
  require_once "../../../../classes/crud.php";
  require_once "../../../../classes/media.php";

  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

    $oldpass = htmlentities(htmlspecialchars(strip_tags($_POST['oldpass'])));
    $password = htmlentities(htmlspecialchars(strip_tags($_POST['password'])));


    $check = crud::select();
    $check = crud::columns(["id"]);
    $check = crud::table("users");
    $check = crud::where(["id" => $_SESSION["id"], "password" => md5($password)]);
    $check = crud::execute();
    $check = crud::fetch("one");

    if ($check) {
      $update = crud::update("users");
      $update = crud::updatedata([
        "password" => md5($password),
      ]);
      $update = crud::execute();

      if ($update) {
        message::success("Password updated successfully");
        utility::reload(1000);
      }
    }else {
      message::error("Old password incorrect");
    }
  }
?>

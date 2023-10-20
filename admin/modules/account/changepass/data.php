<?php
  require_once "../../../../classes/utilities.php";
  require_once "../../../../classes/messages.php";
  require_once "../../../../classes/crud.php";

  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    $password = htmlentities(htmlspecialchars(strip_tags($_POST['password'])));
    $uid = htmlentities(htmlspecialchars(strip_tags($_POST['uid'])));

    $user = crud::select();
    $user = crud::columns(["id"]);
    $user = crud::table("account_reset");
    $user = crud::where(["user_id" => $uid]);
    $user = crud::execute();
    $user = crud::fetch("one");

    if ($user) {
      $update = crud::update("users");
      $update = crud::updatedata([
        "password" => md5($password),
        "updated_at" => date("Y/m/d h:i:s A")
      ]);
      $update = crud::where(["id" => $user["id"]]);
      $update = crud::execute();

      if ($update) {

        $delete = crud::delete("account_reset");
        $delete = crud::where(["user_id" => $uid]);
        $delete = crud::execute();

        message::success("Password changed successfully");
        utility::redirect("index.php", 1000);
      }
    } else {
      message::error("Something went wrong!");
    }
  }
?>

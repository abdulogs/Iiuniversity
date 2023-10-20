<?php
  require_once "../../../../classes/utilities.php";
  require_once "../../../../classes/messages.php";
  require_once "../../../../classes/crud.php";
  require_once "../../../../classes/email.php";
error_reporting(E_ALL);
  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    $email = htmlentities(htmlspecialchars(strip_tags($_POST['email'])));
    $token = md5(time().date("d"));

    /* check user */
    $user = crud::select();
    $user = crud::columns(["id","email","fullname"]);
    $user = crud::table("users");
    $user = crud::where(["email" => $email]);
    $user = crud::execute();
    $user = crud::fetch("one");

    if ($user) {

      $email = mailer::template("forgot-password");
      $email = mailer::file("../../../templates/basic");
      $email = mailer::fullname($user["fullname"]);
      $email = mailer::sender(config::$supportEmail);
      $email = mailer::reciever($user["email"]);
      $email = mailer::subject("Change password");
      $email = mailer::web("Tourism in pakistan");
      $email = mailer::logo("uploads/logo/logo-dark.png");
      $email = mailer::title("Change password");
      $email = mailer::description("Click on the link given below");
      $email = mailer::btn("Click");
      $email = mailer::btnRedirect(utility::$hostname."admin/"."change-password.php?token=".$token."&uid=".$user["id"]);
      $email = mailer::send(true);

      if ($email == true || $email == false) {
        $create = crud::insert("account_reset");
        $create = crud::insertdata([
          "user_id" => $user["id"],
          "email" => $user["email"],
          "token" => $token,
          "created_at" => date("Y/m/d h:i:s A"),
        ]);
        $create = crud::execute();
        message::error("Email sent successfully");
        // utility::redirect("confirm-email.php?email={$user["email"]}");
      }

    } else {
      message::error("This email not exists in database");
    }
  }
?>

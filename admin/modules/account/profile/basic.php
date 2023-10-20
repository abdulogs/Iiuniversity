<?php
  require_once "../../../../classes/utilities.php";
  require_once "../../../../classes/messages.php";
  require_once "../../../../classes/crud.php";
  require_once "../../../../classes/media.php";

  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

    $name = htmlentities(htmlspecialchars(strip_tags($_POST['fname'])));
    $email = htmlentities(htmlspecialchars(strip_tags($_POST['email'])));
    $phone = htmlentities(htmlspecialchars(strip_tags($_POST['phone'])));
    $gender = htmlentities(htmlspecialchars(strip_tags($_POST['gender'])));
    $address = htmlentities(htmlspecialchars(strip_tags($_POST['address'])));
    $age = htmlentities(htmlspecialchars(strip_tags($_POST['age'])));
    $about = htmlentities(htmlspecialchars(strip_tags($_POST['about'])));

    $update = crud::update("users");
    $update = crud::updatedata([
      "fullname" => ucfirst($name),
      "email" => $email,
      "phone" => $phone,
      "gender" => $gender,
      "age" => $age,
      "address" => $address,
      "about" => $about,
    ]);
    $update = crud::where(["id"=> $_SESSION["id"]]);
    $update = crud::execute();

    if ($update) {
      message::success("Profile updated successfully");
      utility::reload(1000);
    }
  }
?>

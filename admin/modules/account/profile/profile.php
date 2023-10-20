<?php
  require_once "../../../../classes/utilities.php";
  require_once "../../../../classes/messages.php";
  require_once "../../../../classes/media.php";
  require_once "../../../../classes/crud.php";

  if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
     $avatar = htmlentities(htmlspecialchars(strip_tags($_POST['avatar'])));

    if (!empty($_FILES['image']['name'])) {
      media::remove("../../../../uploads/avatars/{$avatar}");
      $image = media::file("image")::type(["png","jpg","jpeg"])::size(2097152)::name("avatar")::folder("../../../../uploads/avatars");
    } else {
      $image = $avatar;
    }

    $update = crud::update("users");
    $update = crud::updatedata([
      "avatar" => $image,
    ]);
    $update = crud::where(["id" => $_SESSION["id"]]);
    $update = crud::execute();

    message::success("Profile picture updated successfully");
    utility::reload(1000);
  }
?>

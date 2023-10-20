<?php
require_once 'config.php';

/*** Utilities ***/
class utility extends config {

  /*** properties ***/
  public static $hostname;

  /***  path ***/
  function __construct(){
   self::$hostname = parent::hostname();
    return self::$hostname;
  }

  public static function my_ip() {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if(isset($_SERVER['REMOTE_ADDR']))
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }

  public static function redirect($path, $time ="", $local = true){

    if ($local == false) {
      $path = $path;
    } else if($local == true) {
      $path = self::$hostname."".$path;
    }

    if (empty($time)) {
      echo "<script>window.open('".$path."', '_SELF');</script>";
    } else if(!empty($time)) {
      echo "<script>setTimeout(function() { window.open('".$path."', '_SELF');}, {$time});</script>";
    }

  }

  public static function classRoute($routes, $first, $second){

    if (isset($_GET["url"])) {
      if (!in_array($_GET["url"], $routes)) {
        echo $first;
      } else {
        echo $second;
      }
    } else {
      echo $first;
    }
  }


  public static function checkRedirect($check, $path){
    $path = self::$hostname."".$path;
    if (!$check) {
      echo "<script>window.open('".$path."', '_SELF');</script>";
    }
  }

  public static function reload($time =""){
    if (empty($time)) {
      echo "<script>location.reload();</script>";
    } else if(!empty($time)) {
      echo "<script>setTimeout(function() { location.reload();}, {$time});</script>";
    }
  }

  public static function activeRoute($name, $url, $home = false){
    if (isset($_GET["url"])) {
      if ($_GET["url"] == $url) {
        echo $name;
      }
    } elseif ($home == true) {
      echo $name;
    }

 }
}

<?php require_once 'config.php';
 /*** Middlewares ***/
 class middleware extends config{

   /*** properties ***/
   private static $hostname;

   /***  path ***/
   function __construct(){
    self::$hostname = parent::hostname();
     return self::$hostname;
   }

   /*** session set or unset ***/
   public static function session( $values , $path = "" , $set = true ){
     foreach ($values as $value) {
        if ($set == true) {
          if (isset($_SESSION[$value])) {
           header("location: ".parent::$url.$path);
          }
        } else if ($set == false) {
          if (!isset($_SESSION[$value])) {
            header("location: ".parent::$url.$path);
          }
        }
     }
   }

   /*** Url set or unset ***/
   public static function get($values,$path = "", $set = true){
     foreach ($values as $value) {
        if ($set == true) {
          if (isset($_GET[$value])) {
            header("location: ".parent::$url.$path);
          }
        } else if ($set == false) {
          if (!isset($_GET[$value])) {
            header("location: ".parent::$url.$path);
          }
        }
     }
   }

   /*** Requests set or unset ***/
   public function post($values,$path = "", $set = true){
     foreach ($values as $value) {
        if ($set == true) {
          if (isset($_POST[$value])) {
            header("location: ".parent::$url.$path);
          }
        } else if ($set == false) {
          if (!isset($_POST[$value])) {
            header("location: ".parent::$url.$path);
          }
        }
     }
   }
 }

<?php

class media {
  private static $file;
  private static $fileName = [];
  private static $fileTmp = [];
  private static $fileSize = [];
  private static $fileType = [];
  private static $newName = [];

  public static function file($name){

    self::$file = $_FILES[$name]['name'];

    if (is_array($_FILES[$name]['name'])) {
      for ($i=0 ; $i < count($_FILES[$name]['name']); $i++) {
        self::$fileName[] = $_FILES[$name]['name'][$i];
        self::$fileSize[] = $_FILES[$name]['size'][$i];
        self::$fileTmp[] = $_FILES[$name]['tmp_name'][$i];
        self::$fileType[] = $_FILES[$name]['type'][$i];
      }
    } elseif(!is_array($_FILES[$name]['name'])) {
      self::$fileName[] = $_FILES[$name]['name'];
      self::$fileSize[] = $_FILES[$name]['size'];
      self::$fileTmp[] = $_FILES[$name]['tmp_name'];
      self::$fileType[] = $_FILES[$name]['type'];
    }

    return __CLASS__;
  }

  public static function type($extensions){
    foreach (self::$fileType as $value) {
      $tmp = explode('/', $value);
      echo $file_extension = end($tmp);
      if (in_array($file_extension,$extensions) === false) {
        die("Inavlid file extension");
      }
    }
    return __CLASS__;
  }

  public static function size($size, $msg = "Image size must be 2 mb or lower"){
    foreach (self::$fileSize as $sizes) {
      if ($sizes > $size) {
        die($msg);
      }
    }
    return __CLASS__;
  }

  public static function name($name, $self = false, $exe = "png"){
    if ($self == false) {
      foreach (self::$fileName as $names) {
        self::$newName[] = $name.time().basename($names);
      }
    } elseif ($self == true) {
      foreach (self::$fileName as $names) {
        self::$newName[] = $name.".".$exe;
      }
    }
    return __CLASS__;
  }

  public static function folder($location){
    try {
      for ($i = 0; $i < count(self::$fileTmp); $i++) {
        $target = "{$location}/".self::$newName[$i];
          move_uploaded_file(self::$fileTmp[$i], $target);
      }
      if (is_array(self::$file)) {
        $data = self::$newName;
        self::$file = null;
        array_splice(self::$fileName, 0);
        array_splice(self::$fileType, 0);
        array_splice(self::$fileTmp, 0);
        array_splice(self::$fileSize, 0);
        array_splice(self::$newName, 0);
        return $data;
      } else {
        $data = self::$newName;
        self::$file = null;
        array_splice(self::$fileName, 0);
        array_splice(self::$fileType, 0);
        array_splice(self::$fileTmp, 0);
        array_splice(self::$fileSize, 0);
        array_splice(self::$newName, 0);
        return $data[0];
      }


    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public static function remove($name){
    if (file_exists($name)) {
      unlink($name);
    }
  }

}

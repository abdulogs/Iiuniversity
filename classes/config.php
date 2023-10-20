<?php session_start();

require_once 'settings.php';

class config {

	/***  Properties ***/
	public static $con;
	private static $host;
	private static $username;
	private static $password;
	private static $database;
	private static $production;
	private static $timezone;
	protected static $url;
	protected static $home;
	protected static $error404;
	public static $supportEmail;

	public function __construct() {
	 try {
		 	self::$con = new PDO("mysql:host=".self::$host.";dbname=".self::$database, self::$username, self::$password);
			self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 } catch(PDOException $e) {
		 $error = "";
		 $error .= "<h3 style='font-size:16px;font-family:arial;margin:2px 0;'>Opps there is a error in your code</h3>";
		 $error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Code :</b> {$e->getCode()}</p>";
		 $error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Line number :</b> {$e->getLine()}</p>";
		 $error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Filename</b> :</b> {$e->getFile()}</p>";
		 $error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Message</b> :</b> {$e->getMessage()}</p>";
		 $error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Trace</b> :</b>".$e->getTraceAsString()."</p>";
		 $error .= "<hr>";
		 echo $error;
	 	}
	}

	public static function setHost($demo = "", $live = ""){
		if (self::$production ==  true) {
			return self::$host = $live;
		} elseif (self::$production ==  false) {
			return self::$host = $demo;
		}
	}

	public static function setUsername($demo = "", $live = ""){
		if (self::$production ==  true) {
			return self::$username = $live;
		} elseif (self::$production ==  false) {
			return self::$username = $demo;
		}
	}

	public static function setPassword($demo = "", $live = ""){
		if (self::$production ==  true) {
			return self::$password = $live;
		} elseif (self::$production ==  false) {
			return self::$password = $demo;
		}
	}

	public static function setDatabase($demo = "", $live = ""){
		if (self::$production ==  true) {
			return self::$database = $live;
		} elseif (self::$production ==  false) {
			return self::$database = $demo;
		}
	}

	public static function setProduction($value){
		return self::$production = $value;
	}

	public static function setMaintenance($value){
		if ($value == true) {
			header("location: ");
		}
	}

	public static function setUrl($demo = "", $live = ""){
		if (self::$production ==  true) {
			return self::$url = $live;
		} elseif (self::$production ==  false) {
			return self::$url = $demo;
		}
	}

	public static function hostname(){
		return self::$url;
	}

	public static function getTimeZone(){
		return self::$timezone;
	}
	public static function homepage($name='index'){
		self::$home = $name;
	}

	public static function error404($name='index'){
		self::$error404 = $name;
	}

	public static function supportEmail($name){
		self::$supportEmail = $name;
	}

	public static function setTimeZone($value){
		self::$timezone = $value;
		return date_default_timezone_set(self::$timezone);
	}

	public static function setErrorReporting($value = true){
		if ($value == true) {
			return error_reporting(1);
		} else if($value == false) {
			return error_reporting(0);
		}
	}

}

$configure = new config;

<?php

DEFINE("LOGIN_ERROR", "loginError");
DEFINE("PRIVILEDGE_ERROR", "priviledgeError");
DEFINE("DATAFILTERING_ERROR", "dataFiltering");
DEFINE("NOTIFICATION", "notification");
DEFINE("NOTIFICATION_ERROR", "notification_error");

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

  

switch ($_REQUEST['id']) {
	case LOGIN_ERROR:
		
		session_start();
		
		$main = new Skin("tennis");
		$body = new Skinlet("error_login");
		
		$body->setContent("message", "Username or password unknown.");

		unset($_SESSION['user']);
		$_SESSION['HTTP_LOGIN'] = false;
				
		session_destroy();
	break;
	case PRIVILEDGE_ERROR:
		
		session_start();
		
		$main = new Skin("tennis"); 
		$body = new Skinlet("error");
		
		$body->setContent("message", "Warning: you are not permitted to use this service!");
		
	break;
	case DATAFILTERING_ERROR:
		
		session_start();
		
		$main = new Skin(); 
		$body = new Skinlet("error");
		
		$body->setContent("message", "Warning: you are not permitted to modify this item!");
	break;
	case "pageNotFound":
		$main = new Template("dtml/frame-public.html");
		$body = new Template("dtml/error.html");
		$body->setContent("message", "Warning: page not found!");
	break;

	case NOTIFICATION:
		
		$main = new Skin("tennis"); 
		$body = new Skinlet("password_notification");
		break;

	case NOTIFICATION_ERROR:
		
		$main = new Skin("tennis"); 
		$body = new Skinlet("password_notification_error");
		$body->setContent("ip", $_SERVER['REMOTE_ADDR']);
		
		break;
}

$main->setContent("body",$body->get());


$main->close();

?>
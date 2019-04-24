<?php


session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";


$main = new Skin("orange");
$body = new Skinlet("login");


$main->setContent("body", $body->get());
$main->close(); 





?>
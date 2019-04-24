<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

$main = new Skin("dipartimento");

$body = new Skinlet("person_2");

$user = new Content($homeEntity, $usersEntity, $roleEntity); 
$user->setJoinRules("",$usersEntity);
$user->setOrderFields("position");
$user->setLimit(1);


$user->propagate("homepage_username");
$user->apply($body);
$user->unsetParameter("homepage_id");



$menu = new Content($homeEntity, $usersEntity);
$menu->setOrderFields("position");
$menu->setFilter("homepage.active = '*'");
$menu->apply($body,"menu");



$main->setContent("body", $body->get());
$main->close();  

?>
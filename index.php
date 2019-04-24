<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

$main = new Skin("lightcorner");


$body = new Skinlet("home");
$main->setContent("body", $body->get());

/*
$content = new Content($pageEntity);
$content->setTemplate("home");
$content->setParameter("section", 1);

$content->setLimit(1);
$content->setOrderFields("position");





$main->setContent("body", $content->get());
*/
$main->close(); 


?>
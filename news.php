<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";



$main = new Skin("orange");

$news = new Content($newsEntity);
$news->setOrderFields("date DESC");

$main->setContent("body", $news->getPager(5));

$main->close();  

?>
<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

$main = new Skin("lightcorner");

$content = new Content($pageEntity);

$main->setContent("body", $content->get());
$main->close();  


?>
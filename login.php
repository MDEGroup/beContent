<?php

session_start();


require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$content = new Content($pageEntity);
$content->setParameter("section", 1);
$content->setLimit(1);
$content->setTemplate("login");
$content->setOrderFields("position");

$main->setContent("body", $content->get());

$main->close();

?>
<?php

session_start();


require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$sectionEntity);

$form->addSection("Section Management");

$form->addText("name", "Name", 40, MANDATORY);

if (!isset($_REQUEST['action'])) {
	$_REQUEST['action'] = "edit";
}
switch($_REQUEST['action']) {
	case "add":
	$main->setContent("body",$form->addItem());
	break;
	case "edit":
	$main->setContent("body",$form->editItem());
	break;
}

$main->close();

?> 
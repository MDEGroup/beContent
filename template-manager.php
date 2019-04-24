<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$templateEntity);

$form->addSection("Template Management");

$form->addText("name", "Name", 60, MANDATORY);
$form->addTextArea("dtml", "Template",20,50);

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
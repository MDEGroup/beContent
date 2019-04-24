<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$menuEntity);

$form->addSection("Menu Management");

$form->addText("entry", "Entry", 40, MANDATORY);
$form->addText("link", "Link", 60);

$form->addSelectFromReference2($pageEntity, "page_id", "Page");
$form->addSelectFromReference2($menuEntity, "parent_id", "Parent");


$form->addHierarchicalPosition("position", "Order", "entry", "parent_id");




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
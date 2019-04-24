<?php

session_start(); 

require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$pageEntity);

$form->addSection("Page Management");

$form->addText("title", "Titolo", 60);
$form->addTextarea("description", "Description", 10, 50);
$form->addText("subtitle", "Sottotitolo", 60);

$form->addSelectFromReference2($sectionEntity, "section", "Sezione");
$form->addHierarchicalPosition("position", "Page Order", "title", "section");



$form->addEditor("body", "Content",20,50);

$form->addFile("foto", "Foto");
$form->addText("link", "Link", 60);


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
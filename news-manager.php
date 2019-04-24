<?php

session_start();


require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$newsEntity);

$form->addSection("News Management");

$form->addText("title", "Titolo", 80, MANDATORY);
$form->addLongDate("date", "Data", MANDATORY);

$form->addEditor("body", "Testo", 20, 50);
$form->addCheck("Attiva", ":active:*:CHECKED");


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
<?php

session_start();


require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$groupsEntity);

$form->addSection("Group Management");

$form->addText("name", "Name", 40, MANDATORY);
$form->addEditor("description", "Description", 17, 120);

$form_services = new Form("dataEntry2", $servicesGroupsRelation);


$form_services->addRelationManager("services", "Services", LEFT);
$form->triggers($form_services);

$form_users = new Form("dataEntry3", $usersGroupsRelation);

$form_users->addRelationManager("users", "Users", LEFT);
$form->triggers($form_users);

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
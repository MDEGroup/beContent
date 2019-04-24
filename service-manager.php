<?php

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/auth.inc.php";

$main = new Skin(); 
$form = new Form("dataEntry",$servicesEntity);

$form->addSection("Service Management");

$form->addText("name", "Name", 40, MANDATORY);
$form->addText("script", "Script", 60, MANDATORY);
$form->addEditor("des", "Description", 15, 40);

$form->addSection("Menu");

$form->addText("entry", "Menu Entry", 40, MANDATORY);
$form->addSelectFromReference2($servicecategoryEntity,"servicecategory", "Category");

$form->addHierarchicalPosition("position", "Position", "name", "servicecategory");    
$form->addCheck("Visible", ":visible:*:*");
$form->addSection("Data filtering");


$form->addSelectFromReference2($entitiesEntity, "id_entities", "Entity");
$form->restrictReference("id_entities", "owner = '1' or name = '{$usersEntity->name}' or name = '{$logEntity->name}'");

$form->addSelectFromReference2($groupsEntity, "superuser_group", "Superuser Group");
                  


$form_groups = new Form("dataEntry2", $servicesGroupsRelation);

$form->addSection("Groups");
$form_groups->addRelationManager("groups", "Groups");
$form->triggers($form_groups);

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
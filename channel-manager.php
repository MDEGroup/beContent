<?php

session_start();


require "include/template2.inc.php"; 
require "include/beContent.inc.php";

require "include/auth.inc.php";

$main = new Skin(); 

$form = new Form("dataEntry",$channelEntity);
/* 

$channelEntity = new Entity($database,"bc_channel");
$channelEntity->setPresentation("title");
$channelEntity->addField("title",VARCHAR,50,MANDATORY);
$channelEntity->addField("link",VARCHAR,100,MANDATORY);
$channelEntity->addField("description",VARCHAR,150,MANDATORY);
$channelEntity->addReference($lanEntity, "language");

$channelEntity->addField("image_title",VARCHAR,50);
$channelEntity->addField("image_link",VARCHAR,100);
$channelEntity->addField("image",FILE);

$channelEntity->connect();
*/

$form->addSection("RssChannel Management");

$form->addText("title", "Title", 50, MANDATORY);
$form->addText("link","Link",50,MANDATORY);
$form->addEditor("description", "Description",17,30);
$form->addSelectFromReference2($lanEntity, "language", "Language");

$form->addSection("Image");

$form->addText("image_title","Title",50);
$form->addText("image_link","Link",50);
$form->addFile("image", "Image");

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
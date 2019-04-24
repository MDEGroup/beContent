<?php

session_start();


require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";

require "include/auth.inc.php";

$main = new Skin();

$form = new Form("dataEntry",$usersEntity);

switch ($_REQUEST['section']) {
	case "password":

		$form->addSection("Password");
		
		$form->addPassword("password", "New password", 20, MANDATORY);
		$form->addPassword("password2", "Confirm password", 20, MANDATORY);
		$form->addValidation("password", "password2", EQUAL, "The passwords do not match!");
		
		break;
	case "foto":
		$form->addSection("Foto");
		
		$form->addFile("foto", "Foto");
		
		break;
		
	default:

		$form->addSection("Your Profile");

		$form->addText("username", "Username");
		$form->addText("email", "Email", 50, MANDATORY);
		$form->addText("name", "Name", 40, MANDATORY);
		$form->addText("surname", "Surname", 40, MANDATORY);

		$form->addText("phone", "Phone", 20, MANDATORY);
		$form->addText("fax", "Fax", 20, MANDATORY);

		$form->addFile("foto", "Foto");

		$form->addCheck("Newsletter", ":active_newsletter:*:CHECKED");

		$form->addSection("Password");
		
		$form->addPassword("password", "New password", 20, MANDATORY);
		$form->addPassword("password2", "Confirm password", 20, MANDATORY);
		$form->addValidation("password", "password2", EQUAL, "The passwords do not match!");
		
		break;
}



if (!isset($_REQUEST['page'])) {
	$_REQUEST['page'] = 1;
	$_REQUEST['value'] = $_SESSION['user']['username'];
}

$main->setContent("body",$form->editItem(NO_DELETE));
	
$main->close();

?> 
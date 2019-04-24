<?php

	
session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";

/* LOCAL START */

Class UserForm extends Form {
	
	function UserForm($database, $resource, $method = "GET") {
		$this->FORM($database,$resource,$method);
	}
	
	function editItem_postDeletion() {
		
	}
	
	function addItem_preInsertion() {
		
		$password = substr(md5(time()),0,8);
		$_REQUEST['password'] = $password;
		
	}
	
	function addItem_postInsertion() {
		
		
		/* controllare reload */
		
		$skin = new Skin("dipartimento");
		$mail = new Skinlet("user.mail");
		
		
		$mail->setContent("name", $_REQUEST['name']);
		$mail->setContent("username", $_REQUEST['username']);
		$mail->setContent("password", $_REQUEST['password']);
		$mail->setContent("message", $_REQUEST['message']);
		$mail->setContent("email", $_REQUEST['email']);
		
		if (isset($_REQUEST['home'])) {
			$mail->setContent("home", "http://www.di.univaq.it/home.php?username={$_REQUEST['username']}");
			
			$GLOBALS['homeEntity']->insertItem(NULL, 
											  "{$_REQUEST['username']}",
											  date('YmdHi'), 
											  date('YmdHi'),
											  "Generale", 
											  "General",
											  "Home",
											  "Home",
											  "Pagina provvisoria di {$_REQUEST['name']} {$_REQUEST['surname']}", 
											  "Temporary page of {$_REQUEST['name']} {$_REQUEST['surname']}", 
											  "*", 
											  1); 
											  
											  

											  
		}
		
		aux::mail($_REQUEST['email'],"{$GLOBALS['config']['website']['name']} Login data", $mail->get(), $GLOBALS['config']['website']['email']);

	}	
}


/* LOCAL END */

$main = new Skin(); 

$form1 = new UserForm("dataEntry",$usersEntity);

$form1->addSection("User Management");

$form1->addText("username", "username", 20, MANDATORY);

$form1->addSection("personal data");

$form1->addText("email", "Email", 50, MANDATORY);
$form1->addText("name", "Name", 40, MANDATORY);
$form1->addText("surname", "Surname", 40, MANDATORY);
$form1->addSelectFromReference2($roleEntity, "role", "Position", MANDATORY);
$form1->addText("phone", "Phone", 20);
$form1->addText("fax", "Fax", 20);

$form1->addFile("foto", "Foto");
$form1->addCheck("Active", ":active:*:CHECKED");
$form1->addCheck("Home", ":home:*:CHECKED");
$form1->addCheck("Newsletter", ":active_newsletter:*:CHECKED");

$form2 = new Form("dataEntry2", $usersGroupsRelation);

$form1->addSection("usergroups");

$form2->addRelationManager("groups", "Groups");

$form1->triggers($form2);

Class myPager extends becontentPager {
	
	function myPager() {
		beContentPager::beContentPager();
	}
	
	function display($k,$v) {
		switch($k) {
			case "lastlogin": 
				return (aux::xmlchars(aux::formatDate($v, EXTENDED), MODE3) == "")?"mai loggato":aux::xmlchars(aux::formatDate($v, EXTENDED), MODE3);
				break;
		
			default:
				return beContentPager::display($k,$v);
				break;
		
		}
				
		return $v;
	}	
}

$pager = &new myPager();
$pager->setQuery("
	SELECT users.name, 
	       users.surname, 
	       users.username, 
	       users.email, 
	       users.active
	  FROM users ");

$pager->setFilter("(name LIKE '%[search]%' OR surname LIKE '%[search]%' OR username LIKE '%[search]%')");
$pager->setOrder("name, surname");

$pager->setTemplate("dtml/report-users.html");
$form1->setPager($pager); 




if (!isset($_REQUEST['action'])) {
	$_REQUEST['action'] = "edit";
}

switch($_REQUEST['action']) {
	case "add":
	$form1->addTextArea("message", "Message", 10, 50);
	$main->setContent("body",$form1->addItem());
	break;
	case "edit":
	$main->setContent("body",$form1->editItem());
	break;
}

$main->close();

?> 
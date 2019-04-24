<?php

#DEFINE("ALL", "ALL");
DEFINE("ONLY_PUBLIC", "ONLY_PUBLIC");
DEFINE("ONLY_PRIVATE", "ONLY_PRIVATE");
DEFINE("NONE", "NONE");

	/*
	
	This file is part of beContent.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with beContent.  If not, see <http://www.gnu.org/licenses/>.
    
    http://www.becontent.org
    
    */
    
	/* 
	
	MySQL CONFIGURATION PARAMETERS
	
	The following array is indexed by different possible $_SERVER['SERVER_NAME'] values,
	for instance "localhost" (you development architecture domain) and www.domain.com
	(your deployment architecture domain), and for each of them the values for

		- host 		: the mysql server host
		- database 	: the database name
		- username	: the mysql username 
		- password 	: the password
		
	Eventually, if additional platform domains or alias are used they have to be appended
	below.
	
	*/
        
        #echo $_SERVER['SERVER_NAME'];
        
        
        
	
	$config['database'] = Array(
				
		"localhost" 		=> Array(
			"host" => "localhost",
			"database" => "becontent",
			"username" => "root",
			"password" => ""),
		"aica2010.univaq.it" 	=> Array(
			"host" => "localhost",
			"database" => "aica2010",
			"username" => "aica2010",
			"password" => "@1c@2010")

	);
	

	/* 
	
	BACKOFFICE LANGUAGE
	
	Available languages: ENGLISH, ITALIANO 
		
	*/
	                  
	$config['language'] = ITALIANO;
	
	/* 
	
	DEFAULT ADMINISTRATION USER
	
	Please provide the following information, the system will create an administrator 
	user who will be given all the necessary permissions, you will be able to change
	all the permission criteria in the corresponding panels (users, groups, services).
	
	*/
	
	$config['defaultuser'] = Array(
							"username" 	=> "admin",
							"password" 	=> "viva1felice",
							"email" 	=> "alfonso.pierantonio@gmail.com",
							"name" 		=> "Alfonso",
							"surname" 	=> "Pierantonio"
	
	);
	
	
	
	/* 
	
	WEBSITE BASIC INFORMATION.
	
	You can customize the website name, the payoff is kind of subtitle, it will be 
	used for instante in the <title>.
 		
 	*/
	
	$config['website'] = Array(
							"name" 		=> "Terraemotus - Il luogo del ricordo",
							"payoff"	=> "",
							"email"		=> "info@terraemotus.it",
							"domain" 	=> "terraemotus.it",
							"fulldomain" => "http://www.terraemotus.it",
							"keywords"	=> "Terraemotus - Il luogo del ricordo",
							"description" => "Terraemotus - Il luogo del ricordo"
							
	);
	
	
	DEFINE("NEWS", "news");
	
	
	/* 
	
	BECONTENT CONFINGURATION PARAMETERS
	
	*/
	
	$config['logging'] = true;					// The system logging enabled/disabled
	
	$config['upload_folder'] = "upload";		// Upload directory to be used by the FILE2FOLDER types, it must
												// have the right permission
	$config['cache_folder'] = "cache";			// Cache directory, it must hace the right permission
	$config['os'] = WINDOWS;					// Operating System -- deprecated
	
	$config['mail_bulk_dimension'] = 4;			// It denotes the number of mails to be sent at once by the beContent 
												// Newsletter system to avoid the system to be interrupted after 30 secs
												// execution
	
	$config['registered_usergroup'] = 20000;	// The registered user group id, 20000 is it does not exists
	$config['admin_usergroup'] = 1;				// Default administration usergroup, do not change
		
	$config['skin'] = "default";				// Default skin name
	
	$config['cache_mode'] = NONE;        // Skin cache mode: ALL|ONLY_PUBLIC|ONLY_PRIVATE|NONE
	$config['cache_mode'] = NONE;        // Skin cache mode: ALL|ONLY_PUBLIC|ONLY_PRIVATE|NONE
#	$config['cache_timeout'] = 7200; 			// Skin cache timeout in secs
	$config['cache_timeout'] = 60;
	
	
	
	
	switch ($_SERVER['SERVER_NAME']) {			// Base value depending on the $_SERVER['SERVER_NAME'] value
		case "localhost":	
			$config['base'] = "terraemotus";
			break;
		case "www.terraemotus.it":
			$config['base'] = "";
			break;
	}
	
	$config['languages']['it'] = true;			// Enabled languages
	$config['languages']['en'] = true;
	
	/*  ******************************************************** 
	
		SESSION related parameters goes here, eg language et al
		
		******************************************************** */
	
	if (!isset($_SESSION['language'])) {
		
		switch (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2)) {
			case "it":
			case "en":
				$_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
			break;
			default:
				$_SESSION['language'] = "en";
			break;
		}
	
		$_SESSION['language'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
	
	} else { 
	
		if (isset($_REQUEST['lan'])) { 
				$_SESSION['language'] = $_REQUEST['lan'];
		}
	}

	$config['currentlanguage'] = $_SESSION['language'];
	#$config['currentlanguage'] = "it";
	
	
	
	
	
	
	
	/* The following function is called for each 'main' template */
	
	function shared() {
		global 	
			$main;
		
            if (basename($_SERVER['PHP_SELF']) == "index.php") {
                $main->setContent("class", "homepage");    
            } else {
                $main->setContent("class", "subpage");
            }
    /*            
            $news = new Content($GLOBALS['newsEntity']);
            $news->setLimit(3);
            $news->setOrderFields("date DESC");
            $news->apply($main);
    */
		
		
	}
	
?>

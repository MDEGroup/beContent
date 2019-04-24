<?php

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


Class Auth {

	function isSuperuser() {
		
		$group = Auth::getSuperusergroup();
		$trovato = false;
		
		foreach($_SESSION['user']['services'] as $k => $v) {
			
			if($v['id_groups'] == $group) {				
				$trovato = true;
			}
		}
		
		return $trovato;
	}
	
	function isAdmin() {
		
		return $_SESSION['user']['admin'];
		
	}
	
	function getSuperusergroup() {
		
		$trovato = false;
		$i=0;
		while (($i<count($_SESSION['user']['services'])) and (!$trovato)) {
			if ($_SESSION['user']['services'][$i]['script'] == basename($_SERVER['SCRIPT_FILENAME'])) {
				$trovato = true;
				$result = $_SESSION['user']['services'][$i]['superuser_group'];
			}
			
			$i++;
		}
		
		return $result;
		
	}
	
	function getGroups() {
		
		foreach($_SESSION['user']['services'] as $v) {
			$groups[$v['id_groups']] = $v['id_groups'];
		}
		
		foreach($groups as $v) {
			$result[] = $v;
		}
		
		return $result;
	}
	
	function doLogin() {		
		 
		
		if (!isset($_SESSION['user'])) {
				
			/* User not Logged */
	
			$debug_action = "USER NOT LOGGED";
			
			
			if ((!isset($_POST['username'])) and (!isset($_POST['password']))) {
				
				if (!isset($_SESSION['HTTP_LOGIN'])){
					unset($GLOBALS['_SERVER']['PHP_AUTH_PW']);
					unset($GLOBALS['_SERVER']['PHP_AUTH_USER']);
					
					/*
					
						Some message should be *maybe* emitted here !
						
					*/ 
					
				}
				if ((!isset($_SERVER['PHP_AUTH_USER'])) and (!isset($_SERVER['PHP_AUTH_PW']))) {					
					Header("WWW-Authenticate: Basic realm=\"Login \"");
	      			Header("HTTP/1.0 401 Unauthorized");
	      			$_SESSION['HTTP_LOGIN'] = true;
	      			exit;
				} else {
								   
					$_POST['username'] = $_SERVER['PHP_AUTH_USER'];
					$_POST['password'] = $_SERVER['PHP_AUTH_PW'];
					$_SESSION['HTTP_LOGIN'] = false;			
				}
				
				
			}
			
			$name = addcslashes($_POST['username'],"'");
			
			$oid = mysql_query("SELECT * 
		                  	    FROM {$GLOBALS['usersEntity']->name} 
		                  	   WHERE username = '{$name}'
		                  	     AND password = MD5('{$_POST['password']}')");
			
		
			if (!$oid) {		
				
				echo "Error in database!<hr>";
				echo mysql_error();
					exit;		
			}
			
			if (mysql_num_rows($oid) == 0) {
				
				Header("Location: error.php?id=loginError");
				exit;
			
			} else {
				
				$userdata = mysql_fetch_assoc($oid);
				
				$_SESSION['user']['username'] = $userdata['username'];
				$_SESSION['user']['name'] = $userdata['name'];
				$_SESSION['user']['surname'] = $userdata['surname'];
				$_SESSION['user']['email'] = $userdata['email'];


				$oid = mysql_query("SELECT DISTINCT {$GLOBALS['usersEntity']->name}.username, 
				                           {$GLOBALS['servicesEntity']->name}.entry AS serviceName,
				                           {$GLOBALS['servicesEntity']->name}.visible,
				                           {$GLOBALS['servicesEntity']->name}.id_entities AS entity,
				                           {$GLOBALS['servicesEntity']->name}.script,
				                           {$GLOBALS['servicesEntity']->name}.superuser_group,
				                           {$GLOBALS['servicecategoryEntity']->name}.name AS category,
				                           {$GLOBALS['entitiesEntity']->name}.name AS tableName,
				                           {$GLOBALS['usersGroupsRelation']->name}.id_groups
				                           
                                  FROM {$GLOBALS['usersEntity']->name}            
                             LEFT JOIN {$GLOBALS['usersGroupsRelation']->name} 
                                    ON {$GLOBALS['usersGroupsRelation']->name}.username = {$GLOBALS['usersEntity']->name}.username
                             LEFT JOIN {$GLOBALS['groupsEntity']->name} 
                                    ON {$GLOBALS['groupsEntity']->name}.id = {$GLOBALS['usersGroupsRelation']->name}.id_{$GLOBALS['groupsEntity']->name}
                             LEFT JOIN {$GLOBALS['servicesGroupsRelation']->name} 
                                    ON {$GLOBALS['servicesGroupsRelation']->name}.id_{$GLOBALS['groupsEntity']->name} = {$GLOBALS['groupsEntity']->name}.id
                             LEFT JOIN {$GLOBALS['servicesEntity']->name} 
                                    ON {$GLOBALS['servicesEntity']->name}.id = {$GLOBALS['servicesGroupsRelation']->name}.id_{$GLOBALS['servicesEntity']->name}
                             LEFT JOIN {$GLOBALS['entitiesEntity']->name}
                                    ON {$GLOBALS['entitiesEntity']->name}.name = {$GLOBALS['servicesEntity']->name}.id_{$GLOBALS['entitiesEntity']->name}
                             LEFT JOIN {$GLOBALS['servicecategoryEntity']->name}
                                    ON {$GLOBALS['servicecategoryEntity']->name}.id = {$GLOBALS['servicesEntity']->name}.servicecategory
                    
                                 WHERE {$GLOBALS['usersEntity']->name}.username =  '{$_SESSION['user']['username']}'
                              ORDER BY {$GLOBALS['servicecategoryEntity']->name}.position, {$GLOBALS['servicesEntity']->name}.position");
				
				
				
				if (!$oid) {
					
				
					echo "Error in database!<hr>";
					echo mysql_error();
					
					exit;
				}
				
				do {
					$data = mysql_fetch_assoc($oid);
					if ($data) {
						$_SESSION['user']['services'][] = $data;
						$_SESSION['user']['services'][$data['script']] = $data; 
						$_SESSION['user']['groups'][$data['id_groups']] = $data['id_groups'];
					
					}
					
				} while ($data);
				
				$lastlogin = aux::getResult("
				                SELECT * 
				                  FROM {$GLOBALS['logEntity']->name} 
				                 WHERE username = '{$_SESSION['user']['username']}'
				                   AND operation = 'LOGIN'
				              ORDER BY date DESC
				                 LIMIT 1");
				
				if (isset($lastlogin)) {
					$_SESSION['user']['lastlogin'] = $lastlogin[0]['date'];
				} else {
					$_SESSION['user']['lastlogin'] = "";
				}
				$GLOBALS['logEntity']->insertItem(NULL, 
										  'LOGIN',
										  '',
										  '',
										  basename($_SERVER['SCRIPT_FILENAME']),
										  $_SESSION['user']['username'],
										  date("YmdHi"),
										  $_SERVER['HTTP_HOST']);
			}
		} else {
			$debug_action = "USER_LOGGED";
		}
		
		if (is_array($_SESSION['user']['services'])) {
			$debug_action = " services array ";
			
		} else {
			$debug_action = " services NOT array ";
			
			#echo "PROBLEM ";
			
			#exit;
			
		}
		
		#print_r($_SESSION); 
		$trovato = false;
		$error = 212;
		
		if (is_array($_SESSION['user']['services'])) {
			foreach ($_SESSION['user']['services'] as $k => $v) {
				
				$error = 217;
		

				if ($v['script'] == basename($_SERVER['SCRIPT_NAME'])) {
					$trovato = true;
					$currentService = $v;
						$error = 223;
				}
			}
		}

		if ((basename($_SERVER['SCRIPT_NAME'])=="error.php") or (basename($_SERVER['SCRIPT_NAME'])=="login.php") or (basename($_SERVER['SCRIPT_NAME'])=="logout.php")) {
				
			$trovato=true;
		
		}
			
		if (!$trovato) {		
			
			#echo $script;
			if (basename($_SERVER['SCRIPT_NAME']) != "ajax-manager.php") {
				
				Header("Location: error.php?id=priviledgeError&{$error}&{$debug_action}");
				exit;
			}
		} 
		
		
		
		///se abilitato il datafiltering///////////////////////////////////////
		
	
		
		if (isset($currentService['tableName'])) { // Data Filtering Check
			
			if ((isset($_REQUEST['page'])) and ($_REQUEST['page'] > 0) and ($_REQUEST['action'] == "edit")) {
				
				
				$result = mysql_query("select * from {$currentService['tableName']}");
				if (!$result) {
    				echo "Generic Database Error!";
    				exit;
				}
				
    			$meta = mysql_fetch_field($result, 0);
    			if (!$meta) {
        			echo "Metadata Error!";
    				exit;
    			}
    				
				$oid = mysql_query("SELECT username
			                          FROM {$currentService['tableName']}
             					     WHERE {$meta->name} = '{$_REQUEST['value']}' ");
				if (!$oid) {
					echo "Error in database!<hr>";
					echo mysql_error();
					exit;
				}
			
				$data = mysql_fetch_assoc($oid);
				
				if ($data['username'] != $_SESSION['user']['username']) {
					
						
					/* CHECK FOR SUPERUSER_GROUP */
					
					$superuser_group = Auth::getSuperusergroup();
					$mygroups = Auth::getGroups();
					
					echo Auth::isSuperuser();
					
					if (!in_array(Auth::getSuperusergroup(), Auth::getGroups()) and (!Auth::isAdmin())) {
							
							
						Header("Location: error.php?id=dataFiltering&289");	
						exit;
					} else {
						
						
						
					}
				}	
			}
		}
		
		if (!isset($_SESSION['registered-user'])) { 
			$trovato = false;
		
			if (is_array($_SESSION['user']['services'])) {
				foreach($_SESSION['user']['services'] as $k => $v) {
					if($v['id_groups'] == $GLOBALS['config']['registered_usergroup']) {
				
						$script = $_SERVER['HTTP_REFERER'];
					
						$_SESSION['registered-user'] = true;
					
					
						Header("Location: {$script}");
						exit;
					}
				}
			}
		}
		
		
		////////////////////////////////////////////////////
		
		$_SESSION['user']['admin'] = false;
		
		if (is_array($_SESSION['user']['services'])) {
			foreach($_SESSION['user']['services'] as $k => $v) {
			
				if($v['id_groups'] == $GLOBALS['config']['admin_usergroup']) {				
					$_SESSION['user']['admin'] = true;
				}
			}
		}	
	}
	
	
}




Auth::doLogin();

?>
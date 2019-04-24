<?php

session_start();

require "include/beContent.inc.php";
require "include/auth.inc.php";

$entity = $database->getEntityByName($_REQUEST['table']);


$data['item'] = $entity->getReference(BY_POSITION, 
		                              $_REQUEST['position'], 
		                              "{$_REQUEST['reference']} = '{$_REQUEST['value']}'");

foreach($_REQUEST as $k => $v) {
	$data[$k] = $v;
}

#print_r($data);
#echo "<hr>";

echo aux::AjaxEncode($data);


?>
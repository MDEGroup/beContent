<?


session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";


$main = new Skin("dipartimento");

$main->setContent("body", $becontent->search($pageEntity, 
											 $newsEntity,
											 $eventEntity,
											 $usersEntity,
											 $faqEntity,
											 $pubEntity));											


$main->close();



?>

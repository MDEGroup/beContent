<?

session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";
require "include/content.inc.php";



$main = new Skin("dipartimento");

if (!isset($_GET['id'])) {
	
	$data=aux::getResult("SELECT id,title,description FROM {$channelEntity->name}");

	$body=new Skinlet("rss.html");

	
	$body->setContent("website", $GLOBALS['config']['website']['name']);
	$body->setContent("item", $data);
	
	$main->setContent("body", $body->get());


	$main->close();

} else {
	
	$rss=new FeedRss($channelEntity);
	
	$data=aux::getResultArray("SELECT title FROM {$channelEntity->name} WHERE id={$_GET['id']}",'title');
    
	$rss->addChannel("{$data[0]}");
    
	$rss->emitXML();
}


?>
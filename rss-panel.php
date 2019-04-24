<?php
session_start();

require "include/template2.inc.php";
require "include/beContent.inc.php";

require "include/auth.inc.php";
require "include/tags/formTag.inc.php";	

class CheckForm extends Form 
{
	function CheckForm($database,$entity,$metod="GET"){
		$this->database=$database;
		$this->entity=$entity;
		$this->method=$metod;
	}
	function addItem_sub()
	{
		$query="TRUNCATE TABLE channel_entity";
	$oid = mysql_query($query);
    if (!$oid) {
		echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELATION_INSERT)." (".basename(__FILE__).":".__LINE__.")";
		exit;
    }
    	$query="TRUNCATE TABLE bc_rss_mod";
	$oid = mysql_query($query);
    if (!$oid) {
		echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELATION_INSERT)." (".basename(__FILE__).":".__LINE__.")";
		exit;
    }
    
    foreach ($_REQUEST as $i=>$v)
    {
    	$temp=preg_split("/_-/",$i);
    	if($temp[0]=="check")
    	{
					$query="INSERT INTO channel_entity VALUE (NULL,'{$temp[1]}','{$v}')";
					//print($query);
					//print"\n";
					$oid=mysql_query($query);
					if (!$oid) {
		 				return false;
					}
    	}
    	if($temp[0]=="MOD")
    	{
    		$query="INSERT INTO bc_rss_mod VALUE ('{$temp[1]}','{$v}')";
    		$oid=mysql_query($query);
					if (!$oid) {
		 				return false;
					}
    	}
	}
		return true;
	}
	function emitHTML_post()
	{
	$allChannel=aux::getResult("SELECT id,title FROM bc_channel");
	$count=0;
	$x=0;
	$temp=$allChannel;
	while($x<count($GLOBALS['becontent']->entities))
	{
		if($GLOBALS['becontent']->entities[$x]->rss)
		{	
			$content=array();			
			$nameEntity=$GLOBALS['becontent']->entities[$x]->name;	
			
			$query="SELECT id_bc_channel FROM channel_entity WHERE entity=\"{$nameEntity}\"";
			$content=aux::getResult($query);
			$mod=aux::getResult("SELECT modality FROM bc_rss_mod WHERE entity=\"{$nameEntity}\"");
			$mod=$mod[0];
			
			$data=array();
			$i=0;
			while ($content[$i]) {
				$data[]=$content[$i++]['id_bc_channel'];
			}
			//print_r($data);
        	
			$i=0;
			while ($i<count($allChannel)){	
				if(is_array($data))				
					$temp[$i]['checked']=in_array($temp[$i]['id'],$data);
				else $temp[$i]['checked']=false;
				$temp[$i]['nameEntity']=$nameEntity;
				$temp[$i]['mod']=$mod['modality'];
				$i++;
				//print_r($temp);
			}		
			$buffer[$count]=$temp;
			$temp=$allChannel;
			$count++;
			
		}
		$x++;		
	}
	//print_r($buffer);
	$content=formTag::lista("prova",$buffer,aux::parsePars("text=\"title\" name=\"title\" value=\"id\" checked=\"checked\" field=\"nameEntity\" mod=\"mod\""));
	return $content;
	}
}


	$main = new Skin(); 
	
	
	
	
	$form=new CheckForm("prova",$channelAssotiation);
    $form->addSection("Seleziona i canali su cui publicare");
    
    
    $main->setContent("body", $form->addItem());
	
$main->close();

?>
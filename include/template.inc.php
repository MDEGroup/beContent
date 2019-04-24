<?php

DEFINE("SQUARE", 1);
DEFINE("CURL", 2);

/* 

	Copyright 2006 (C) Alfonso Pierantonio
	
	This library can freely be used and distributed 
	provided that you send and email to 
	
		alfonso [at] di.univaq.it
		
	specifying [beContent] in the subject and the following
	information
	
		1. name, surname
		2. affiliation
		3. commercial/personal
		4. website where is in use 	
	
	Please consider to make a donation with payPal at the
	following address

		alfonso [at] di.univaq.it
		
	Thank you!
	

*/ 

function getDaySelect() {
    

  $data[0][value] = "";
  $data[0][text] = "";
  for($i=1;$i<=31;$i++) {

    if ($i < 10) {
      $dummy = "0$i";
    } else {
      $dummy = "$i";
    }

    $data[$i][value] = $dummy;
    $data[$i][text] = $dummy;
  }

  return $data;
}

function getMonthSelect() {
    
  $data[0][value] = "";
  $data[0][text] = "";

  for($i=1;$i<=12;$i++) {

    if ($i < 10) {
      $dummy = "0$i";
    } else {
      $dummy = "$i";
    }

    $data[$i][value] = $dummy;
    $data[$i][text] = $dummy;
  }

  return $data;
}



function query($query,$link = "") {
  global       
    $SCRIPT_FILENAME;

  $oid = mysql_query($query);

  if (!$oid) {
    $code = returnCode(error,generic,__FILE__,__LINE__);
  }

  do {
    $data = mysql_fetch_assoc($oid);
    if ($data) {
      $content[] = $data;
    }
  } while ($data);

  $script = basename($SCRIPT_FILENAME);
  if (($link != "") and (count($content) == 0)) {

    if (getType($link) == "integer") {
      Header("Location: $script?page=$link&code=$code");
    } else {
      Header("Location: $link&code=$code");
    }
  } else {
    return $content;
  }
}


Class Render {

  function ShowData($name,$data,$parameters,$value = "",$event = "") {
    
    $content .= "<table bgcolor=#eeeeee style='border: 2px solid salmon;'>";
    $content .= "<tr><td>Widget Name</td><td><b>$name</b></td></tr>\n";
    
    if ($parameters != "") {
          $content .= "<tr><td>Parameters</td><td>$parameters</td></tr>\n";
    }

    $content .= "<tr><td>Data count</td><td>".count($data)."</td></tr>\n";
    

    if (count($data)>0) {

      $content .= "<tr><td colspan=2><hr style='height: 1px; background: salmon; width: 98%;' ></td></tr>\n";


      foreach($data as $k => $v) {

	$content .= "<tr><td align=center>$k</td><td>";

	foreach($v as $k1 => $v1) {

	  $content .= "$k1: $v1<br>";
	}
	$content .="<hr style='height: 1px; background: salmon; width: 98%;'></td></tr>\n";

      }

    }
    

    
    $content .= "</table>";

    return $content;
  }

  function explodeParameters($parameters) {

    $buffer = $parameters;

    do {

      $result = ereg("^([[:alnum:]]+)",$buffer,$token);

      if ($result) {

	$buffer = ereg_replace("^$token[1]","",$buffer);

	$result2 = ereg("^\\=\"([[:alnum:] ]*)\"",$buffer,$token2);

	if ($result2) {

	  $buffer = ereg_replace("^\\=\"$token2[1]\"[[:space:] ]*","",$buffer);

	  $par[$token[1]] = $token2[1];

	}
      }

    } while ($result);

    return $par;
  }


  function Select($name,$data,$parameters = "",$value = "",$event = "") {

    /* 

       $data is formatted like this 

       $data[0][value] 
       $data[0][text]

    */

    $attributes = Render::explodeParameters($parameters);
    $event = $attrubutes[event];

    $content .= "<select name=\"$name\" $event class=dataentry>\n";

    if (count($data) == 0) {
      $content .= "<option value=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
    } else {

      if (isset($attributes[first])) {
	$content .= "<option value=\"\">$attributes[first]\n";
      }      
    }

    if (count($data) > 0) { 
      foreach($data as $k => $v) {
	
	if (($v[value] == $value) or ($v[value] == $attributes[value]) or ($v[checked]) or ($v[selected])) {
	  $content .= "<option value=\"$v[value]\" selected> $v[text]\n";
	} else {
	  $content .= "<option value=\"$v[value]\"> $v[text]\n";
	}
      }
    }

    $content .= "</select>\n";

    return $content;
  } 

  function CheckBoxList($name,$data) {

    /* 

       $data is formatted like this 

       $data[0][value] 
       $data[0][text]
       $data[0][checked]

    */

    $content .= "<table cellspacing=0 cellpadding=0 width=100%>\n";

    foreach($data as $k => $v) {

      if (($k % 2) == 0) {
	$content .= my_comma(checkboxlist,"</td></tr>")."<tr><td width=1%>\n";
      } else {
	$content .= "</td><td width=1%>\n";
      }

      if ($v[checked]) {
	$content .= "<input type=checkbox name=\"".$name."_$v[value]\" value=\"*\" checked></td><td width=49%>$v[text]\n";
      } else {
	$content .= "<input type=checkbox name=\"".$name."_$v[value]\" value=\"*\"></td><td width=49%>$v[text]\n";
      }
    }

#    echo count($data);

    $contemt .= "</td></tr>\n";
    $content .= "</table>\n";

    return $content;
  } 

  function RadioBox($name,$data) {

    /* 

       $data is formatted like this 

       $data[0][value] 
       $data[0][text]
       $data[0][checked]

    */

    $content .= "<table cellspacing=0 cellpadding=0 width=100%>\n";

    foreach($data as $k => $v) {

      if (($k % 2) == 0) {
	$content .= my_comma(checkboxlist,"</td></tr>")."<tr><td width=1%>\n";
      } else {
	$content .= "</td><td width=1%>\n";
      }

      if ($v[checked]) {
	$content .= "<input type=radio name=\"$name\" value=\"*\" checked></td><td width=49%>$v[text]\n";
      } else {
	$content .= "<input type=radio name=\"$name\" value=\"*\"></td><td width=49%>$v[text]\n";
      }
    }

#    echo count($data);

    $contemt .= "</td></tr>\n";
    $content .= "</table>\n";

    return $content;
  } 


  function HiddenList($name,$data) {

    /* 

       $data is formatted like this 

       $data[0][value] 
       $data[0][text]

    */

    $content = "<input type=hidden name=$name value=\"".addslashes(serialize($data))."\">";

    return $content;
  } 

  function Date($name,$mode = "",$today = "") {

    switch($mode) {
    case forward:
      $year_min = date(Y);
      $year_max = date(Y)+2;
      break;
    case backward:
      $year_min = date(Y)-20;
      $year_max = date(Y)+2;
      break;
    default:
      $year_min = date(Y)-20;
      $year_max = date(Y)+20;
      break;
    }
   
    if ($today == "") {
      $today = date(Ymd);
    }

    $content .= "<select name=$name"."_d class=dataentry>\n";
    $content .= "<option>\n";
    
    for ($i=1;$i<=31;$i++) {
      if ($i < 10) {
	$dummy = "0$i";
      } else {
	$dummy = "$i";
      }
      if (substr($today,6,2) == $dummy) {
	$content .= "<option value=$dummy selected>$dummy\n";
      } else {
	$content .= "<option value=$dummy>$dummy\n";
      }
    }
    $content .= "</select>\n";
    
    $content .= "<select name=$name"."_m class=dataentry>\n";
    $content .= "<option>\n";
    for ($i=1;$i<=12;$i++) {
      if ($i < 10) {
	$dummy = "0$i";
      } else {
	$dummy = "$i";
      }
      if (substr($today,4,2) == $dummy) {
	$content .= "<option value=$dummy selected>$dummy\n";
      } else {
	$content .= "<option value=$dummy>$dummy\n";
      }
    }
    $content .= "</select>\n";
    
    $content .= "<select name=$name"."_y class=dataentry>\n";
    $content .= "<option>\n";

    for ($i=$year_min;$i<=$year_max;$i++) {
      if (substr($today,0,4) == $i) {
	$content .= "<option value=$i selected>$i\n";
      } else {
	$content .= "<option value=$i>$i\n";
      }
    }
    $content .= "</select>\n";
    
    return $content;
 } 

  function getDate($name) {

    return $GLOBALS[$name."_y"].$GLOBALS[$name."_m"].$GLOBALS[$name."_d"];
  }

}





#ob_start(); 
#ob_implicit_flush(0); 

function CheckCanGzip(){ 
  global $HTTP_ACCEPT_ENCODING;    

  if (headers_sent() || 
      connection_aborted()){ 
    return 0; 
  } 

  if (ereg("x-gzip",$HTTP_ACCEPT_ENCODING) !== false) {
    return "x-gzip"; 
  }

  if (ereg("gzip",$HTTP_ACCEPT_ENCODING) !== false) {
    return "gzip";
  } 


  return 0; 
} 

/* $level = compression level 0-9, 0=none, 9=max */

function GzDocOut($level=9,$debug = 0){ 


  $ENCODING = CheckCanGzip(); 
    

  if ($ENCODING){

    $Contents = ob_get_contents(); 
    ob_end_clean();
      $s = "\n<!-- Koriandol compress module : $ENCODING (".strlen($Contents)."/".strlen(gzcompress($Contents,$level)).") -->\n";
      $Contents .= $s;

    header("Content-Encoding: $ENCODING");  	
    print "\x1f\x8b\x08\x00\x00\x00\x00\x00"; 
    $Size = strlen($Contents); 
    $Crc = crc32($Contents); 
    $Contents = gzcompress($Contents,$level); 
    $Contents = substr($Contents, 0, strlen($Contents) - 4); 
    print $Contents; 
    print pack('V',$Crc); 
    print pack('V',$Size); 
    exit; 
  }else{ 
    ob_end_flush(); 
    exit; 
  } 
} 

class Template {
  var 
    $template_file,
    $buffer,
    $foreach,
    $content,
    $pars,
    $debug,
    $parsed,
    $tags,
    $escaped_tags;


  function Template($filename = "") {
  	
  	$this->template_file = $filename;
  	$this->parsed = false;
  	$this->setTagStyle(SQUARE);
  	
  }
  
  function setTagStyle($style) {
  	
  	
  	
  	switch ($style) {
  		case CURL:
  			
  			
  			$this->tags['open'] = "{";
  			$this->tags['close'] = "}";
  			$this->escaped_tags['open'] = "{";
  			$this->escaped_tags['close'] = "}";
  		break;
  		case SQUARE:
  		default:
  			$this->tags['open'] = "<[";
  			$this->tags['close'] = "]>";
  			$this->escaped_tags['open'] = "<\[";
  			$this->escaped_tags['close'] = "\]>";
  		break;
  	}
  	
  }
  
  function setTemplate($content) {
  	$this->buffer = $content;
  }
  
  function setContent($name, $value, $pars = "") {
    $this->content[$name][] = $value;
    $this->pars[$name][] = $pars;


  }

 

  function pre($var) { 
    if ($this->debug == "DEBUG") {
      return "<!- begin:$var -->";
    }
  }
  
  function post($var) { 
    if ($this->debug == "DEBUG") {
      return "<!- end:$var -->";
    }
  }
  
  function parse() {
  	
  	
  	if ($this->template_file != "") {
  		
    	$fp = fopen ($this->template_file, "r");
    	$this->buffer = fread($fp, filesize($this->template_file));         
    	fclose($fp);
    	$i=0;
    	do {
      		$result = ereg("{$this->escaped_tags['open']}foreach{$this->escaped_tags['close']}(.+){$this->escaped_tags['open']}\/foreach{$this->escaped_tags['close']}",$this->buffer,$token);
      		if ($result) {
				$this->foreach[] = $token[1];
				$this->buffer = ereg_replace("{$this->escaped_tags['open']}foreach{$this->escaped_tags['close']}.+{$this->escaped_tags['open']}\/foreach{$this->escaped_tags['close']}","{$this->tags['open']}foreach$i{$this->tags['close']}",$this->buffer);
      		} 
      		$i++;
    	} while ($result);
  	} 
    
    $this->parsed = true;
    
    for($i=0;$i<count($this->foreach);$i++) {
    
      $result = ereg("{$this->escaped_tags['open']}([a-zA-Z0-9_]+){$this->escaped_tags['close']}",$this->foreach[$i],$token);
      if ($result) {
          $iterations = count($this->content[$token[1]]);
      }    
      
      $this->content["foreach$i"][0] = '';
      for ($j=0;$j<$iterations;$j++) {
          $buffer = $this->foreach[$i];
          do {
              
              $result = ereg("{$this->escaped_tags['open']}([a-zA-Z0-9_]+){$this->escaped_tags['close']}",$buffer,$token);
              if ($result) {
                  
                  $buffer = ereg_replace("{$this->escaped_tags['open']}$token[1]{$this->escaped_tags['close']}",$this->pre($token[1]).$this->content[$token[1]][$j].$this->post($token[1]),$buffer);
                  
                  
              
              }
              
              /* nuovo */
              $result_2 = ereg("{$this->escaped_tags['open']}([a-zA-Z0-9_]+)::([a-zA-Z0-9_]+)[[:space:] ]*([[:alnum:] \\\.=\%\'\"]*){$this->escaped_tags['close']}",$buffer,$token);
              if ($result_2) { 
                  
          
                  
                  $buffer = ereg_replace("{$this->escaped_tags['open']}$token[1]::$token[2][[:space:] ]*$token[3]{$this->escaped_tags['close']}",
				     $this->pre($token[1]).
				     $this->render($token[1],
						   $this->content[$token[1]][$j],
						   $token[2],
						   $token[3]).
				     $this->post($token[1]),
				     $buffer);
              }
              /* nuovo */
              
          } while ($result or $result_2);
          $this->content["foreach$i"][0] .= $buffer;
      }
    }         
    
    do {
        $result = ereg("{$this->escaped_tags['open']}([a-zA-Z0-9_]+){$this->escaped_tags['close']}",$this->buffer,$token);
        if ($result) {
        		
        		if (isset($this->content[$token[1]][0])){
            	$this->buffer = ereg_replace("{$this->escaped_tags['open']}{$token[1]}{$this->escaped_tags['close']}",$this->pre($token[1]).$this->content[$token[1]][0].$this->post($token[1]),$this->buffer);
        		} else {
        			$this->buffer = ereg_replace("{$this->escaped_tags['open']}{$token[1]}{$this->escaped_tags['close']}",$this->pre($token[1]).$this->post($token[1]),$this->buffer);
        		}
        		
        }
    } while ($result);

   

    do {
      $result = ereg("{$this->escaped_tags['open']}([a-zA-Z0-9_]+)::([a-zA-Z0-9_]+)[[:space:] ]*([[:alnum:] \\\.=\%\'\"]*){$this->escaped_tags['close']}",$this->buffer,$token);
      if ($result) {
          $this->buffer = ereg_replace("{$this->escaped_tags['open']}$token[1]::$token[2][[:space:] ]*$token[3]{$this->escaped_tags['close']}",
				     $this->pre($token[1]).
				     $this->render($token[1],
						   $this->content["$token[1]"][0],
						   $token[2],
						   $token[3]).
				     $this->post($token[1]),
				     $this->buffer);

      }
    } while ($result);

  }
  
  function close2() {

    if (!$this->parsed) {
      $this->parse();
    }

    echo $this->buffer;
#    gzdocout();
  }
  
  
  function getExtension() {
  	
  	$extension = "\n<!-- being generated inclusions -->\n";
  	$files = array();
  	
  		
  	foreach(get_declared_classes() as $k => $v) {

  		if (strtolower(get_parent_class($v)) == "taglibrary") {
  			$methods = get_class_methods($v); //print_r($methods);
  			if (in_array("includejs",$methods)) {
  				   
  				eval("\$files[] = ".$v."::includeJS();");
  				 
  			}
  		}
  	}
  		
  	
  	for($i=0;$i<count($files);$i++) {
  		$extension .= "<script type=\"text/javascript\" src=\"{$files[$i]}\"></script>\n";
  	}
  	
  	$files = array();
  		
  	foreach(get_declared_classes() as $k => $v) {

  		if (strtolower(get_parent_class($v)) == "taglibrary") {
  			$methods = get_class_methods($v); //print_r($methods);
  			if (in_array("includestyle",$methods)) {
  				   
  				eval("\$files[] = ".$v."::includeStyle();");
  				 
  			}
  		}
  	}
  		
  		
  	for($i=0;$i<count($files);$i++) {
  		$extension .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{files[$i]}\" />\n";
  	}
  		
  	$local_buffer = "";
  		
  	foreach(get_declared_classes() as $k => $v) {

  		if (strtolower(get_parent_class($v)) == "taglibrary") {
  			$methods = get_class_methods($v); //print_r($methods);
  			if (in_array("injectjs",$methods)) {
  				   
  				eval("\$local_buffer .= ".$v."::injectJS();");
  				if ($local_buffer != "") {
  					$local_buffer .= "\n\n";
  				}
  			}
  		}
  	}
  		
  		
  	if ($local_buffer != "") {
  		$extension .= "<script>\n{$local_buffer}";
  		$extension .= "</script>\n";
  	}
  		
  	$local_buffer = "";
  		
  	foreach(get_declared_classes() as $k => $v) {

  		if (strtolower(get_parent_class($v)) == "taglibrary") {
  			$methods = get_class_methods($v); //print_r($methods);
  			if (in_array("injectstyle",$methods)) {
  				   
  				eval("\$local_buffer .= ".$v."::injectStyle();");
  				if ($local_buffer != "") {
  					$local_buffer .= "\n\n";
  				}
  			}
  		}
  	}
  		
  		
  	if ($local_buffer != "") {
  		$extension .= "<style type=\"text/css\">\n{$local_buffer}";
  		$extension .= "</style> <!-- end generated inclusions -->\n";
  	}
  		
  	return $extension;
  	
  }
  
  function close() {

  	$this->parse();
  	
	$pos = strpos($this->buffer, "</head>");

	$pre = substr($this->buffer, 0, $pos);
	$post = substr($this->buffer,$pos+7);
	
	$result = $pre.$this->getExtension()."</head>\n".$post;
	
    echo $result;

    #    gzdocout();
  }
  
  function get() {
  	
    if (!$this->parsed) {
      $this->parse();
    }

    return $this->buffer;
  }

  function render($name,$data,$widget,$parameters,$value = "",$event = "") {

    $parameters = $parameters." ".$this->pars[$name][0];

    switch($widget) {
    case "select2":
    case "Select2":

    /* 

       $data is formatted like this 

       $data[0][value] 
       $data[0][text]

    */

      $content = Render::Select($name,$data,$parameters,$value,$event);
      break;
    case "checkbox":
    case "CheckBox":
    case "checkBox":
      $content = Render::CheckBoxList($name,$data,$value,$event);
      break;      
    case "radiobox":
    case "RadioBox":
    case "radioBox":
      $content = Render::RadioBox($name,$data,$value,$event);
      break;      

    case "show_data":
    case "showdata":
    case "showData":
    case "Showdata":
    case "ShowData":
    case "inspect":
    case "Inspect":

      $content = Render::ShowData($name,$data,$parameters,$value,$event);
      break;

    default:
      
      $pars = TagAux::parsePars($parameters);

      if (isset($pars['library'])) {
			$library = $pars['library'];
			require_once "include/tags/$library.inc.php";

      } else {
			$library = "TagLibrary";
      }

      if (isset($this->parameters[$widget][0])) {
      	echo $this->parameters[$widget][0];
      }

      eval("\$content = ".$library."::".$widget."(\$name,\$data,TagAux::parsePars(\$parameters));");

      break;

    }
    return $content;
  }
}

Class TagAux {

 function parsePars($parameters) {
    
    $buffer = $parameters;
    do {
      $result = ereg("^([[:alnum:] \_]+)",$buffer,$token);
      if ($result) {
	$buffer = ereg_replace("^$token[1]","",$buffer);
	$result2 = ereg("^=\"([[:alnum:]\.\_\% \-]*)\"",$buffer,$token2);
	if ($result2) {
	  $buffer = ereg_replace("^=\"$token2[1]\"[[:space:] ]*","",$buffer);
	  $par[$token[1]] = $token2[1];
       }
      }
      
    } while ($result);

    return $par;
  }


}

Class TagLibrary {
	
	

}


Class Skin extends Template {
	
	function Skin($skin) {
		
		Template::Template("skins/{$GLOBALS['config']['skin']}/dtml/frame-public.html");
		
		$this->setContent("skin", $GLOBALS['config']['skin']);
		$this->setContent("base", $GLOBALS['config']['base']);

		
	}
	
}

?>
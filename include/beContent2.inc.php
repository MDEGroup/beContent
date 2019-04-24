<?php

require_once "include/mail.inc.php";

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




TODO:
*****

0. instead of checking each time whether all the entities have been
created, this functionality can be included in a configuration wizard
to be executed each time the designer wishes

1. it can be important to have besides a SelectFromReference a link to the
script to enter a new item into the referenced entity - this may require
a refactoring with a unique script/controller for all the forms




Features:
*******
* 25-01-2009
- Skin caching management implemented, different policies have been included with a site-wide
  configuration

* 24-01-2009
- UPDATE FILE fix

* 07-01-2009
- TINY MCE upgrade (Version: 3.2.1.1)
- Spellchecker plugin added

	requirements : see http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/spellchecker

* 05-01-2009
- Backoffice graphics has been re-designed.
- Pager bugs fixes
- Form javascript include bug solved


* 03-01-2009
- The frame-private template for the private Skin has been simplified, no more javascript code or ad-hoc inclusions are required.

* 02-01-2009
- A problem has been fixed, some primary_key values cause the name of the Check Boxes in the RELATION MANAGER to be invalid (such as "john.delano") because of illegale 
  characters. The fix consists in using an encoding by means of aux::encode_name function which returns the MD5 of the value, its inversion is not required thus the 
  function aux::decode_name is unneeded
  
  
  [...] pleanty of release notes are missing here.
  

* 23-10-2007
- $refferred removed among the instance variabile of the class Entity


* 04-07-2007
- hierarchicalPosition has been added, it is a Position widget which filters elements according 
to a 1-n relation
- hierarchicalPosition has been enhanced to work also with self references, ie. 1-n auto 
relations, which makes it very useful to be used to build hierarchical menu.

* 01-06-2007
- some Notice and Warning have been fixed, for instance 

	Notice: Use of undefined constant table - assumed 'table' in C:\Users\Alfonso\Documents\Documenti\Sviluppo\conferences\ASE2008\include\beContent.inc.php on line 998
	Notice: Use of undefined constant field - assumed 'field' in C:\Users\Alfonso\Documents\Documenti\Sviluppo\conferences\ASE2008\include\beContent.inc.php on line 999

* 03-03-2007
- a number of small fixes
- the NO_DELETE did not work on page 2 for the update, it has been fixed.

* 10-02-2007
- a generic download utility for all entities containing a FILE field, it is used also in the
editItem.

* 03-02-2007
- the referential integrity now takes into account also the entities with the WITH_OWNER
property
- the position widget has been fixed (in case of empty entity was having an item with a blank
string)

* 13-12-2006
- the entities Entity has now two foreign keys to manage Moderator and ExpressPublish Groups
- it is possible to specify multiple foreign keys referring to the same table to
- the referential integrity is also validate for multiple foreign keys

* 11-12-2006
- the built-in reporting has been updated to list only the item which belongs to the user in the
session, for those entities which are not WITH_OWNER just lists all the items
- the reload check has been fixed

* 10-12-2006
- the dataFilering is working with the bootstrapped version of the user/group/service management
- the authentication is completely working now with
. authentication
. service-based authorization
. item-based data filtering

* 03-08-2006

- the relation class constructor has now an additional parameters for explicitly giving name to
the corresponding tables

* 02-08-2006

- htmlentities/addslashes/stripslashes on dataentry, this has problems because when editing with the Editor
the htmlentities function should not be applied,

* 27.07.2006

- WITH_OWNER timestamp is now in the YYYYMMDDHHmm format, a new LONGDATE type has been
added but only internally used in combination with WITH_OWNER

- aspect oriented code weaving, each stage (addItem: emitForm, Insertion - editItem:
Selection, formFeed, Update, Deletion) have now
- manage the "none" message in the file upload by means of the messaging systems

* 24.07.2006

- delete transactions include now also the deletion
over the n-m relations

* 23.07.2006

- Multiple N-M relation transactions

* Previously

- Entities definition
- N-M, 1-N relation definition
- Insert Transaction
- Edit Transation
- Deletion Transaction with Integrity Check


*/
#VARIOUS

define('HTML', "HTML");
define('IMG', "IMG");
define('HTML_IMG', "HTML_IMG");

define('AJAX', 'ajax');

#XMLCHARS

define('MODE1','MODE1');
define('MODE2','MODE2');
define('MODE3','MODE3');


#Rss Mod


define('MOD1','MOD1');
define('MOD2','MOD2');
define('MOD3','MOD3');

# OPERATING SYSTEMS

define('WINDOWS', "WINDOWS");
define('LINUX', "LINUX");
define('MACOS', "MACOS");

#require_once "Mail.php";


define('ADD',"add");
define('EDIT',"edit");
define('DELETE', "delete");

define('NO_DELETE', true);
define('ALL',"ALL");
define('NO_ARG',"NO_ARG");


/* Relation orientation */

define('LEFT', "LEFT");
define('RIGHT', "RIGHT");

#define(MSG_SURE, "sure");
define('MSG_UPDATED',"updated");

define('AUTO', "AUTO");

define('ITALIANO',"it");
define('ENGLISH',"en");

define('PRESENT', "PRESENT");
define('ABSENT', "ABSENT");


define('PRELOAD',"preload");
define('MANDATORY',"yes");
define('OPTIONAL', 'OPTIONAL');
define('EQUAL',"equal");
define('IMPLIES', "implies");

define('LIMIT', "limit");
define('NORMAL', 'NORMAL');
define('COUNT', 'COUNT');
define('ADVANCED', 'ADVANCED');
define('PARSE', 'PARSE');


/* DATE FORMATS */

define('RSS', 'RSS');
define('BLOG', 'BLOG');
define('LETTERS', "LETTERS");
define('SHORT_LETTERS', "SHORT_LETTERS");
define('STANDARD', "STANDARD");
define('STANDARD_PLUS', "STANDARD_PLUS");
define('EXTENDED', "EXTENDED");
define('EXTENDED_PLUS', "EXTENDED_PLUS");
define('TIME', 'TIME');
define('YEAR', 'YEAR');

/* BASIC DATATYPES */

define('VARCHAR',"VARCHAR");
define('HIDDEN', 'HIDDEN');
define('TEXT',"TEXT");
define('FILE',"FILE");
define('FILE2FOLDER', "FILE2FOLDER");
define('IMAGE', "IMAGE");
define('INT',"INT");
define('STANDARD_PRIMARY_KEY_TYPE', "INT UNSIGNED AUTO_INCREMENT");
define('DATE',"DATE");
define('LONGDATE', "LONGDATE");
define('POSITION',"POSITION");
define('PASSWORD',"PASSWORD");
define('COLOR', "COLOR");
define('CHECKBOX', "CHECKBOX");
define('RELATION_MANAGER', "RELATION MANAGER");

/* WIDGET TYPES */

define('SELECT_FROM_REFERENCE', "selectFromReference");
define('RADIO_FROM_REFERENCE', "radioFromReference");

/* to be completed */


define('WITH_OWNER',"WITH_OWNER");
define('BY_POSITION',"BY_POSITION");
define('MD5', "MD5");

define('POST',"POST");
define('GET',"GET");

/* NOTIFY MESSAGES */

define('NOTIFY_ITEM_ADDED',"801");
define('NOTIFY_ITEM_UPDATED',"802");
define('NOTIFY_ITEM_DELETED',"803");
define('NOTIFY_ITEM_INTEGRITY_VIOLATION',"804");

/* FILE UPLOAD MESSAGES */

define('MSG_REPORT_EMPTY', "501");

define('MSG_FILE_NONE', "601");
define('MSG_FILE_DELETE', "602");

/* ERROR MESSAGES */

define('MSG_ERROR_DATABASE_GENERIC',"900");
define('MSG_ERROR_DATABASE_OPEN',"901");
define('MSG_ERROR_DATABASE_CONNECTION',"902");
define('MSG_ERROR_DATABASE_TABLE',"903");
define('MSG_ERROR_DATABASE_QUERY',"904");
define('MSG_ERROR_DATABASE_DUPLICATE_KEY',"905");
define('MSG_ERROR_DATABASE_RELOAD',"906");


define('MSG_ERROR_DATABASE_PRESENTATION',"907");
define('MSG_ERROR_UNKNOWN_ENTITY',"908");

define('MSG_ERROR_TRIGGERS',"909");
define('MSG_ERROR_RELATION_MANAGER',"910");
define('MSG_ERROR_DATABASE_RELATION_INSERT',"911");
define('MSG_ERROR_SESSION',"912");
define('MSG_ERROR_DATABASE_DELETION',"913");
define('MSG_ERROR_DATABASE_BOOTSTRAP',"914");
define('MSG_ERROR_DATABASE_INIT', "915");


/* JAVASCRIPT MESSAGES */

define('WARNING', "000");

define('MSG_JS_INSERT',"701");
define('MSG_JS_SURE',"702");
define('MSG_JS_SELECT',"703");
define('MSG_JS_MODERATION',"704");
define('MSG_JS_RADIO', "705");
define('MSG_JS_RELATIONMANAGER', "706");
define('MSG_JS_IMPLIES', "707");
define('MSG_JS_EXTENSION', "708");
define('MSG_JS_INSERT_TIME', "709");

/* BUTTON LABELS */

define('BUTTON_ACCEPT',"1001");
define('BUTTON_REFUSE',"1002");
define('BUTTON_ADD', "1003");
define('BUTTON_EDIT', "1004");
define('BUTTON_DELETE', "1005");

define('FIELDSET', "1006");

define('MODERATION_ACCEPT',"1011");
define('MODERATION_REFUSE',"1012");
define('MODERATION_EXPIRED',"1013");

/* RSS MODALITY */
define('MODALITY1',"1101");
define('MODALITY2',"1102");
define('MODALITY3',"1103");
define('RSS_MODALITY1_MSG', "1104"); 
define('RSS_MODALITY2_MSG', "1105");

/* SYSTEM USER GROUPS */
define('ADMIN', 1);

/* VARIOUS */

define('OMIT_LOGGED_USER', "OMIT_LOGGED_USER");

$RESERVEDWORDS = Array('page');


class smtp_class
{
	var $user="";
	var $realm="";
	var $password="";
	var $workstation="";
	var $authentication_mechanism="";
	var $host_name="";
	var $host_port=25;
	var $ssl=0;
	var $localhost="";
	var $timeout=0;
	var $data_timeout=0;
	var $direct_delivery=0;
	var $error="";
	var $debug=0;
	var $html_debug=0;
	var $esmtp=1;
	var $esmtp_host="";
	var $esmtp_extensions=array();
	var $maximum_piped_recipients=100;
	var $exclude_address="";
	var $getmxrr="GetMXRR";
	var $pop3_auth_host="";
	var $pop3_auth_port=110;

	/* private variables - DO NOT ACCESS */

	var $state="Disconnected";
	var $connection=0;
	var $pending_recipients=0;
	var $next_token="";
	var $direct_sender="";
	var $connected_domain="";
	var $result_code;
	var $disconnected_error=0;

	/* Private methods - DO NOT CALL */

	Function Tokenize($string,$separator="")
	{
		if(!strcmp($separator,""))
		{
			$separator=$string;
			$string=$this->next_token;
		}
		for($character=0;$character<strlen($separator);$character++)
		{
			if(GetType($position=strpos($string,$separator[$character]))=="integer")
				$found=(IsSet($found) ? min($found,$position) : $position);
		}
		if(IsSet($found))
		{
			$this->next_token=substr($string,$found+1);
			return(substr($string,0,$found));
		}
		else
		{
			$this->next_token="";
			return($string);
		}
	}

	Function OutputDebug($message)
	{
		$message.="\n";
		if($this->html_debug)
			$message=str_replace("\n","<br />\n",HtmlEntities($message));
		echo $message;
		flush();
	}

	Function SetDataAccessError($error)
	{
		$this->error=$error;
		if(function_exists("socket_get_status"))
		{
			$status=socket_get_status($this->connection);
			if($status["timed_out"])
				$this->error.=": data access time out";
			elseif($status["eof"])
			{
				$this->error.=": the server disconnected";
				$this->disconnected_error=1;
			}
		}
	}

	Function GetLine()
	{
		for($line="";;)
		{
			if(feof($this->connection))
			{
				$this->error="reached the end of data while reading from the SMTP server conection";
				return("");
			}
			if(GetType($data=@fgets($this->connection,100))!="string"
			|| strlen($data)==0)
			{
				$this->SetDataAccessError("it was not possible to read line from the SMTP server");
				return("");
			}
			$line.=$data;
			$length=strlen($line);
			if($length>=2
			&& substr($line,$length-2,2)=="\r\n")
			{
				$line=substr($line,0,$length-2);
				if($this->debug)
					$this->OutputDebug("S $line");
				return($line);
			}
		}
	}

	Function PutLine($line)
	{
		if($this->debug)
			$this->OutputDebug("C $line");
		if(!@fputs($this->connection,"$line\r\n"))
		{
			$this->SetDataAccessError("it was not possible to send a line to the SMTP server");
			return(0);
		}
		return(1);
	}

	Function PutData(&$data)
	{
		if(strlen($data))
		{
			if($this->debug)
				$this->OutputDebug("C $data");
			if(!@fputs($this->connection,$data))
			{
				$this->SetDataAccessError("it was not possible to send data to the SMTP server");
				return(0);
			}
		}
		return(1);
	}

	Function VerifyResultLines($code,&$responses)
	{
		$responses=array();
		Unset($this->result_code);
		while(strlen($line=$this->GetLine($this->connection)))
		{
			if(IsSet($this->result_code))
			{
				if(strcmp($this->Tokenize($line," -"),$this->result_code))
				{
					$this->error=$line;
					return(0);
				}
			}
			else
			{
				$this->result_code=$this->Tokenize($line," -");
				if(GetType($code)=="array")
				{
					for($codes=0;$codes<count($code) && strcmp($this->result_code,$code[$codes]);$codes++);
					if($codes>=count($code))
					{
						$this->error=$line;
						return(0);
					}
				}
				else
				{
					if(strcmp($this->result_code,$code))
					{
						$this->error=$line;
						return(0);
					}
				}
			}
			$responses[]=$this->Tokenize("");
			if(!strcmp($this->result_code,$this->Tokenize($line," ")))
				return(1);
		}
		return(-1);
	}

	Function FlushRecipients()
	{
		if($this->pending_sender)
		{
			if($this->VerifyResultLines("250",$responses)<=0)
				return(0);
			$this->pending_sender=0;
		}
		for(;$this->pending_recipients;$this->pending_recipients--)
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		return(1);
	}

	Function ConnectToHost($domain, $port, $resolve_message)
	{
		if($this->ssl)
		{
			$version=explode(".",function_exists("phpversion") ? phpversion() : "3.0.7");
			$php_version=intval($version[0])*1000000+intval($version[1])*1000+intval($version[2]);
			if($php_version<4003000)
				return("establishing SSL connections requires at least PHP version 4.3.0");
			if(!function_exists("extension_loaded")
			|| !extension_loaded("openssl"))
				return("establishing SSL connections requires the OpenSSL extension enabled");
		}
		if(ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$domain))
			$ip=$domain;
		else
		{
			if($this->debug)
				$this->OutputDebug($resolve_message);
			if(!strcmp($ip=@gethostbyname($domain),$domain))
				return("could not resolve host \"".$domain."\"");
		}
		if(strlen($this->exclude_address)
		&& !strcmp(@gethostbyname($this->exclude_address),$ip))
			return("domain \"".$domain."\" resolved to an address excluded to be valid");
		if($this->debug)
			$this->OutputDebug("Connecting to host address \"".$ip."\" port ".$port."...");
		if(($this->connection=($this->timeout ? @fsockopen(($this->ssl ? "ssl://" : "").$ip,$port,$errno,$error,$this->timeout) : @fsockopen(($this->ssl ? "ssl://" : "").$ip,$port))))
			return("");
		$error=($this->timeout ? strval($error) : "??");
		switch($error)
		{
			case "-3":
				return("-3 socket could not be created");
			case "-4":
				return("-4 dns lookup on hostname \"".$domain."\" failed");
			case "-5":
				return("-5 connection refused or timed out");
			case "-6":
				return("-6 fdopen() call failed");
			case "-7":
				return("-7 setvbuf() call failed");
		}
		return("could not connect to the host \"".$domain."\": ".$error);
	}

	Function SASLAuthenticate($mechanisms, $credentials, &$authenticated, &$mechanism)
	{
		$authenticated=0;
		if(!function_exists("class_exists")
		|| !class_exists("sasl_client_class"))
		{
			$this->error="it is not possible to authenticate using the specified mechanism because the SASL library class is not loaded";
			return(0);
		}
		$sasl=new sasl_client_class;
		$sasl->SetCredential("user",$credentials["user"]);
		$sasl->SetCredential("password",$credentials["password"]);
		if(IsSet($credentials["realm"]))
			$sasl->SetCredential("realm",$credentials["realm"]);
		if(IsSet($credentials["workstation"]))
			$sasl->SetCredential("workstation",$credentials["workstation"]);
		if(IsSet($credentials["mode"]))
			$sasl->SetCredential("mode",$credentials["mode"]);
		do
		{
			$status=$sasl->Start($mechanisms,$message,$interactions);
		}
		while($status==SASL_INTERACT);
		switch($status)
		{
			case SASL_CONTINUE:
				break;
			case SASL_NOMECH:
				if(strlen($this->authentication_mechanism))
				{
					$this->error="authenticated mechanism ".$this->authentication_mechanism." may not be used: ".$sasl->error;
					return(0);
				}
				break;
			default:
				$this->error="Could not start the SASL authentication client: ".$sasl->error;
				return(0);
		}
		if(strlen($mechanism=$sasl->mechanism))
		{
			if($this->PutLine("AUTH ".$sasl->mechanism.(IsSet($message) ? " ".base64_encode($message) : ""))==0)
			{
				$this->error="Could not send the AUTH command";
				return(0);
			}
			if(!$this->VerifyResultLines(array("235","334"),$responses))
				return(0);
			switch($this->result_code)
			{
				case "235":
					$response="";
					$authenticated=1;
					break;
				case "334":
					$response=base64_decode($responses[0]);
					break;
				default:
					$this->error="Authentication error: ".$responses[0];
					return(0);
			}
			for(;!$authenticated;)
			{
				do
				{
					$status=$sasl->Step($response,$message,$interactions);
				}
				while($status==SASL_INTERACT);
				switch($status)
				{
					case SASL_CONTINUE:
						if($this->PutLine(base64_encode($message))==0)
						{
							$this->error="Could not send the authentication step message";
							return(0);
						}
						if(!$this->VerifyResultLines(array("235","334"),$responses))
							return(0);
						switch($this->result_code)
						{
							case "235":
								$response="";
								$authenticated=1;
								break;
							case "334":
								$response=base64_decode($responses[0]);
								break;
							default:
								$this->error="Authentication error: ".$responses[0];
								return(0);
						}
						break;
					default:
						$this->error="Could not process the SASL authentication step: ".$sasl->error;
						return(0);
				}
			}
		}
		return(1);
	}

	/* Public methods */

	Function Connect($domain="")
	{
		if(strcmp($this->state,"Disconnected"))
		{
			$this->error="connection is already established";
			return(0);
		}
		$this->disconnected_error=0;
		$this->error=$error="";
		$this->esmtp_host="";
		$this->esmtp_extensions=array();
		$hosts=array();
		if($this->direct_delivery)
		{
			if(strlen($domain)==0)
				return(1);
			$hosts=$weights=$mxhosts=array();
			$getmxrr=$this->getmxrr;
			if(function_exists($getmxrr)
			&& $getmxrr($domain,$hosts,$weights))
			{
				for($host=0;$host<count($hosts);$host++)
					$mxhosts[$weights[$host]]=$hosts[$host];
				KSort($mxhosts);
				for(Reset($mxhosts),$host=0;$host<count($mxhosts);Next($mxhosts),$host++)
					$hosts[$host]=$mxhosts[Key($mxhosts)];
			}
			else
			{
				if(strcmp(@gethostbyname($domain),$domain)!=0)
					$hosts[]=$domain;
			}
		}
		else
		{
			if(strlen($this->host_name))
				$hosts[]=$this->host_name;
			if(strlen($this->pop3_auth_host))
			{
				$user=$this->user;
				if(strlen($user)==0)
				{
					$this->error="it was not specified the POP3 authentication user";
					return(0);
				}
				$password=$this->password;
				if(strlen($password)==0)
				{
					$this->error="it was not specified the POP3 authentication password";
					return(0);
				}
				$domain=$this->pop3_auth_host;
				$this->error=$this->ConnectToHost($domain, $this->pop3_auth_port, "Resolving POP3 authentication host \"".$domain."\"...");
				if(strlen($this->error))
					return(0);
				if(strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication server greeting was not found";
					return(0);
				}
				if(!$this->PutLine("USER ".$this->user)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication user was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				if(!$this->PutLine("PASS ".$password)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication password was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				fclose($this->connection);
				$this->connection=0;
			}
		}
		if(count($hosts)==0)
		{
			$this->error="could not determine the SMTP to connect";
			return(0);
		}
		for($host=0, $error="not connected";strlen($error) && $host<count($hosts);$host++)
		{
			$domain=$hosts[$host];
			$error=$this->ConnectToHost($domain, $this->host_port, "Resolving SMTP server domain \"$domain\"...");
		}
		if(strlen($error))
		{
			$this->error=$error;
			return(0);
		}
		$timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
		if($timeout
		&& function_exists("socket_set_timeout"))
			socket_set_timeout($this->connection,$timeout,0);
		if($this->debug)
			$this->OutputDebug("Connected to SMTP server \"".$domain."\".");
		if(!strcmp($localhost=$this->localhost,"")
		&& !strcmp($localhost=getenv("SERVER_NAME"),"")
		&& !strcmp($localhost=getenv("HOST"),""))
			$localhost="localhost";
		$success=0;
		if($this->VerifyResultLines("220",$responses)>0)
		{
			$fallback=1;
			if($this->esmtp
			|| strlen($this->user))
			{
				if($this->PutLine("EHLO $localhost"))
				{
					if(($success_code=$this->VerifyResultLines("250",$responses))>0)
					{
						$this->esmtp_host=$this->Tokenize($responses[0]," ");
						for($response=1;$response<count($responses);$response++)
						{
							$extension=strtoupper($this->Tokenize($responses[$response]," "));
							$this->esmtp_extensions[$extension]=$this->Tokenize("");
						}
						$success=1;
						$fallback=0;
					}
					else
					{
						if($success_code==0)
						{
							$code=$this->Tokenize($this->error," -");
							switch($code)
							{
								case "421":
									$fallback=0;
									break;
							}
						}
					}
				}
				else
					$fallback=0;
			}
			if($fallback)
			{
				if($this->PutLine("HELO $localhost")
				&& $this->VerifyResultLines("250",$responses)>0)
					$success=1;
			}
			if($success
			&& strlen($this->user)
			&& strlen($this->pop3_auth_host)==0)
			{
				if(!IsSet($this->esmtp_extensions["AUTH"]))
				{
					$this->error="server does not require authentication";
					$success=0;
				}
				else
				{
					if(strlen($this->authentication_mechanism))
						$mechanisms=array($this->authentication_mechanism);
					else
					{
						$mechanisms=array();
						for($authentication=$this->Tokenize($this->esmtp_extensions["AUTH"]," ");strlen($authentication);$authentication=$this->Tokenize(" "))
							$mechanisms[]=$authentication;
					}
					$credentials=array(
						"user"=>$this->user,
						"password"=>$this->password
					);
					if(strlen($this->realm))
						$credentials["realm"]=$this->realm;
					if(strlen($this->workstation))
						$credentials["workstation"]=$this->workstation;
					$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
					if(!$success
					&& !strcmp($mechanism,"PLAIN"))
					{
						/*
						 * Author:  Russell Robinson, 25 May 2003, http://www.tectite.com/
						 * Purpose: Try various AUTH PLAIN authentication methods.
						 */
						$mechanisms=array("PLAIN");
						$credentials=array(
							"user"=>$this->user,
							"password"=>$this->password
						);
						if(strlen($this->realm))
						{
							/*
							 * According to: http://www.sendmail.org/~ca/email/authrealms.html#authpwcheck_method
							 * some sendmails won't accept the realm, so try again without it
							 */
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * It was seen an EXIM configuration like this:
							 * user^password^unused
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_DOCUMENTATION_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * ... though: http://exim.work.de/exim-html-3.20/doc/html/spec_36.html
							 * specifies: ^user^password
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
					}
					if($success
					&& strlen($mechanism)==0)
					{
						$this->error="it is not supported any of the authentication mechanisms required by the server";
						$success=0;
					}
				}
			}
		}
		if($success)
		{
			$this->state="Connected";
			$this->connected_domain=$domain;
		}
		else
		{
			fclose($this->connection);
			$this->connection=0;
		}
		return($success);
	}

	Function MailFrom($sender)
	{
		if($this->direct_delivery)
		{
			switch($this->state)
			{
				case "Disconnected":
					$this->direct_sender=$sender;
					return(1);
				case "Connected":
					$sender=$this->direct_sender;
					break;
				default:
					$this->error="direct delivery connection is already established and sender is already set";
					return(0);
			}
		}
		else
		{
			if(strcmp($this->state,"Connected"))
			{
				$this->error="connection is not in the initial state";
				return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("MAIL FROM:<$sender>"))
			return(0);
		if(!IsSet($this->esmtp_extensions["PIPELINING"])
		&& $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="SenderSet";
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
			$this->pending_sender=1;
		$this->pending_recipients=0;
		return(1);
	}

	Function SetRecipient($recipient)
	{
		if($this->direct_delivery)
		{
			if(GetType($at=strrpos($recipient,"@"))!="integer")
				return("it was not specified a valid direct recipient");
			$domain=substr($recipient,$at+1);
			switch($this->state)
			{
				case "Disconnected":
					if(!$this->Connect($domain))
						return(0);
					if(!$this->MailFrom(""))
					{
						$error=$this->error;
						$this->Disconnect();
						$this->error=$error;
						return(0);
					}
					break;
				case "SenderSet":
				case "RecipientSet":
					if(strcmp($this->connected_domain,$domain))
					{
						$this->error="it is not possible to deliver directly to recipients of different domains";
						return(0);
					}
					break;
				default:
					$this->error="connection is already established and the recipient is already set";
					return(0);
			}
		}
		else
		{
			switch($this->state)
			{
				case "SenderSet":
				case "RecipientSet":
					break;
				default:
					$this->error="connection is not in the recipient setting state";
					return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("RCPT TO:<$recipient>"))
			return(0);
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
		{
			$this->pending_recipients++;
			if($this->pending_recipients>=$this->maximum_piped_recipients)
			{
				if(!$this->FlushRecipients())
					return(0);
			}
		}
		else
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		$this->state="RecipientSet";
		return(1);
	}

	Function StartData()
	{
		if(strcmp($this->state,"RecipientSet"))
		{
			$this->error="connection is not in the start sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("DATA"))
			return(0);
		if($this->pending_recipients)
		{
			if(!$this->FlushRecipients())
				return(0);
		}
		if($this->VerifyResultLines("354",$responses)<=0)
			return(0);
		$this->state="SendingData";
		return(1);
	}

	Function PrepareData(&$data,&$output,$preg=1)
	{
		if($preg
		&& function_exists("preg_replace"))
			$output=preg_replace(array("/\n\n|\r\r/","/(^|[^\r])\n/","/\r([^\n]|\$)/D","/(^|\n)\\./"),array("\r\n\r\n","\\1\r\n","\r\n\\1","\\1.."),$data);
		else
			$output=ereg_replace("(^|\n)\\.","\\1..",ereg_replace("\r([^\n]|\$)","\r\n\\1",ereg_replace("(^|[^\r])\n","\\1\r\n",ereg_replace("\n\n|\r\r","\r\n\r\n",$data))));
	}

	Function SendData($data)
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		return($this->PutData($data));
	}

	Function EndSendingData()
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("\r\n.")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}

	Function ResetConnection()
	{
		switch($this->state)
		{
			case "Connected":
				return(1);
			case "SendingData":
				$this->error="can not reset the connection while sending data";
				return(0);
			case "Disconnected":
				$this->error="can not reset the connection before it is established";
				return(0);
		}
		$this->error="";
		if(!$this->PutLine("RSET")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}

	Function Disconnect($quit=1)
	{
		if(!strcmp($this->state,"Disconnected"))
		{
			$this->error="it was not previously established a SMTP connection";
			return(0);
		}
		$this->error="";
		if(!strcmp($this->state,"Connected")
		&& $quit
		&& (!$this->PutLine("QUIT")
		|| ($this->VerifyResultLines("221",$responses)<=0
		&& !$this->disconnected_error)))
			return(0);
		if($this->disconnected_error)
			$this->disconnected_error=0;
		else
			fclose($this->connection);
		$this->connection=0;
		$this->state="Disconnected";
		if($this->debug)
			$this->OutputDebug("Disconnected.");
		return(1);
	}

	Function SendMessage($sender,$recipients,$headers,$body)
	{
		if(($success=$this->Connect()))
		{
			if(($success=$this->MailFrom($sender)))
			{
				for($recipient=0;$recipient<count($recipients);$recipient++)
				{
					if(!($success=$this->SetRecipient($recipients[$recipient])))
						break;
				}
				if($success
				&& ($success=$this->StartData()))
				{
					for($header_data="",$header=0;$header<count($headers);$header++)
						$header_data.=$headers[$header]."\r\n";
					if(($success=$this->SendData($header_data."\r\n")))
					{
						$this->PrepareData($body,$body_data);
						$success=$this->SendData($body_data);
					}
					if($success)
						$success=$this->EndSendingData();
				}
			}
			$error=$this->error;
			$disconnect_success=$this->Disconnect($success);
			if($success)
				$success=$disconnect_success;
			else
				$this->error=$error;
		}
		return($success);
	}

}


Class Widget {
	var
	$name,
	$label,
	$mandatory;

	
	
	function Widget($name, $label, $mandatory = "no") {
		$this->name = $name;
		$this->label = $label;
		$this->mandatory = $mandatory;
	}

	function display() {
		return "Widget {$this->name} - no display admitted!";
	}

}

Class Text extends Widget {
	var
	$size,
	$maxlength;

	function Text($name,
	$label,
	$size = "20",
	$mandatory = "off",
	$maxlength = "") {

		Widget::Widget($name,$label,$mandatory);
		$this->size = $size;
		$this->maxlength = $maxlength;

	}

	function display() {

	}

}

Class Message {
	var $messages = Array(
	"it" => Array(
	"000" => "Attenzione",
	"001" => "Sei Sicuro ?",
	"501" => "Non ci sono elementi",
	"601" => "vuoto",
	"602" => "rimuovi",
	"701" => "Attenzione: inserire {label} !",
	"702" => "Sei Sicura/o ?",
	"703" => "Attenzione: selezionare {label} !",
	"704" => "Indicare il motivo del rigetto della pubblicazione !",
	"705" => "Attenzione: selezionare {label} !",
	"706" => "Attenzione: selezionare almeno un {label} !",
	"707" => "Attenzione: inserire o selezionare {label} !",
	"708" => "Attenzione: tipo di file errato per {label} !",
	"709" => "Attenzione: indicate anche ora e minuti per {label} !",
	"801" => "L'inserimento è stato effettuato con successo !",
	"802" => "L'aggiornamento è stato effettuato con successo !",
	"803" => "La cancellazione è avvenuta con successo !",
	"804" => "L'elemento selezionato per la cancellazione non può essere rimosso perchè in uso.",
	"900" => "Database: Errore Generico ",
	"901" => "Database: Error in opening database ",
	"902" => "Database: Error in opening connection to database ",
	"903" => "Database: Error in creating table ",
	"904" => "Database: Error in querying ",
	"905" => "Attenzione: la chiave risulta già presente, modifica per procedere!",
	"906" => "Attenzione: l'inserimento è annullato perchè la transazione è già avvenuta!",
	"907" => "Attenzione: errore in interrogazione query, probabilmente non è stata definita una presentazione (setPresentation) per la tabella ",
	"908" => "Database: entità specificata nella relazione inesistente",
	"909" => "Attenzione: solo form relative a Relazioni possono essere messe in cascata ",
	"910" => "Attenzione: non è possibile adottare un RelationManager per questo tipo di form ",
	"911" => "Attenzione: si è verificato un errore di inserimento nella relazione ",
	"912" => "Attenzione: operazione non ammissibile, sessione non aperta ",
	"913" => "Attenzione: errore di cancellazione ",
	"914" => "Attezione: il sistema non può essere inizializzato ",
	"915" => "Attezione: errore di tipi nell'inizializzazione ",
	"1001" => "Pubblica",
	"1002" => "Rifiuta",
	"1003" => "Aggiungi",
	"1004" => "Modifica",
	"1005" => "Rimuovi",
	"1006" => "Tue/Tuoi",
	"1011" => "<b>Grazie!</b><br><br>L'informazione è stata <u>pubblicata</u> e l'autore verrà informato!",
	"1012" => "<b>Grazie!</b><br><br>L'informazione è stata <u>rifiutata</u> e l'autore verrà informato!",
	"1013" => "<b>Attenzione!</b><br><br>La moderazione è stata già processata da un altro Editor!",
	"1101" => "Sempre",
	"1102" => "Batch Selettivo",
	"1103" => "Selettivo",
	"1104" => "RSS enabled",
	"1105" => "RSS enabled"

	),
	"en" => Array(
	"000" => "Warning",
	"001" => "Are you sure ?",
	"501" => "There are no items!",
	"601" => "none",
	"602" => "delete",
	"701" => "Warning: please insert {label} !",
	"702" => "Are you sure ?",
	"703" => "Warning: please select {label} !",
	"704" => "Please specify to the author why this item is rejected !",
	"705" => "Warning: please select {label} !",
	"706" => "Warning: please select at least one {label} !",
	"707" => "Warning: please enter or select {label} !",
	"708" => "Warning: the select file type for {label} is not correct !",
	"709" => "Warning: please enter also the time for {label} !",
	"801" => "The item has been correctly added!",
	"802" => "The item has been correctly updated!",
	"803" => "The item has been removed!",
	"804" => "The deletion cannot take place, because the item you selected is still in use!",
	"900" => "Database: Generic Error ",
	"901" => "Database: Error in opening database ",
	"902" => "Database: Error in opening connection to database ",
	"903" => "Database: Error in creating table ",
	"904" => "Database: Error in querying ",
	"905" => "Warning: duplicate key, enter another value to proceed!",
	"906" => "Warning: transaction cannot take place since already executed!",
	"907" => "Warning: error in querying, likely a presentation has been not defined for table ",
	"908" => "Database: unknown entity in the specified relation",
	"909" => "Warning: only Relation-based form can be in cascade triggered ",
	"910" => "Warning: a RelationManager object cannot be used for this form ",
	"911" => "Warning: an error occourred while inserting tuples into the relation ",
	"912" => "Warning: the operation is not allowed as the session has been not created ",
	"913" => "Warning: error in deletion ",
	"914" => "Warning: the system cannot be bootstrapped ",
	"915" => "Warning: likely a datatype error occurred in the initialization, eg. INT requires 0 valued field if bank is intended ",
	"1001" => "Publish",
	"1002" => "Reject",
	"1002" => "Rifiuta",
	"1003" => "Add",
	"1004" => "Save",
	"1005" => "Delete",
	"1006" => "Your",
	"1011" => "<b>Thank you!</b><br><br>The content has been <u>published</u>, the author is going to be informed!",
	"1012" => "<b>Thank you!</b><br><br>The content has been <u>rejected</u> and the author is going to be informed!",
	"1013" => "<b>Warning!</b><br><br>The content has been already validated by another Editor!",
	"1101" => "Sempre",
	"1102" => "Batch Selettivo",
	"1103" => "Selettivo",
	"1104" => "RSS enabled",
	"1105" => "RSS enabled"
	)
	),
	$language = "it";

	function Message($language) {
		$this->language = $language;
	}

	function getMessage($code, $data = "") {
		
		$GLOBALS['count']++;
		if ($GLOBALS['count'] == 2) {
			#echo "code: $code<br>";
			#echo "data: $data<hr>";
			
		}
		
		if (is_array($data)) {
			$buffer = $this->messages[$this->language][$code];
			if ((count($data) > 0) && ($data != "")){
				foreach($data as $key => $value) {

					if (is_string($value)) { 
					
						$buffer = str_replace('\{'.$key.'\}', $value, $buffer);
					}
					#echo $buffer;
					#echo " ";			
					
					
				}
			}
			
			return $buffer;
		} else {
			return aux::xmlchars($this->messages[$this->language][$code]);
		}
	}
}

$count = 0;



Class aux {
	
	
	///////////////////////////////////////////////////////////////
//Per l'encode dei caratteri xml
//////////////////////////////////////////////////////////////

	function encrypt_decrypt($Str_Message) {
		
    	$Len_Str_Message=STRLEN($Str_Message);
    	$Str_Encrypted_Message="";
    	
    	for ($Position = 0;$Position<$Len_Str_Message;$Position++){
        
        	$Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2)
        
        	$Key_To_Use = (255+$Key_To_Use) % 255;
        	$Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1);
        	$Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted);
        	$Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation
        	$Encrypted_Byte = CHR($Xored_Byte);
        	$Str_Encrypted_Message .= $Encrypted_Byte;
       
       
    	}
    	return $Str_Encrypted_Message;
	}
	
	function encrypt($message) {
		return urlencode(aux::encrypt_decrypt($message));
	}
	
	function decrypt($message) {
		return aux::encrypt_decrypt(urldecode($message));
	}
	
	function escape_string($string) {
		
		return mysql_escape_string($string);
		
	}
	
	function email($email, $pars) {
		
		#$email =  ereg_replace("@", "<span class=\"email\">[at]</span>", $email);
		#$email =  ereg_replace("\.", "<span class=\"email\">[dot]</span>", $email);
		
		if (!isset($pars['mode'])) { 		
			$email =  ereg_replace("@", "<img style=\"margin-bottom: -2px;\"src=\"img/beContent/chiocciola.gif\" alt=\"@\">", $email);
		} else {
			$email =  ereg_replace("@", "<img style=\"margin-bottom: -2px;\"src=\"img/beContent/chiocciola-{$pars['mode']}.gif\" alt=\"@\">", $email);
		}
		
		return "{$email}";
	}
	
	function encode_name($name) {
		return md5($name);
	}
	
	function decode_name($name) {
		return $name;
	}
	
	function phone($phone) {
		
		$phone = ereg_replace("^0039[[:space:]]*0862[[:space:]]*", "+39 0862 ", $phone);

		return $phone;
	}
	
	function xmlchars($str, $mode = MODE1) {
		 
		switch($mode) {
			case MODE1:
				$str=str_replace('&','&amp;',$str);
  				$str=str_replace('<','&lt;',$str);
  				$str=str_replace('>','&gt;',$str);
  				$str=str_replace('"','&quot;',$str);
  				$str=str_replace("'",'&#39;',$str);
			break;
			case MODE2:
				$str = htmlentities($str);
			break;
			case MODE3:
				
        		$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        		$trans = array_flip($trans);
        		$str = strtr($str, $trans);
        
	        	$str = preg_replace('/&#(d+);/me',"chr(\1)", $str);
	        	$str = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\1)", $str);
	        	
				$trans = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
	    
	        	foreach ($trans as $key => $value) {
	            	$trans[$key] = '&#'.ord($key).';';
	        	}
	    
	        	$str = strtr($str, $trans);
    
				
			break;
			
			
		}
		
  		
  	
  		return $str;
	}

	
///////////////////////////////////////////////////////////////
//funsione per il riconoscimento dei parametri nei template
//////////////////////////////////////////////////////////////	
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
   
   function getResultArray($query,$field){
		$data=aux::getResult($query);
		$i=0;
		while ($data[$i]) {
			$result[]=$data[$i][$field];
			$i++;
		}
		return $result;
		
	}
	
	
	
	
	
	
	function first_comma($arg, $separator) {
		global
		$comma;

		//	if ((isset($comma[$arg])) && (!$comma[$arg])) {
		if (!isset($comma[$arg])) {
			$comma[$arg] = true;
			return "";
		} else {
			return $separator;
		}

	}

	
	function mail($to, $subject, $message, $from) {
		
		
		
		$signature = new Template("dtml/signature.mail");
		$message .= $signature->get();
		
		
		
		$mail = new zMailer();
		
		$mail->From		= $from;
		$mail->FromName = $from;
		$mail->AddAddress($to);
		
		$mail->Subject 	= $subject;
		$mail->Body		= eregi_replace("[\]",'',$message);
		
		$mail->Send(); 
	    
			
		
		
	}
	
	function getResult($query, $mode = "NORMAL") {
		
                $content = "";
                
		switch ($mode) {
			case ADVANCED:
			case PARSE:
				
				$finito = false;
				do {
					if (ereg("\[([[:alnum:]]*)\]", $query, $token)) {
						
						$query = ereg_replace("\[{$token[1]}\]", $_REQUEST[$token[1]], $query);
						
					} else {
						$finito = true;
					}
				} while (!$finito);
				
				break;
			
			default:
				break;
		}
		
		if ($mode == PARSE) {
			
			return $query;
			
		} else {
		
			$oid = mysql_query($query);
			if (!$oid) {
				echo mysql_error();
	
				echo "<hr>",$query; exit;
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC);
				exit;
			}
	
			do {
				$data = mysql_fetch_assoc($oid);
				if ($data) {
					foreach ($data as $k=>$v) {
						if (is_string($data[$k])) {
							$data[$k] = stripslashes($v);
						}
					} 
					
					$content[] = $data;
				}
			} while ($data);
	
			return $content;
		}
	}

	function yesterday() {
		
		$day = time() - (24 * 60 * 60);	
		$strtime = strtotime(date('m/d/Y', $day));
		return strftime("%Y%m%d", $strtime);
		
	}
	
	
	
	function formatDate($date, $format = "") {

		switch ($format) {
			case RSS:
				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$result = date("D, j M Y 06:00:00 +0100",mktime(0, 0, 0, $token[2], $token[3], $token[1]));
				
			break;
			
			case LETTERS:

			ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
			$result = date("F jS Y",mktime(0, 0, 0, $token[2], $token[3], $token[1]));


			break;
			
			case SHORT_LETTERS:

			ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
			$result = date("M j, Y",mktime(0, 0, 0, $token[2], $token[3], $token[1]));


			break;

			case STANDARD:
				
			if ($date != "") {

				if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$result = "{$token[3]}/{$token[2]}/{$token[1]}";
				} elseif (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$result = "{$token[3]}/{$token[2]}/{$token[1]}";
				}
			} else {
				$result = "";
			}

			break;
			case STANDARD_PLUS:
				
			if ($date != "") {

				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				
				if (date("Ymd") == "{$token[1]}{$token[2]}{$token[3]}") {
					$result = aux::lingual("Oggi", "Today", "Oy");
				} else {				
					$result = "{$token[3]}/{$token[2]}/{$token[1]}";
				}
				if ($token[4] != "") {
					$result .= " {$token[4]}:{$token[5]}";
				}
			} else {
				$result = "";
			}

			break;
			
			case BLOG:
				
			if ($date != "") {

				ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
				$date = date("jS M",mktime(0, 0, 0, $token[2], $token[3], $token[1]));
				
				$result = "<div title=\"Oggi\" style=\"float: left; line-height: 13px; font-size: 9px;padding-top: 4px; margin: 2px 20px 0px 10px; width: 29px; height: 32px; text-align:center; background: url(img/date.jpg) no-repeat;\">{$date}</div>";
			} else {
				$result = "";
			}

			break;
			
			case EXTENDED:
				
				
				
				setlocale(LC_ALL, aux::getLocale($_SESSION['language']));		
				if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$day = "{$token[2]}/{$token[3]}/{$token[1]} {$token[4]}:{$token[5]}";

					$strtime = strtotime($day);
			
					$result = strftime("%A %d %B, %H:%M", $strtime); 
				} else if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					$day = "{$token[2]}/{$token[3]}/{$token[1]} 00:01";

					$strtime = strtotime($day);
			
					$result = strftime("%A %d %B", $strtime); 
				}
	
				
			break;
			
			case EXTENDED_PLUS:
				
				
				setlocale(LC_ALL, aux::getLocale($_SESSION['language']));		
				
				if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {

					if ("{$token[2]}{$token[3]}{$token[1]}" == date("mdY")) {
						
						$result = "Oggi {$token[4]}:{$token[5]}";
						
					} else {
					
						$day = "{$token[2]}/{$token[3]}/{$token[1]} {$token[4]}:{$token[5]}";
						$strtime = strtotime($day);
						$result = strftime("%A %d %B, %H:%M", $strtime); 
					}
				} else if (ereg("^([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])$", $date, $token)) {
					
					if ("{$token[2]}{$token[3]}{$token[1]}" == date("mdY")) {
						$result = "Oggi";
						
					} else {
						$day = "{$token[2]}/{$token[3]}/{$token[1]} 00:01";
						$strtime = strtotime($day);
						$result = strftime("%A %d %B", $strtime); 
					}
					
				}
	
				
			break;
			
			
			case TIME:
				
				$h = substr($date,8,2);
				$m = substr($date,10,2); 
				
				return "{$h}:{$m}";
				
			break;
			
			case YEAR:
				$y = substr($date,0,4);
				
				return $y;
				
				break;
			
			default:

			ereg("([0-9][0-9][0-9][0-9])([0-9][0-9])([0-9][0-9])", $date, $token);
			$result = "{$token[3]}.{$token[2]}.{$token[1]}";
			break;

		}



		return $result;
	}

	function subtext($text, $length = 100) {

		if (strlen(strip_tags(html_entity_decode($text))) < $length) {
			
			$result =  strip_tags(html_entity_decode($text));
		
		} else {
		
			$newtext = wordwrap(strip_tags(html_entity_decode($text)), $length, "<interrupt>");
		
			$pos = strpos($newtext, "<interrupt>");
			$result = substr($newtext, 0, $pos);
		}
			
		return $result;
	}

	function quote_smart($value) {

		// Stripslashes
		if (get_magic_quotes_gpc()) {
			#echo "stripslashes";
			$value = stripslashes($value);
		}
		// Quote if not integer
		if (!is_numeric($value)) {
			#echo "real_escape";
			$value = "'" . mysql_real_escape_string($value) . "'";
			#$value = mysql_real_escape_string($value) ;
		}
		return $value;
	}
	
	
	function mkIndent($level) {
		
		#echo "** {$level}<br>";
		
		$result = "";
		
		for($i=0; $i<$level;$i++) {
			
			$result .= "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		
		
		return $result;
	}
	
	function FindChildren ($parent, $level) {
  		global 
    		$flag, $data,
    		$tree_text,
    		$tree_value,
    		$tree_level,
    		
    		$undef_flag;
  
    	#echo "parent: {$parent}, level: {$level}<br>";
    		
  
  		for ($i=0;$i<count($data);$i++) {
    		
    		if (($data[$i]['reference'] == $parent) and (!isset($flag[$i]))) {
      
      			$tree_value[] = $data[$i]['value'];
      			$tree_text[] = aux::mkIndent($level).$data[$i]['text'];
      			$tree_level[] = $level;
      			
      			$flag[$i]=true;
      			
      			aux::FindChildren($data[$i]['value'],$level+1);
      
    		}
  		}
	} 
	
	function array_merge($arrays) {
		
		$result = array();
		
		foreach($arrays as $array) {
			$result = array_merge(array_diff($result,$array), array_diff($array,$result), array_intersect($result,$array));
		}
		
		return $result;
	}
	
	function add_distinct($array, $element) {
		
		if (!is_array($array)) {
			$array = array();
		}
		if (!in_array($element, $array)) {
			$array[] = $element;
		}
		
		return $array;
	}
	
	
	function AjaxEncode($object) {
    	
    	$str = serialize($object);
    	
    	
        
    	#$str = str_replace(array('\\', "'"), array("\\\\", "\\'"), $str);
        $str = preg_replace('#([\x00-\x08])#e', '"\x" . sprintf("%02x", ord("\1"))', $str);
    	$str = preg_replace('#([\x0A-\x1F])#e', '"\x" . sprintf("%02x", ord("\1"))', $str);
		
    	#$str = ereg_replace("\\x0d","",$str); 
	#$str = ereg_replace("\\x02","",$str);
	#$str = ereg_replace("\\x01","",$str);
	#$str = ereg_replace("\\x12","",$str);
	#$str = ereg_replace("\\x0e","",$str);
	$str = ereg_replace("\\x0[0-9a-f]","", $str);
	$str = ereg_replace("\\x1[0-9a-f]","", $str);

	
    	#Header("Content-type: text/plain");
    	#echo stripslashes($str);exit;
    	
        return $str;
    }

    
    function lingual($item_it, $item_en, $item_es = "") {
    	
    	$item = "item_{$_SESSION['language']}";
    	return $$item;
    	
    }
    
    function getLocale($language) {
    	
    	$locale = array(WINDOWS => array("it" => "ita_ita", "en" => "eng_eng","es" => "esp_esp"),
    	            	LINUX => array("it" => "it_IT", "en" => "en_UK","es" => "es_ES")
    			  );
    	
    	return $locale[$GLOBALS['config']['os']][$language];
    	
    }
    
    function refineQuery($query, $condition) {
    	
    	$queryToken['body'] = $query;
    	
    	if (ereg("(.*)(".sql_regcase("order by").".*)$", $queryToken['body'], $token)) {
    		$queryToken['order_by'] = $token[2];
    		$queryToken['body'] = $token[1];
    	}  
    	
    	if (ereg("(.*)(".sql_regcase("where").".*)$", $queryToken['body'], $token)) {
    		$queryToken['where'] = $token[2];
    		$queryToken['body'] = $token[1];
    	}
    	
    	
    	
    	$query = $queryToken['body'];
    	
    	if ($queryToken['where'] == "") {
    		
    		if ($condition != "") {
    			$query .= " WHERE {$condition} ";
    		}
    		
    	} else {
    		$query .= $queryToken['where']." AND {$condition} ";
    	}
    	
    	$query .= $queryToken['order_by'];
    	
    	return $query;
    	
    }
    
	function evaluate($str, $array) {
		
		do {
			$result = ereg("^.*\[(.*)\]", $str, $token);
			if ($result) {
				$buffer = $str;
				$str = ereg_replace("\[{$token[1]}\]", $array[$token[1]], $buffer);
			}
		} while ($result);
	
		#echo "**", $str;exit;
		return $str;
		
	}

	function seo_url($str) {
		
		$str = str_replace("?", "", $str);
		$str = str_replace(":", "", $str);
		$str = str_replace("/", "", $str);
		$str = str_replace("\\", "", $str);
		$str = str_replace("!", "", $str);
		$str = str_replace(".", "", $str);
		
		return str_replace(" ", "-", $str);
		
	}

	function phpMinV($v) {

		$phpV = PHP_VERSION;

    		if ($phpV[0] >= $v[0]) {
        		if (empty($v[2]) || $v[2] == '*') {
            			return true;
        		} elseif ($phpV[2] >= $v[2]) {
            			if (empty($v[4]) || $v[4] == '*' || $phpV[4] >= $v[4]) {
                			return true;
            			}
        		}
    		}

    		return false;
	}

	
}

$aux = new Aux();

Class beContentPager {
	var 
		$itemTemplate,
		$template,
		$query,
		$filter,
		$order,
		$length;
		
	function beContentPager($length = 15) {
		$this->itemTemplate = $template = ""; 
		$this->query = "";
		$this->length = $length;
	}
	
	function setQuery($query) {
		$this->query = $query;
	}
	
	function setFilter($filter) {
		$this->filter = $filter;
	}
	
	function setOrder($order) {
		$this->order = $order;
	}
	
	function getQuery() {
		
		$query = $this->query;
		
		if ($this->filter != "") {
			$query .= " WHERE {$this->filter}";
		}
		if ($this->order != "") {
			$query .= " ORDER BY {$this->order}";
		}
		
		return $query;
	}
	
	function setTemplate($template) {
		$this->itemTemplate = $template;
	}
	
	
	function displayItem($item) {
		
		$this->template->setContent("script", basename($_SERVER['SCRIPT_FILENAME']));
		foreach($item as $k => $v) {
			$this->template->setContent($k,$this->display($k,$v));	
		}
		
		
	}
	
	function get($data) {
		
		
		
		if (is_array($data)) {

			if ($this->itemTemplate == "") {
				if (isset($data[0]['lastmodified'])) {
					$this->setTemplate("dtml/ajax-report-with-owner.html");
				} else {
					$this->setTemplate("dtml/ajax-report.html");	
				}	
			}
		
			$this->template = new Template($this->itemTemplate);
	

			foreach($data as $item) {
				$this->displayItem($item);
			}
		
			return $this->template->get();
			
		}
	}
	
	function display($k,$v) {
		switch($k) {
			case "lastmodified": 
				if ($v == "") {
					return "";
				} else {
					return aux::formatDate($v , SHORT_LETTERS);
				}
			break;
			case "owner":
				return "by {$v}";
			break;
			case "active":
				if ($v == "*") {
					return "checked";
				} else {
					return "";
				}
			break;
			
				
			default:
				return aux::xmlchars($v, MODE3);
			break;
		
		}
				
		return $v;
	}
}

Class beContent {
	var
	$files,
	$selfrefs,
	$entities, 
	$currentform,
	$comments;

	function beContent() {

	}
	
	function getSearchForm() {
		
		
		$entities = func_get_args();
		
		if (!isset($_REQUEST['page'])) {
			$_REQUEST['page'] = 0;
		}
		
		switch ($_REQUEST['page']) {
			case 0: /* FORM EMISSION - This should be done on a presentation layer! */
				
				$content = "<div id=\"search\"> <form name=\"search\">\n";
				$content .= "<input type=\"hidden\" name=\"page\" value=\"1\">\n";
				$content .= "<input type=\"hidden\" name=\"action\" value=\"search\">\n";
		
				$content .= "<table>\n";
				$content .= "<tr>\n";
				$content .= "<td>Free Text &nbsp;</td>\n";
				#$content .= "<td><input type=\"text\" name=\"text\" size=\"30\" onkeyup=\"searchRequest();\"></td>\n";
				$content .= "<td><input type=\"text\" name=\"text\" size=\"30\" ></td>\n";
				$content .= "</tr>\n";
						
				foreach($entities as $k => $entity) {
					if (is_array($entity->searchFields['CHECK'])) {
						
						foreach($entity->searchFields['CHECK'] as $index => $field) {
							
							$result[$entity->name][$field] = aux::getResult("SELECT DISTINCT {$field} FROM {$entity->name} WHERE {$field} <> '' ORDER BY {$field}");
							
							$label[$field] = $entity->searchFields['CHECKLABEL'][$index];
						}
					}
				}
				
				$finalArray = array();
				$field = "";
				if (is_array($result)) {
					foreach($result as $entity => $v1) {
						foreach($v1 as $field => $v2) {
							foreach($v2 as $v3) {
							
								foreach($v3 as $k => $v) {
		
									if ($k != $field) {
										$field = $k;
									} 
									$finalArray[$field] = aux::add_distinct($finalArray[$field],$v);
								}
							}	
						}
					}
				}
				
				$field = "";
				foreach($finalArray as $k => $item) {
					$content .= "<tr>\n";
					if ($k != $field) {
						$content .= "<td valign=\"top\">{$label[$k]}</td>\n";
						$field = $k;
					} else {
						$content .= "<td></td>\n";
					}
					$content .= "<td>\n";
					$sorted = $item;
					asort($sorted);
					
					$content .= "\n\n<!-- BEGIN -->\n<table width=\"100%\">\n";
					$checkcount = 0;
					foreach($sorted as $k => $v) {
						if (($checkcount % 2) == 0) {
							$content .= "<tr>\n";
							$content .= "<td width=\"50%\"><input type=\"checkbox\" name=\"{$field}_{$v}\" value=\"{$v}\"> {$v}</td>\n";
						} else {
							$content .= "<td width=\"50%\"><input type=\"checkbox\" name=\"{$field}_{$v}\" value=\"{$v}\"> {$v}</td>\n";
							$content .= "</tr>\n";
						}
						$checkcount++;
					}
					
					if (($checkcount % 2) == 0) {
						$content .= "<td></td>\n";
						$content .= "</tr>\n";
					}
					
					$content .= "</table>\n\n<!-- END -->\n\n";
					$content .= "</td>\n";
					$content .= "</tr>\n";
				}
				
				foreach($entities as $k => $entity) {
					
					if (is_array($entity->searchRelations)) {
						foreach($entity->searchRelations as $index => $relation) {
							
							
							$relations[$relation->name] = $relation;
							
							if ($relation->entity_1->name == $entity->name) {
								$data = $relation->entity_2->getReference();
								
							} else {
								$data = $relation->entity_1->getReference();
								
							}
							$name = $relation->name;
							
							$content .= "<tr><td valign=\"top\">{$entity->searchFields['RELATIONLABEL'][$index]}</td><td>\n";
							$content .= "<table width=\"100%\">\n"; 
							$checkcount = 0;
							foreach($data as  $v) {
								
								if (($checkcount % 2) == 0) {
									$content .= "<tr>\n";
									
									$content .= "<td width=\"50%\"><input type=\"checkbox\" name=\"{$name}_{$v['value']}\" value=\"{$v['value']}\"> {$v['text']}</td>\n";
									
								} else {
									$content .= "<td width=\"50%\"><input type=\"checkbox\" name=\"{$name}_{$v['value']}\" value=\"{$v['value']}\"> {$v['text']}</td>\n";
									$content .= "</tr>";
									
								}
								
								$checkcount++;
							}
							if (($checkcount % 2) == 0) {
								$content .= "<td></td>\n";
								$content .= "</tr>";
							}
							
							$content .= "</table>\n";
							$content .= "</td></tr>\n";
							
							
							
						}
					}
				}
				
				
				$content .= "<tr><td></td>\n";
				$content .= "<td><input type=\"submit\" value=\"Show Result\"></td>\n";
				$content .= "</tr>\n</table>\n</form></div>\n\n";
				
				return $content;
				
			break;
			case 1:
				
				// ******************
				
				foreach($entities as $entity) {
					
					
					
					unset($sub_cond);
					
					$fields = "{$entity->name}.{$entity->fields[0]['name']} AS {$entity->name}_{$entity->fields[0]['name']}";
					if (is_array($entity->searchFields['TEXT'])) {
						foreach($entity->searchFields['TEXT'] as $field) {
							$fields .= ", {$entity->name}.{$field} AS {$entity->name}_{$field}";
						}
					}
					if (is_array($entity->searchFields['CHECK'])) {
						foreach($entity->searchFields['CHECK'] as $field) {
							$fields .= ", {$entity->name}.{$field} AS {$entity->name}_{$field}";
						}
					}
					
					if (is_array($entity->searchFields['TEXT'])) {
						if ($entity->owner) {
							$fields .= ", username, creation";
						}
					}
					
					
					$query = "SELECT $fields FROM {$entity->name} ";
					
					$left = "";
					if (count($entity->searchRelations) > 0) {
						foreach($entity->searchRelations as $relation) {
							$left .= "LEFT JOIN {$relation->name} ON {$relation->name}.id_{$entity->name} = {$entity->name}.{$entity->fields[0]['name']} ";
						}
					}
					
					
					
					if ($_REQUEST['text'] != "") {
						$condition = "";
						if (count($entity->searchFields['TEXT']) > 0) {
							foreach($entity->searchFields['TEXT'] as $field) {
								$condition .= aux::first_comma("{$entity->name} cond_1", " OR ")."{$entity->name}.{$field} LIKE '%{$_REQUEST['text']}%'";
							}
							
						}
						if ($condition != "") { 
							$sub_cond[] = $condition;
						}
					}
					$condition = "";
					if (count($entity->searchFields['CHECK']) > 0) {
						foreach($entity->searchFields['CHECK'] as $field) {
								
							foreach($_REQUEST as $element => $value) {
								if (ereg($field, $element)) {
									$condition .= aux::first_comma("{$entity->name} cond_2", " OR ")."{$entity->name}.{$field} = '{$value}'";
								}
							}					
						}
							
					}
						
					if ($condition != "") {
						$sub_cond[] = $condition;
					}
						
					if (count($entity->searchRelations) > 0) {

						foreach($entity->searchRelations as $relation) {
							$condition = "";
							foreach($_REQUEST as $element => $value) {
								if (ereg($relation->name, $element)) {
									$condition .= aux::first_comma($relation->name, " OR ")."{$relation->name}.id_{$entity->name} = '{$value}'";
								}
							}
							if ($condition != "") {
								$sub_cond[] = $condition;
								$query .= $left;
							}
						}
					}
					if (count($sub_cond) > 0) {
						$query .= " WHERE ";
						foreach($sub_cond as $condition) {
							$query .= aux::first_comma("{$entity->name} WHERE", " AND ")."({$condition})";
						}
					}
				
					
					return $query;
				
				}
				
				break;
			}
		}	
		
		function search() {
			
			$entities = func_get_args();
		
			$text = $_REQUEST['text'];
			$_REQUEST['action'] = "search";
			$_REQUEST['page'] = 1;
			
			$empty = true;
			$skin = new Skinlet("search");
			
			foreach($entities as $entity) {
				
				if (is_array($entity->searchFields)) {
				
					$data = aux::getResult($GLOBALS['becontent']->getsearchform($entity));
				
					if (count($data) > 0) {
					
						$empty = false;
						foreach($data as $item) {
					
							$head = "";
					
							if (is_array($entity->searchHead)) {
								foreach($entity->searchHead as $field) {
									if (!$entity->existsField($field)) {
							
										$head .= " ".$item[$entity->name."_".$field."_".$_SESSION['language']];
									} else {
										$head .= " ".$item[$entity->name."_".$field];
									}
						
									
								}		
								
								$skin->setContent("handler", $entity->searchHandler);
								$skin->setContent("table", $entity->name);
								$skin->setContent("key", $entity->fields[0]['name']);
								$skin->setContent("value", $item["{$entity->name}_{$entity->fields[0]['name']}"]);
								$skin->setContent("title", $head);				
							}
						
							$body = "";
					
							if (is_array($entity->searchBody)) {
								foreach($entity->searchBody as $field) {
						
									if (!$entity->existsField($field)) {
										$body .= " ".$item[$entity->name."_".$field."_".$_SESSION['language']];
									} else {
										$body .= " ".$item[$entity->name."_".$field];
									}	
									
									$body .= "<br />";
									
								}
								$skin->setContent("body", $body);
							}
						
							if ($entity->owner) {
								$skin->setContent("date", "</p><p class=\"search-date\">".aux::lingual("Pubblicato","Published on", "")." ".aux::formatDate($item['creation'], EXTENDED));
							} else {
								$skin->setContent("date", "");
							}
						}
			
					} 
				}
			}
				
			if ($empty) {
				$skin = new Skinlet("search_empty");
				$skin->setContent("text", $_REQUEST['text']);
			}
			
			return $skin->get();
				
		}
		
		function clearCache($mode = HTML_IMG) {
			
			$dh = opendir($GLOBALS['config']['cache_folder']);
			
			while (false !== ($file = readdir($dh))) {
        		if (($file != ".") and ($file != "..")) {
        			
        			switch($mode) {
        				case HTML:
        					if (ereg("\.html$", $file)) {
        						unlink("{$GLOBALS['config']['cache_folder']}/{$file}");
        					}
        					break;
        				case IMG:
        					if (ereg("\.jpg$", $file)) {
        						unlink("{$GLOBALS['config']['cache_folder']}/{$file}");
        					}
        					break;
        				case HTML_IMG:
        					if ((ereg("\.html$", $file)) or (ereg("\.jpg$", $file))) {
        						unlink("{$GLOBALS['config']['cache_folder']}/{$file}");
        					}
        					break;
        				
        				
        			}
        			
        			
        		}
			}

    		closedir($dh);
		
			
			
		}
		
				
	}
		
$becontent = new beContent();




Class DB {
	var
	$host,
	$name,
	$user,
	$pass,
	$tables,
	$fields,
	$files,
	$entities;



	function DB($host,$name,$user,$pass) {

		$this->host = $host;
		$this->name = $name;
		$this->user = $user;
		$this->pass = $pass;

		
		$connection = mysql_pconnect($this->host,$this->user,$this->pass, MYSQL_CLIENT_COMPRESS);

		if ($connection) {
			$database=$connection;
			if (mysql_select_db($this->name)) {
				$dbms_database_open = true;
			} else {

				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_OPEN)." {$this->name}";
				exit;
			}
		} else {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_CONNECTION)." {$this->name}";
			exit;
		}

		$result = mysql_list_tables($this->name);

		while ($row = mysql_fetch_row($result)) {
			$this->tables[] = strtolower($row[0]);


			/*
			$oid = mysql_query("SHOW COLUMNS
			FROM {$row[0]}");
			if (!$oid){
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
			exit;
			}

			do {
			$data = mysql_fetch_assoc($oid);
			if ($data) {

			$this->fields[$row[0]][$data['Field']] = true;
			}
			} while ($data);
			*/
		}

	}

	function getEntityByName($name) {

		$result = false;
		$i=0;
		while ((!$result) and ($i<count($GLOBALS['becontent']->entities))) {
			if ($GLOBALS['becontent']->entities[$i]->name == $name) {
				$result = $GLOBALS['becontent']->entities[$i];
			}
			$i++;
		}
		return $result;

	}

	function existsTable($name) {
		$result = false;
		for($i=0;$i<count($this->tables);$i++) {
			if ($this->tables[$i] == $name) {
				$result = true;
			}
		}

		return $result;
	}

	function existsField($tableName, $fieldName) {

		return $this->fields[$tableName][$fieldName];
	}

	function init() {

		$oid = mysql_query("SELECT * FROM {$GLOBALS['usersEntity']->name}");

		if (mysql_num_rows($oid) == 0) {


			$GLOBALS['usersEntity']->insertItem(array(
				"username" 	=> $GLOBALS['config']['defaultuser']['username'],
				"password"	=> md5($GLOBALS['config']['defaultuser']['password']),
				"email"		=> $GLOBALS['config']['defaultuser']['email'],
				"name"		=> $GLOBALS['config']['defaultuser']['name'],
				"surname"	=> $GLOBALS['config']['defaultuser']['surname'])	
			);

			$GLOBALS['groupsEntity']->insertItem("1", "Administrator", "Administration Group.");
			$GLOBALS['usersGroupsRelation']->insertItem($GLOBALS['config']['defaultuser']['username'],"1");

			$GLOBALS['servicecategoryEntity']->insertItem(array(
				"id" 		=> "1",
				"name"		=> "System",
				"position" 	=> "1")	
			);

			$GLOBALS['servicecategoryEntity']->insertItem(array(
				"id" 		=> "2",
				"name"		=> "Content",
				"position" 	=> "2")	
			);
			
			$GLOBALS['servicecategoryEntity']->insertItem(array(
				"id" 		=> "3",
				"name"		=> "RSS",
				"position" 	=> "3")	
			);
			
			/* Services */
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "1",
				"name"		=> "Login",
				"script"	=> "login.php",
				"entry"		=> "Login",
				"servicecategory" => "0",
				"visible"	=> "*",
				"des"		=> "Login service",
				"id_entities" => "",
				"position"	=> "1")
			);
			
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "2",
				"name"		=> "Logout",
				"script"	=> "logout.php",
				"entry"		=> "Logout",
				"servicecategory" => "0",
				"visible"	=> "*",
				"des"		=> "Logout service",
				"id_entities" => "",
				"position"	=> "2")
			);
			
			
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "3",
				"name"		=> "User Management",
				"script"	=> "user-manager.php",
				"entry"		=> "Users",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "1")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "4",
				"name"		=> "Group Management",
				"script"	=> "group-manager.php",
				"entry"		=> "Groups",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "2")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "5",
				"name"		=> "Service Management",
				"script"	=> "service-manager.php",
				"entry"		=> "Services",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "3")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "6",
				"name"		=> "Service Category Management",
				"script"	=> "servicecategory-manager.php",
				"entry"		=> "Service Categories",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "4")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "7",
				"name"		=> "Logs",
				"script"	=> "logs.php",
				"entry"		=> "Logs",
				"servicecategory" => "1",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "5")
			);
			
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "8",
				"name"		=> "Page Management",
				"script"	=> "page-manager.php",
				"entry"		=> "Pages",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "1")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "9",
				"name"		=> "Menu Management",
				"script"	=> "menu-manager.php",
				"entry"		=> "Menu",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "2")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "10",
				"name"		=> "Template Management",
				"script"	=> "template-manager.php",
				"entry"		=> "Template",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "3")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "11",
				"name"		=> "News",
				"script"	=> "news-manager.php",
				"entry"		=> "News",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "4")
			);
			
			
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "12",
				"name"		=> "Comments",
				"script"	=> "comment-manager.php",
				"entry"		=> "Comments",
				"servicecategory" => "2",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "5")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "13",
				"name"		=> "Channel Manager",
				"script"	=> "channel-manager.php",
				"entry"		=> "Channels",
				"servicecategory" => "3",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "1")
			);
			
			$GLOBALS['servicesEntity']->insertItem(array(
				"id"		=> "14",
				"name"		=> "RSS Management",
				"script"	=> "rss-panel.php",
				"entry"		=> "Panel",
				"servicecategory" => "3",
				"visible"	=> "*",
				"des"		=> "",
				"id_entities" => "",
				"position"	=> "2")
			);
			
			
			$GLOBALS['lanEntity']->insertItem("en-US", "English");
			$GLOBALS['lanEntity']->insertItem("it-IT", "Italian");
			$GLOBALS['lanEntity']->insertItem("es-ES", "German");
			
			
			$GLOBALS['channelAssotiation']->insertItem("1", "news", "1");
			#$GLOBALS['rssMod']->insertItem("news", "MOD3");
			
			
			$GLOBALS['servicesGroupsRelation']->insertItem("1","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("2","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("3","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("4","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("5","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("6","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("7","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("8","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("9","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("10","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("11","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("12","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("13","1");
			$GLOBALS['servicesGroupsRelation']->insertItem("14","1");
	
		}
	}
}


/* Class Fields {
var
$fields,
$fieldsByName;

function Fields() {

}

function append($field) {
$this->fields[] = $field;
$this->fieldsByName[$field->getName()] = $field;
}

function exists($name) {
return array_key_exists($name, $this->fieldsByName);
}

function getField($name) {
if ($this->exists($name)) {
return $this->fieldsByName[$name];
} else {
return false;
}
}
}

Class Field {
var
$name,
$type;


function Field($name, $type) {
$this->name = $name;
$this->type = $type;
}
} */

Class Entity {
	var
	$fieldRepository,
	$database,
	$name,
	$fields,
	$lastFieldIndex,
	$presentation,
	$standardKey,
	$noKey,
	$owner,
	$addslashes,
	$reload,
	$referredBy,
	$relations,
	$positions,
	$filterRelation,
	$referenceOrder,
	$rss, // variabile booleana, vale true se l'entità è abilitata alla gestione degli rss
	$channel, // Vi verra memorizzato la relazione entita-canaleRss
	$rssPresentation, //Mantiene corrispondenze field entita -> campo Item
	$rssFilter, // filters item according to given criteria
	
	$searchFields, 	// list of fields to be searched
	$searchRelations, // list of n-m relations to be searched
	
	$searchHead,
	$searchBody, // presentation fieds
	
	$searchHandler, // the handler to be used to present data

	$comments,
	$moderated = true;

	function Entity($database,$name,$owner = "") {
		global
		$entitiesEntity;


		$this->owner = ($owner == WITH_OWNER);

		$this->addslashes = (!get_magic_quotes_gpc());

		#$this->addslashes = false;

		$this->database = $database;
		$this->name = $name;
		$this->standardKey = true;
		$this->noKey = false;
		$this->reload = false;
		$this->referenceOrder = false;

		$this->fields[0] = array("name" => "id",
		"type" => "INT UNSIGNED AUTO_INCREMENT",
		"primary key" => true,
		"foreign key" => false
		);

		

		if ($this->owner) {

			/* $this->fields[] = array("name" => "username",
			"type" => "VARCHAR",
			"foreign key" => true,
			"primary key" => false,
			"owner" => true,
			"length" => 15
			);*/

			$this->addReference($GLOBALS['usersEntity'], "username");
			$this->setFieldParameter("owner", true);
			$this->addField("creation", LONGDATE);
			$this->addField("lastModified", LONGDATE);

			/*
			The following is used in order to extend the referential integrity check
			to WITH_OWNER entities.

			*/

			$GLOBALS['usersEntity']->referred[$this->name][] = $this;
			$GLOBALS['usersEntity']->referredBy[$this->name]['entity'][] = $this;
			$GLOBALS['usersEntity']->referredBy[$this->name]['foreign key'][] = 'username';

		}

		#$GLOBALS['database']->entities[] = &$this;
		#Viene utilizzato per la gestione degli Rss
		$GLOBALS['becontent']->entities[$this->name] = &$this;
		
		$this->moderated = true;

	}

	function existsField($field) {
	
		$i = 0;
		$trovato = 0;

		while ((!$trovato) and ($i<count($this->fields))) {
			
			
			
			if ($this->fields[$i]['name'] == $field) {
				$trovato = 1;
			}
			$i++;
		}
		
		return $trovato; 
		
		#return $GLOBALS['database']->existsField($this->name, $field);
	}
	
	function setComments($arg) {
		$this->comments = $arg;
	}
	
	function addItem_postInsertion() {

	}
	
	function getField($name) {
		
		$field = false;
		foreach($this->fields as $k => $f) {
			if ($f['name'] == $name) {
				$field = $this->fields[$k];
			}
		}
		
		return $field;
		
	}

	function setExtension($name, $exts) {
		
		$index = false;
		foreach($this->fields as $k => $v) {
			if ($v['name'] == $name) {
				$this->fields[$k]['exts'] = $exts; 
			}
		}
		
	}
	
	function getKeyName() {

		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]['name'];
		}
	}

	function getKeyType() {
		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]['type'];
		}
	}

	function getKeyLength() {
		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]['length'];
		}
	}

	function standardKey() {
		return $this->standardKey;
	}

	function addPrimaryKey($name, $type, $length = "") {


		/* the following override the primary key definition given
		in the class constructor, which create a defaultKey as
		INT UNSIGNED */

		$this->fields[0] = array("name" => $name,
		"type" => $type,
		"foreign key" => false,
		"primary key" => true,
		"length" => $length
		//"mandatory" => $mandatory
		);

		$this->standardKey = false;

	}

	function noKey() {
		$this->noKey = true;
		unset($this->fields);
	}

	function addField($name, $type, $length = "", $mandatory = "no") {

		switch($type) {
			case "POSITION":
				/* 
					By definition, the first POSITION field is dominant over the other
				   	orderings.
				   	
				*/
				
				
				if (!$this->referenceOrder) {
					
					$this->setReferenceOrder($name);
				}
				$this->fields[] = array(
					"name" => $name,
					"type" => $type,
					"foreign key" => false,
					"primary key" => false,
					"length" => $length,
					"mandatory" => $mandatory
				);
				
			break;
			
			case "PASSWORD":
			$this->fields[] = array("name" => $name,
				"type" => $type,
				"foreign key" => false,
				"primary key" => false,
				"password method" => $length,
				"mandatory" => $mandatory
			);
			

			break;
			case FILE:
			case "IMAGE":
			case FILE2FOLDER:


			$GLOBALS['becontent']->files[md5($this->name.$name)]['table'] = $this->name;
			$GLOBALS['becontent']->files[md5($this->name.$name)]['field'] = $name;

			$this->fields[] = array("name" => $name,
				"type" => $type,
				"foreign key" => false,
				"primary key" => false,
				"length" => $length,
				"mandatory" => $mandatory
			);

			
			break;
			
			default:
			$this->fields[] = array("name" => $name,
			"type" => $type,
			"foreign key" => false,
			"primary key" => false,
			"length" => $length,
			"mandatory" => $mandatory
			);
			
			
			
			
			break;
		}


	}
	
	function setReferenceOrder($field) {
		$this->referenceOrder = $field;
	}
	
	function getReferenceOrder() {
		return $this->referenceOrder;
	}

	
	function checkName($name) {
		/*
		if (in_array($name,$RESERVEDWORDS)) {
			echo "Error: '{$name}' is a reserved name and cannot be used in entity '{$this->name}'!";
			exit;
		}
		*/
		
		
	}

	function addReference(&$entity, $name = "") {

		/*

		Different names should allow the definition of multiple foreigner keys targeting
		the same Entity.

		*/
		
		$this->checkName($name);

		if ($name == "") {
			$name = "id_{$entity->name}";
		}

		$type = $entity->fields[0]['type'];
		$length = (isset($entity->fields[0]['length']) ? $entity->fields[0]['length'] : '');
		
		if ($this->name == $entity->name) {
			$selfRelation = true;
		} else {
			$selfRelation = false;
		}

		$this->fields[] = array("name" => $name,
		"type" => $type,
		"localtype" => "reference",
		"entity" => $entity->name,
		"length" => $length,
		"foreign key" => true,
		"primary key" => false,
		"reference" => $entity,
		"reference_name" => $entity->name,
		"self_reference" => $selfRelation
		);

		$entity->referred[$this->name][] = $this;

		$entity->referredBy[$this->name]['entity'][] = $this;
		$entity->referredBy[$this->name]['foreign key'][] = $name;
		
		if ($this->name == $entity->name) {
			
			$GLOBALS['becontent']->selfrefs[md5($this->name.$name)]['table'] = $this->name;
			$GLOBALS['becontent']->selfrefs[md5($this->name.$name)]['field'] = $name;
		}
		
		$this->lastFieldIndex = count($this->fields)-1;

	}
	
	function setFieldParameter($name, $value) {
		$this->fields[$this->lastFieldIndex][$name] = $value;
	}

	function setPresentation() {

		$this->presentation = func_get_args();; 

	}
	
	function setTextSearchFields() {
		$this->searchFields['TEXT'] = func_get_args();
	}
	
	function setCheckSearchField($name, $label) {
		$this->searchFields['CHECK'][] = $name;
		$this->searchFields['CHECKLABEL'][] = $label;
	}
	
	function setCheckSearchFields() {
		$this->searchFields['CHECK'] = func_get_args();
	}
	
	function setSearchRelations() {
		$this->searchRelations = func_get_args();
	}
	
	function setSearchRelation($relation, $label) {
		$this->searchRelations[] = $relation;
		$this->searchFields['RELATIONLABEL'][] = $label;
	}
	
	function setSearchPresentationHead() {
		$this->searchHead = func_get_args();
	}
	
	function setSearchPresentationBody() {
		$this->searchBody = func_get_args();
	}

	function setHandler($script) {
		$this->searchHandler = $script;
	}
	
	function getResult() {
		
		$query = "SELECT * FROM {$this->name} ";
		
		if (is_array($this->relations)) {
			foreach($this->relations as $relation) {
				$query .= "LEFT JOIN {$relation->name} ";
			
				foreach($relation->fields as $key => $field) {
					if ($_REQUEST[$field['name']] != '') {
						$query .= "ON {$this->name}.{$this->fields[0]['name']} = {$relation->name}.{$field['name']}";
					}
				} 
			}
		}
		
		$query;
	}

	function connect() {

		#global $entitiesEntity;

		if (true) { // isset($_['init])
			if (!$this->database->existsTable($this->name)) {

				$query = "CREATE TABLE {$this->name} (";

				foreach ($this->fields as $k => $v) {
	
					if (($this->standardKey) and ($k == 0) and ($v['primary key'])) {
						#$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} {$v['type']}";
					}

					#echo "{$v['name']}, *{$v['type']}*, {$v['length']}<br>";

					switch ($v['type']) {
						case VARCHAR:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} {$v['type']}({$v['length']}) NOT NULL";
						break;
						case TEXT:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} {$v['type']} NOT NULL";
						break;
						case FILE:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} LONGBLOB NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_filename VARCHAR(255) NOT NULL";
						#$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_original_filename VARCHAR(255) NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_size INT UNSIGNED NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_type VARCHAR(40) NOT NULL";

						break;
						
						case FILE2FOLDER:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_reference VARCHAR(255) NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_filename VARCHAR(255) NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_size INT UNSIGNED NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_type VARCHAR(40) NOT NULL";

						break;
					
						case IMAGE:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} LONGBLOB NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_thumb LONGBLOB NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_filename VARCHAR(255) NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_size INT UNSIGNED NOT NULL";
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']}_type VARCHAR(40) NOT NULL";

						break;
					
						case INT:
						case STANDARD_PRIMARY_KEY_TYPE:
						case POSITION:
						if ($v['primary key']) {
							$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} INT UNSIGNED AUTO_INCREMENT";
						} else {
							$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} INT UNSIGNED NOT NULL";
						}
						break;
						case DATE:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} VARCHAR(8) NOT NULL";
						break;
					/**
				 * the following is only for internal use at the moment, used in combination with 
				 * the WITH_OWNER option.
				 * 
				 */
						case LONGDATE:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} VARCHAR(12) NOT NULL";
						break;
						case PASSWORD:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} VARCHAR(32) NOT NULL";
						break;
						case COLOR:
						$query .= aux::first_comma("create".$this->name,", ")."{$v['name']} VARCHAR(7) NOT NULL";
						break;
					}

				}

				if ($this->noKey) {
					$query .= ")";
				} else {
					$query .= ", primary key({$this->fields[0]['name']}))";
				}

			#echo "<hr>",$query, "<hr>";

				$oid = mysql_query($query);
				if (!$oid) {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_QUERY)." {$this->name} at line ",__LINE__;
					echo "<hr>", $query;
					exit;
				}
			} else {
			/*
			$query = "ALTER TABLE {$this->name} ";
			$alter = false;

			foreach($this->fields as $k => $field) {

			if (!$this->database->existsField($this->name,$field['name'])) {

			echo "QIO ";

			$alter = true;
			$query .= "ADD ";

			switch ($field['type']) {
			case VARCHAR:
			$query .= aux::first_comma("alter".$this->name,", ")."{$field[name]} {$field[type]}({$field[length]}) NOT NULL";
			break;
			case TEXT:
			$query .= aux::first_comma("alter".$this->name,", ")."{$field[name]} {$field[type]} NOT NULL";
			break;
			case INT:
			$query .= aux::first_comma("alter".$this->name,", ")."{$field[name]} INT UNSIGNED NOT NULL";
			break;
			case DATE:
			$query .= aux::first_comma("alter".$this->name,", ")."{$field[name]} VARCHAR(8) NOT NULL";
			break;
			}

			}

			}
			echo $query;
			exit;
			*/
			}	


			$GLOBALS['becontent']->entities[] = $this;
		
			$this->register();

		}
	}

	function register() {
		global $entitiesEntity;
		
		if (isset($GLOBALS['entitiesEntity'])) {
			
			$oid = mysql_query("INSERT INTO {$entitiesEntity->name}
			                         VALUES('{$this->name}','{$this->name}', '{$this->owner}', '', 0, 0, 0)");
			
			
			if (!$oid) {
				/*

				At the moment, this is executed each time but the first time, because of
				the duplicate key notification. This can be avoided with a session based
				technique.

				*/
			}
		}


	}

	function editItem() {
		
		$query = "UPDATE {$this->name} SET ";
		
		$_REQUEST['lastModified'] = date('YmdHi');
		
		for($i=1; $i<count($this->fields); $i++) {

			if ((array_key_exists($this->fields[$i]['name'], $_REQUEST)) or 
			    ($this->fields[$i]['type'] == FILE) or 
			    ($this->fields[$i]['type'] == FILE2FOLDER)) {
				
				if ($this->addslashes) {
					if (isset($_REQUEST[$this->fields[$i]['name']])) {
						$this->fields[$i]['value'] = addslashes($_REQUEST[$this->fields[$i]['name']]);
					}
				} else {
					if (isset($_REQUEST[$this->fields[$i]['name']])) {
						$this->fields[$i]['value'] = $_REQUEST[$this->fields[$i]['name']];
					}
				}
	
				switch ($this->fields[$i]['type']) {
					case "DATE":
						
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
					
					case LONGDATE:
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						
						$time = explode(":", $_REQUEST[$this->fields[$i]['name']."_time"]);
						$this->fields[$i]['value'] .= $time[0].$time[1];
						
						$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
	
					case FILE:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
	
							$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}='{$buffer}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					case FILE2FOLDER:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
							unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
						}			
						$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}_reference = ''";
						$query .= ", {$this->fields[$i]['name']}_filename = ''";
						$query .= ", {$this->fields[$i]['name']}_size = ''";
						$query .= ", {$this->fields[$i]['name']}_type = ''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							
							
							if ($_REQUEST[$this->fields[$i]['name']."_reference"] != "") {
								if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
									unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
								}
							}
							
							$filename_local = md5(uniqid(time()));
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
							
							if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
								
								if (isset($this->fields[$i]['exts'][$token[1]])) {
									if ($this->fields[$i]['exts'][$token[1]] == AUTO) {
										$extension = ".{$token[1]}";
									} else {
										$extension = ".{$this->fields[$i]['exts'][$token[1]]}";
									}
								} else {
									$extension = "";
								}
								
							}  
							
							$filename_local = $filename_local.$extension;
	
							move_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'], $GLOBALS['config']['upload_folder']."/$filename_local");						
							if ($this->addslashes) {			
								$filename = addslashes($filename);
							} 
	
							$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}_reference='{$filename_local}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					
					case "IMAGE":
					
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_thumb=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
							
							/* ** */
							
							#list($width, $height) = getimagesize($_FILES[$this->fields[$i]['name']]['tmp_name']);
							$newwidth = 100; // $width * $percent;
							$newheight = 100; //$height * $percent;
	
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							$source = imagecreatefromjpeg($_FILES[$this->fields[$i]['name']]['tmp_name']);
	
	// Resize
							imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
							imagejpeg($thumb,$_FILES[$this->fields[$i]['name']]['tmp_name']);
								
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer_thumb = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
				
							/* ** */
	
							$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}='{$buffer}'";
							$query .= ", {$this->fields[$i]['name']}_thumb='{$buffer_thumb}}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
	
	
					case POSITION:
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					$this->positions[$this->fields[$i]['name']]['index'] = $i;
					$this->positions[$this->fields[$i]['name']]['all'] = $_REQUEST["{$this->fields[$i]['name']}_all"];
					$this->positions[$this->fields[$i]['name']]['value'] = $this->fields[$i]['value'];
					
					#echo "edit ", $_REQUEST["{$this->fields[$i]['name']}_all"];
					
					break;
	
					case PASSWORD:
	
						if ((isset($this->fields[$i]['value'])) and ($this->fields[$i]['value'] != "")) {
							$query .= aux::first_comma("addItem".$this->name,", ")."{$this->fields[$i]['name']}=MD5('{$this->fields[$i]['value']}')";
						}
						break;
	
					default:
	
					/* HTMLENTITIES */
	
					
					
					if (!isset($this->fields[$i]['value'])) {
						$this->fields[$i]['value'] = "";
					}
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					break;
				}
			}
		}
		
		$query .= " WHERE {$this->fields[0]['name']}='{$_REQUEST[$this->fields[0]['name']]}'";
		$oid = mysql_query($query);
		
		if (!$oid) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_QUERY)." (".basename(__FILE__).":".__LINE__.")";
			echo mysql_error();
			echo "<hr>";
			echo $query;
			exit;
		}

		if (count($this->positions) > 0) {

			$insert_id = $_REQUEST[$this->fields[0]['name']];

			foreach($this->positions as $position_key => $position_value) {
				$positions = explode(":", $position_value['all']);
				
				array_pop($positions);
				
				

				 foreach($positions as $single_key => $single_value) {
					
					if ($single_value == 0) {
						$id = $insert_id;
					} else {
						$id = $single_value;
					}
					
					$position = $single_key+1;

					$query = "UPDATE {$this->name} SET {$position_key} = {$position} WHERE {$this->fields[0]['name']} = '{$id}'";

					#echo "{$query}<br>";
					
					$oid = mysql_query($query);


					if (!$oid) {
						return false;
					}
				} 
				
				
				
			}
		}

		$GLOBALS['logEntity']->insertItem(NULL, 
										  'EDIT',
										  $this->name,
										  $_REQUEST[$this->fields[0]['name']],
										  basename($_SERVER['SCRIPT_FILENAME']),
										  $_SESSION['user']['username'],
										  date("YmdHi"),
										  $_SERVER['HTTP_HOST']);
										  
										  
		$GLOBALS['becontent']->clearCache(HTML_IMG);

		if (!$oid) {
			return false;
		} else {
			return true;
		}

	}
	
	
	function editItem2() {

		$query = "UPDATE {$this->name} SET ";
		
		for($i=1; $i<count($this->fields); $i++) {

			$_REQUEST[$this->fields[$i]['name']] = htmlentities($_REQUEST[$this->fields[$i]['name']]);
			
			if ($this->addslashes) {
				if (isset($_REQUEST[$this->fields[$i]['name']])) {
					$this->fields[$i]['value'] = addslashes($_REQUEST[$this->fields[$i]['name']]);
				}
			} else {
				if (isset($_REQUEST[$this->fields[$i]['name']])) {
					$this->fields[$i]['value'] = $_REQUEST[$this->fields[$i]['name']];
				}
			}
			
			if (array_key_exists($this->fields[$i]['name'],$_REQUEST)) {
				
				
			
				switch ($this->fields[$i]['type']) {
					case "DATE":
						
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
					
					case LONGDATE:
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						
						$time = explode(":", $_REQUEST[$this->fields[$i]['name']."_time"]);
						$this->fields[$i]['value'] .= $time[0].$time[1];
						
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
	
					case FILE:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						$query .= ", {$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
	
							$query .= ", {$this->fields[$i]['name']}='{$buffer}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					case FILE2FOLDER:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
							unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
						}			
						$query .= ", {$this->fields[$i]['name']}_reference = ''";
						$query .= ", {$this->fields[$i]['name']}_filename = ''";
						$query .= ", {$this->fields[$i]['name']}_size = ''";
						$query .= ", {$this->fields[$i]['name']}_type = ''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							
							
							if ($_REQUEST[$this->fields[$i]['name']."_reference"] != "") {
								if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
									unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
								}
							}
							
							$filename_local = md5(uniqid(time()));
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
							
							if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
								
								if (isset($this->fields[$i]['exts'][$token[1]])) {
									if ($this->fields[$i]['exts'][$token[1]] == AUTO) {
										$extension = ".{$token[1]}";
									} else {
										$extension = ".{$this->fields[$i]['exts'][$token[1]]}";
									}
								} else {
									$extension = "";
								}
								
							}  
							
							$filename_local = $filename_local.$extension;
	
							move_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'], $GLOBALS['config']['upload_folder']."/$filename_local");						
							if ($this->addslashes) {			
								$filename = addslashes($filename);
							} 
	
							$query .= ", {$this->fields[$i]['name']}_reference='{$filename_local}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					
					case "IMAGE":
					
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						$query .= ", {$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_thumb=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
							
							/* ** */
							
							#list($width, $height) = getimagesize($_FILES[$this->fields[$i]['name']]['tmp_name']);
							$newwidth = 100; // $width * $percent;
							$newheight = 100; //$height * $percent;
	
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							$source = imagecreatefromjpeg($_FILES[$this->fields[$i]['name']]['tmp_name']);
	
	// Resize
							imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
							imagejpeg($thumb,$_FILES[$this->fields[$i]['name']]['tmp_name']);
								
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer_thumb = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
				
							/* ** */
	
							$query .= ", {$this->fields[$i]['name']}='{$buffer}'";
							$query .= ". {$this->fields[$i]['name']}_thumb='{$buffer_thumb}}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
	
	
					case POSITION:
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					$this->positions[$this->fields[$i]['name']]['index'] = $i;
					$this->positions[$this->fields[$i]['name']]['all'] = $_REQUEST["{$this->fields[$i]['name']}_all"];
					$this->positions[$this->fields[$i]['name']]['value'] = $this->fields[$i]['value'];
					
					#echo "edit ", $_REQUEST["{$this->fields[$i]['name']}_all"];
					
					break;
	
					case PASSWORD:
	#				if ($this->fields[$i]['value'] != "") {
					if (isset($this->fields[$i]['value'])) {
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}=MD5('{$this->fields[$i]['value']}')";
					}
					break;
	
					default:
	
					/* HTMLENTITIES */
	
					#$this->fields[$i]['value'] = htmlentities($this->fields[$i]['value']);
	
					if (!isset($this->fields[$i]['value'])) {
						$this->fields[$i]['value'] = "";
					}
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					break;
				}
		
			}
		}

		$query .= " WHERE {$this->fields[0]['name']}='{$_REQUEST[$this->fields[0]['name']]}'";
		
		$oid = mysql_query($query);

		if (!$oid) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_QUERY)." (".basename(__FILE__).":".__LINE__.")";
			echo mysql_error();
			echo "<hr>";
			echo $query;
			exit;
		}

		if (count($this->positions) > 0) {

			$insert_id = $_REQUEST[$this->fields[0]['name']];

			foreach($this->positions as $position_key => $position_value) {
				
				
				/* Warning: this must be tested, in other words the editItem() function has been 
				   modified in order to have forms with only part of the fields of the entity, and as
				   such also position widgets can be included or excluded - the following should be executed 
				   only if the position widget is in the form.
				   
				*/
				
				if (array_key_exists($position_key, $_REQUEST)) {
				
					$positions = explode(":", $position_value['all']);
					
					array_pop($positions);
					
					
	
					 foreach($positions as $single_key => $single_value) {
						
						if ($single_value == 0) {
							$id = $insert_id;
						} else {
							$id = $single_value;
						}
						
						$position = $single_key+1;
	
						$query = "UPDATE {$this->name} SET {$position_key} = {$position} WHERE {$this->fields[0]['name']} = '{$id}'";
	
						#echo "{$query}<br>";
						
						$oid = mysql_query($query);
	
	
						if (!$oid) {
							return false;
						}
					} 
				}
				
				
			}
		}



		if (!$oid) {
			return false;
		} else {
			return true;
		}

	}
	
	function editItem3() {

		$query = "UPDATE {$this->name} SET ";
		
		for($i=1; $i<count($this->fields); $i++) {

			$_REQUEST[$this->fields[$i]['name']] = htmlentities($_REQUEST[$this->fields[$i]['name']]);
			
			if ($this->addslashes) {
				if (isset($_REQUEST[$this->fields[$i]['name']])) {
					$this->fields[$i]['value'] = addslashes($_REQUEST[$this->fields[$i]['name']]);
				}
			} else {
				if (isset($_REQUEST[$this->fields[$i]['name']])) {
					$this->fields[$i]['value'] = $_REQUEST[$this->fields[$i]['name']];
				}
			}
			
			if (array_key_exists($this->fields[$i]['name'],$_REQUEST)) {
				
				
			
				switch ($this->fields[$i]['type']) {
					case "DATE":
						
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
					
					case LONGDATE:
						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						
						$time = explode(":", $_REQUEST[$this->fields[$i]['name']."_time"]);
						$this->fields[$i]['value'] .= $time[0].$time[1];
						
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					break;
	
					case FILE:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						$query .= ", {$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
	
							$query .= ", {$this->fields[$i]['name']}='{$buffer}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					case FILE2FOLDER:
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
							unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
						}			
						$query .= ", {$this->fields[$i]['name']}_reference = ''";
						$query .= ", {$this->fields[$i]['name']}_filename = ''";
						$query .= ", {$this->fields[$i]['name']}_size = ''";
						$query .= ", {$this->fields[$i]['name']}_type = ''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							
							
							if ($_REQUEST[$this->fields[$i]['name']."_reference"] != "") {
								if (file_exists("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}")) {
									unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$this->fields[$i]['name']."_reference"]}");
								}
							}
							
							$filename_local = md5(uniqid(time()));
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
							
							if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
								
								if (isset($this->fields[$i]['exts'][$token[1]])) {
									if ($this->fields[$i]['exts'][$token[1]] == AUTO) {
										$extension = ".{$token[1]}";
									} else {
										$extension = ".{$this->fields[$i]['exts'][$token[1]]}";
									}
								} else {
									$extension = "";
								}
								
							}  
							
							$filename_local = $filename_local.$extension;
	
							move_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'], $GLOBALS['config']['upload_folder']."/$filename_local");						
							if ($this->addslashes) {			
								$filename = addslashes($filename);
							} 
	
							$query .= ", {$this->fields[$i]['name']}_reference='{$filename_local}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
					
					
					case "IMAGE":
					
					if ($_REQUEST[$this->fields[$i]['name']."_delete"]) {
						
						$query .= ", {$this->fields[$i]['name']}=''";
						$query .= ", {$this->fields[$i]['name']}_thumb=''";
						$query .= ", {$this->fields[$i]['name']}_filename=''";
						$query .= ", {$this->fields[$i]['name']}_size=''";
						$query .= ", {$this->fields[$i]['name']}_type=''";
	
					} else {
						if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
							$filename = $_FILES[$this->fields[$i]['name']]['name'];
							$filesize = $_FILES[$this->fields[$i]['name']]['size'];
							$filetype = $_FILES[$this->fields[$i]['name']]['type'];
	
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
	
							if ($this->addslashes) {
								
								$filename = addslashes($filename);
							} else {
								#$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
							}
	
	
							if (get_magic_quotes_gpc()) {
								/*
	
								Here instead of trim one should use stripslashes but doesn't work.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							} else {
								/*
	
								It could be that here something different is required.
	
								*/
	
								$buffer = mysql_real_escape_string(trim($buffer));
							}
							fclose($fp);
							
							/* ** */
							
							#list($width, $height) = getimagesize($_FILES[$this->fields[$i]['name']]['tmp_name']);
							$newwidth = 100; // $width * $percent;
							$newheight = 100; //$height * $percent;
	
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							$source = imagecreatefromjpeg($_FILES[$this->fields[$i]['name']]['tmp_name']);
	
	// Resize
							imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
							imagejpeg($thumb,$_FILES[$this->fields[$i]['name']]['tmp_name']);
								
							$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
							$buffer_thumb = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));
				
							/* ** */
	
							$query .= ", {$this->fields[$i]['name']}='{$buffer}'";
							$query .= ". {$this->fields[$i]['name']}_thumb='{$buffer_thumb}}'";
							$query .= ", {$this->fields[$i]['name']}_filename='{$filename}'";
							$query .= ", {$this->fields[$i]['name']}_size='{$filesize}'";
							$query .= ", {$this->fields[$i]['name']}_type='{$filetype}'";
	
						}
					}
	
					break;
	
	
					case POSITION:
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					
					$this->positions[$this->fields[$i]['name']]['index'] = $i;
					$this->positions[$this->fields[$i]['name']]['all'] = $_REQUEST["{$this->fields[$i]['name']}_all"];
					$this->positions[$this->fields[$i]['name']]['value'] = $this->fields[$i]['value'];
					
					#echo "edit ", $_REQUEST["{$this->fields[$i]['name']}_all"];
					
					break;
	
					case PASSWORD:
	#				if ($this->fields[$i]['value'] != "") {
					if (isset($this->fields[$i]['value'])) {
						$query .= aux::first_comma("addItem".$this->name,", ").
						"{$this->fields[$i]['name']}=MD5('{$this->fields[$i]['value']}')";
					}
					break;
	
					default:
	
					/* HTMLENTITIES */
	
					#$this->fields[$i]['value'] = htmlentities($this->fields[$i]['value']);
	
					if (!isset($this->fields[$i]['value'])) {
						$this->fields[$i]['value'] = "";
					}
					$query .= aux::first_comma("addItem".$this->name,", ").
					"{$this->fields[$i]['name']}='{$this->fields[$i]['value']}'";
					break;
				}
		
			}
		}

		$query .= " WHERE {$this->fields[0]['name']}='{$_REQUEST[$this->fields[0]['name']]}'";
		
		$oid = mysql_query($query);

		if (!$oid) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_QUERY)." (".basename(__FILE__).":".__LINE__.")";
			echo mysql_error();
			echo "<hr>";
			echo $query;
			exit;
		}

		if (count($this->positions) > 0) {

			$insert_id = $_REQUEST[$this->fields[0]['name']];

			foreach($this->positions as $position_key => $position_value) {
				
				
				/* Warning: this must be tested, in other words the editItem() function has been 
				   modified in order to have forms with only part of the fields of the entity, and as
				   such also position widgets can be included or excluded - the following should be executed 
				   only if the position widget is in the form.
				   
				*/
				
				if (array_key_exists($position_key, $_REQUEST)) {
				
					$positions = explode(":", $position_value['all']);
					
					array_pop($positions);
					
					
	
					 foreach($positions as $single_key => $single_value) {
						
						if ($single_value == 0) {
							$id = $insert_id;
						} else {
							$id = $single_value;
						}
						
						$position = $single_key+1;
	
						$query = "UPDATE {$this->name} SET {$position_key} = {$position} WHERE {$this->fields[0]['name']} = '{$id}'";
	
						#echo "{$query}<br>";
						
						$oid = mysql_query($query);
	
	
						if (!$oid) {
							return false;
						}
					} 
				}
				
				
			}
		}



		if (!$oid) {
			return false;
		} else {
			return true;
		}

	}

	function addItem() {

		$session_id_name = "S_".md5($this->name);
		if (($_REQUEST[$session_id_name] == $_SESSION[$session_id_name])) {

			$_SESSION[$session_id_name] = "*";

		} else {

			$this->reload = true;
			return false;

		}


		$query = "INSERT INTO {$this->name} VALUES(";


		if ($this->owner) {
			$_REQUEST['creation'] = date('YmdHi');
			$_REQUEST['lastModified'] = date('YmdHi');
		}

		$commaId = md5(microtime());

		if (($this->standardKey) and ($this->fields[0]['primary key'])) {
		
			
			$query .= aux::first_comma($commaId,", ")."NULL";
			
			
			for($i=1; $i<count($this->fields); $i++) {

				/* HTML ENTITIES ? */
				
				#$_REQUEST[$this->fields[$i]['name']] = htmlentities($_REQUEST[$this->fields[$i]['name']]);
				
				if ($this->addslashes) {
					if (isset($_REQUEST[$this->fields[$i]['name']])) {
						$this->fields[$i]['value'] = addslashes($_REQUEST[$this->fields[$i]['name']]);
					}
				} else {
					if (isset($_REQUEST[$this->fields[$i]['name']])) {
						$this->fields[$i]['value'] = $_REQUEST[$this->fields[$i]['name']];
					}
				}


				switch ($this->fields[$i]['type']) {
					case "DATE":

						$date = explode("/",$this->fields[$i]['value']);
						$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
						$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";
					break;
					
					case LONGDATE: 
					
					$date = explode("/",$this->fields[$i]['value']);
					$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
					
					$time = explode(":", $_REQUEST[$this->fields[$i]['name']."_time"]);
					$this->fields[$i]['value'] .= $time[0].$time[1];
					
					
					$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";
						
					break;

					case FILE:

					if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
						
						$filename = $_FILES[$this->fields[$i]['name']]['name'];
						$filesize = $_FILES[$this->fields[$i]['name']]['size'];
						$filetype = $_FILES[$this->fields[$i]['name']]['type'];

						$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
						$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);

						/*
						if ($this->addslashes) {

						$buffer = addslashes(file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']));
						} else {
						$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
						}
						*/
						#$buffer = aux::quote_smart(file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']));

						if (get_magic_quotes_gpc()) {
							/*

							Here instead of trim one should use stripslashes but doesn't work.

							*/

							$buffer = mysql_real_escape_string(trim($buffer));
						} else {
							/*

							It could be that here something different is required.

							*/

							$buffer = mysql_real_escape_string(trim($buffer));
						}

						fclose($fp);
					} else {
						$buffer = "";
						$filename = "";
						$filezize = 0;
						$filetype = "";
					}

					$buffer = (isset($buffer)) ? $buffer:"";
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";

					$filename = (isset($filename)) ? $filename:"";
					$query .= aux::first_comma($commaId,", ")."'{$filename}'";

					$filesize = (isset($filesize)) ? $filesize:"";
					$query .= aux::first_comma($commaId,", ")."'{$filesize}'";

					$filetype = (isset($filetype)) ? $filetype:"";
					$query .= aux::first_comma($commaId,", ")."'{$filetype}'";
					
					break;

					case FILE2FOLDER:

					if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
						
						$filename_local = md5(uniqid(time()));
						$filename = $_FILES[$this->fields[$i]['name']]['name'];
						$filesize = $_FILES[$this->fields[$i]['name']]['size'];
						$filetype = $_FILES[$this->fields[$i]['name']]['type'];
						
						if (ereg("\.([[:alnum:]]*)$", $filename, $token)) {
							
							
							
							if (isset($this->fields[$i]['exts'][$token[1]])) {
								if ($this->fields[$i]['exts'][$token[1]] == AUTO) {
									$extension = ".{$token[1]}";
								} else {
									$extension = ".{$this->fields[$i]['exts'][$token[1]]}";
								}
							} else {
								$extension = "";
							}
							
						}  
						
						$filename_local = $filename_local.$extension;
						move_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'], "{$GLOBALS['config']['upload_folder']}/{$filename_local}");
					} else {
						$filename_local = "";
						$filename = "";
						$filesize = 0;
						$filetype = "";
						
					}

					
					$query .= aux::first_comma($commaId,", ")."'{$filename_local}'";

					$filename = (isset($filename)) ? $filename:"";
					$query .= aux::first_comma($commaId,", ")."'{$filename}'";

					$filesize = (isset($filesize)) ? $filesize:"";
					$query .= aux::first_comma($commaId,", ")."'{$filesize}'";

					$filetype = (isset($filetype)) ? $filetype:"";
					$query .= aux::first_comma($commaId,", ")."'{$filetype}'";
					break;
					
					case "IMAGE":

					if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
						$filename = $_FILES[$this->fields[$i]['name']]['name'];
						$filesize = $_FILES[$this->fields[$i]['name']]['size'];
						$filetype = $_FILES[$this->fields[$i]['name']]['type'];

						$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
						$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);

						if (get_magic_quotes_gpc()) {
							/*

							Here instead of trim one should use stripslashes but doesn't work.

							*/

							$buffer = mysql_real_escape_string(trim($buffer));
						} else {
							/*

							It could be that here something different is required.

							*/

							$buffer = mysql_real_escape_string(trim($buffer));
						}

						fclose($fp);
					}
					
					/* ** */
					
					list($width, $height) = getimagesize($_FILES[$this->fields[$i]['name']]['tmp_name']);
					$newwidth = 100; // $width * $percent;
					$newheight = 100; //$height * $percent;

					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($_FILES[$this->fields[$i]['name']]['tmp_name']);

// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
				
				/* $buffer = imagejpeg($thumb); */		
					
					/* ** */

					$buffer = (isset($buffer)) ? $buffer:"";
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";
					
					/* Thumb */
					$buffer = imagejpeg($thumb);
					
					$buffer = (isset($buffer)) ? $buffer:"";
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";

					$filename = (isset($filename)) ? $filename:"";
					$query .= aux::first_comma($commaId,", ")."'{$filename}'";

					$filesize = (isset($filesize)) ? $filesize:"";
					$query .= aux::first_comma($commaId,", ")."'{$filesize}'";

					$filetype = (isset($filetype)) ? $filetype:"";
					$query .= aux::first_comma($commaId,", ")."'{$filetype}'";
					break;

					case "POSITION":

					$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";

					$this->positions[$this->fields[$i]['name']]['index'] = $i;
					$this->positions[$this->fields[$i]['name']]['all'] = $_REQUEST["{$this->fields[$i]['name']}_all"];
					$this->positions[$this->fields[$i]['name']]['value'] = $this->fields[$i]['value'];

					
					
					break;

					case "PASSWORD":

					#$query .= aux::first_comma("addItem".$this->name,", ")."MD5('{$this->fields[$i]['value']}')";
					$query .= aux::first_comma($commaId,", ")."MD5('{$this->fields[$i]['value']}')";

					break;

					default:

					/* 
					
						The following add a field for all the other cases, including the case WITH_OWNER
						where the username in the session is added 
						
						4/08/2008 - a variant is added for the WITH_OWNER case in order to deal with the
						case in which 
						
							- the logged user is an administrator, and
							- the manager-script for the WITH_OWNER-entity allows administrator to choose 
							  the user for the owner
							
					*/
					

					if (isset($this->fields[$i]['owner'])) {
						
						/* the user is admin and the script has an selectfromreference for user */
						
						if (($_SESSION['user']['admin']) and (isset($this->fields[$i]['value']))) {
							$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";
						} else {
							$query .= aux::first_comma($commaId,", ")."'{$_SESSION['user']['username']}'";
						}
					} else {
						
						if (!isset($this->fields[$i]['value'])) {
							$this->fields[$i]['value'] = "";
						}

						$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";
					}
					break;
				}
			}


		} else {


			
			for($i=0; $i<count($this->fields); $i++) {

				/* HTML ENTITIES ? */
				
				#$_REQUEST[$this->fields[$i]['name']] = htmlentities($_REQUEST[$this->fields[$i]['name']]);
				
				if ($this->addslashes) {
					$this->fields[$i]['value'] = addslashes($_REQUEST[$this->fields[$i]['name']]);
				} else {
					$this->fields[$i]['value'] = $_REQUEST[$this->fields[$i]['name']];
				}

				#echo "<br>** ",$this->fields[$i]['type'];

				switch ($this->fields[$i]['type']) {
					case "DATE":
					$date = explode("/",$this->fields[$i]['value']);
					$this->fields[$i]['value'] = $date[2].$date[1].$date[0];
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$this->fields[$i]['value']}'";
					$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";
					break;
					case FILE:

					if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
						$filename = $_FILES[$this->fields[$i]['name']]['name'];
						$filesize = $_FILES[$this->fields[$i]['name']]['size'];
						$filetype = $_FILES[$this->fields[$i]['name']]['type'];

						$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
						#$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));

						if ($this->addslashes) {
							$buffer = addslashes(file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']));
						} else {
							$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
						}
						fclose($fp);
					}


					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$buffer}'";
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filename}'";
					$query .= aux::first_comma($commaId,", ")."'{$filename}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filesize}'";
					$query .= aux::first_comma($commaId,", ")."'{$filesize}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filetype}'";
					$query .= aux::first_comma($commaId,", ")."'{$filetype}'";

					break;
					
					case "IMAGE":

					if (is_uploaded_file($_FILES[$this->fields[$i]['name']]['tmp_name'])) {
						$filename = $_FILES[$this->fields[$i]['name']]['name'];
						$filesize = $_FILES[$this->fields[$i]['name']]['size'];
						$filetype = $_FILES[$this->fields[$i]['name']]['type'];

						$fp = fopen($_FILES[$this->fields[$i]['name']]['tmp_name'],"r");
						#$buffer = fread($fp, filesize($_FILES[$this->fields[$i]['name']]['tmp_name']));

						if ($this->addslashes) {
							$buffer = addslashes(file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']));
						} else {
							$buffer = file_get_contents($_FILES[$this->fields[$i]['name']]['tmp_name']);
						}
						fclose($fp);
					}
					
					/* ** */

					list($width, $height) = getimagesize($_FILES[$this->fields[$i]['name']]['tmp_name']);
					$newwidth = 100; // $width * $percent;
					$newheight = 100; //$height * $percent;

					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($_FILES[$this->fields[$i]['name']]['tmp_name']);

// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
				
				/* $buffer = imagejpeg($thumb); */

					/* ** */
					
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$buffer}'";
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";
					/* THUMB */
					$buffer = imagejpeg($thumb);
					$query .= aux::first_comma($commaId,", ")."'{$buffer}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filename}'";
					$query .= aux::first_comma($commaId,", ")."'{$filename}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filesize}'";
					$query .= aux::first_comma($commaId,", ")."'{$filesize}'";
					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$filetype}'";
					$query .= aux::first_comma($commaId,", ")."'{$filetype}'";

					break;


					case "POSITION":

					#$query .= aux::first_comma("addItem".$this->name,", ")."'{$this->fields[$i]['value']}'";
					$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";

					$this->positions[$this->fields[$i]['name']]['index'] = $i;
					$this->positions[$this->fields[$i]['name']]['all'] = $_REQUEST["{$this->fields[$i]['name']}_all"];
					$this->positions[$this->fields[$i]['name']]['value'] = $this->fields[$i]['value'];

					break;

					case "PASSWORD":

					#$query .= aux::first_comma("addItem".$this->name,", ")."MD5('{$this->fields[$i]['value']}')";
					$query .= aux::first_comma($commaId,", ")."MD5('{$this->fields[$i]['value']}')";

					break;

					default:

					/* the following add a field for all the other cases, including the case WITH_OWNER
					where the username in the session is added */

					if (isset($this->fields[$i]['owner'])) {
						#$query .= aux::first_comma("addItem".$this->name,", ")."'{$_SESSION['user']['username']}'";
						$query .= aux::first_comma($commaId,", ")."'{$_SESSION['user']['username']}'";
					} else {
						$this->fields[$i]['value'] = htmlentities($this->fields[$i]['value']);
						#$query .= aux::first_comma("addItem".$this->name,", ")."'{$this->fields[$i]['value']}'";
						$query .= aux::first_comma($commaId,", ")."'{$this->fields[$i]['value']}'";

					}
					break;
				}
			}
		}
		
		$query .= ")";
		$oid = mysql_query($query);

		if (!$oid) {

			/*

			There was a problem in executing the query, the function is
			returning FALSE, the error will be handled by the wrapper (very
			likely is a duplicate_key error).

			*/
			
			return false;
		} else {
		
        	$_REQUEST['insertid'] = mysql_insert_id();
        	
        	$GLOBALS['logEntity']->insertItem(NULL, 
										  'ADD',
										  $this->name,
										  $_REQUEST['insertid'],
										  basename($_SERVER['SCRIPT_FILENAME']),
										  $_SESSION['user']['username'],
										  date("YmdHi"),
										  $_SERVER['HTTP_HOST']);

        	
										  
										  
			$GLOBALS['becontent']->clearCache(HTML_IMG);							  

			if (count($this->positions) > 0) {
				
				$insert_id = $_REQUEST['insertid'];
				
				foreach($this->positions as $position_key => $position_value) {

					$positions = explode(":", $position_value['all']);
					array_pop($positions);

					foreach($positions as $single_key => $single_value) {
						if ($single_value == 0) {
							
							/* there is a problem here ! */
							
							$id = $insert_id;
							
						} else {
							$id = $single_value;
						}
						$position = $single_key+1;

						$query = "UPDATE {$this->name} SET {$position_key} = {$position} WHERE {$this->fields[0]['name']} = '{$id}'";
						
						$oid = mysql_query($query);


						if (!$oid) {
							return false;
						}
					}
				}
				$this->addItem_postInsertion();
				return true; // specify better
			} else {
				$this->addItem_postInsertion();
				return true;
			}
		
								   	
		}
	}

	function noReferred() {

		return (count($this->referredBy) == 0);
	}

	
	function pre_delete() {}
	function post_delete() {}
	function post_delete_success() {}
	function post_delete_failure() {}
	
	function deleteItem() {
		
		$this->pre_delete();

		$deletable = false;

		if (count($this->referredBy) > 0) {

			$deletable = true;
			foreach($this->referredBy as $k => $v) {

				$currentEntity = $this->name;
				$referredEntity = $k;

				for($i=0; $i<count($v['entity']); $i++) { 

					$primaryKey = $this->fields[0]['name'];
					$foreignKey = $v['foreign key'][$i];



					 $oid = mysql_query("SELECT IF (T2.{$v['entity'][$i]->fields[0]['name']} IS NULL, '*','') AS referred
			      	                   FROM {$this->name} AS T1
                  	              LEFT JOIN {$k} AS T2
                     	                 ON T2.{$foreignKey} = T1.{$primaryKey}
                        	          WHERE T1.{$primaryKey} = '{$_REQUEST[$primaryKey]}'");
					
					/* $oid = mysql_query("SELECT IF ({$k}.{$v['entity'][$i]->fields[0]['name']} IS NULL, '*','') AS referred
			      	                   FROM {$this->name}
                  	              LEFT JOIN {$k} 
                     	                 ON {$k}.{$foreignKey} = {$this->name}.{$primaryKey}
                        	          WHERE {$this->name}.{$primaryKey} = '{$_REQUEST[$primaryKey]}'"); */

					if (!$oid) {
						
						echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_DELETION)." (".basename(__FILE__).":".__LINE__.")";
						exit;
					}

					$data = mysql_fetch_assoc($oid);

					if ($data['referred'] != "*") {
						$deletable = false;
					}
				}
			}

		} else {

			$deletable = true;

		}

		if ($deletable) {


			$index = false;
			foreach($_REQUEST as $k => $v) {
				if (ereg("reference", $k)) {
					$index = $k;
				}
			}

			if (($index != false) and ($_REQUEST[$index] != "")) {
				unlink("{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$index]}"); 
			}
			
			$query = "DELETE FROM {$this->name}
			          WHERE {$this->fields[0]['name']}='{$_REQUEST[$this->fields[0]['name']]}'";

			$oid = mysql_query($query);

			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_DELETION)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}


			/* here goes the code for deleting elements from the relation - but there is a problem
			to delete the information in the relation one has to know what are the relations ...

			*/

			if (count($this->relations)>0) {
				foreach($this->relations as $relation) {

					/* if ($this->standardKey) {
						$idName = "id_{$this->name}";
					} else {
						$idName = "username";
					}*/

					/*
					$query = "DELETE FROM {$relation->name} 
					                WHERE {$this->fields[0]['name']} = '{$_REQUEST[$this->fields[0]['name']]}'";
					*/
					
					/* 
					
						This may cause problems because the field to take into account depends on the
						form oreintation, at least I fear so.
						
					*/
					
					
					$query = "DELETE FROM {$relation->name} 
					                WHERE {$relation->fields[0]['name']} = '{$_REQUEST[$this->fields[0]['name']]}'";

					$oid = mysql_query($query);
					if (!$oid) {
						echo $query;
						echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
						exit;
					}

				}
			}

			$GLOBALS['logEntity']->insertItem(NULL, 
										  'DELETE',
										  $this->name,
										  $_REQUEST[$this->fields[0]['name']],
										  basename($_SERVER['SCRIPT_FILENAME']),
										  $_SESSION['user']['username'],
										  date("YmdHi"),
										  $_SERVER['HTTP_HOST']);
										  
			$GLOBALS['becontent']->clearCache(HTML_IMG);
										  
			$this->post_delete_success();
			
			
			return true;
		} else {
			
			$this->post_delete_failure();
			return false;
		}
	}

	/**
	 * This function returns the data contained in the entity according to the
	 * presentation given by setPresentation().
	 * 
	 * @param optional parameter BY_POSITION
	 * @return data contained in the entity as associative array
	 */

	function getPresentation() {
		
		$id1 = md5(microtime());
		$id2 = md5(microtime());
		
		$fields = "";
		$fieldsToConcat = "";
		
		/*if ($this->name == "users") {
			
			if (strpos($this->presentation[0], "%") === false) {
				echo "false";
			} else {
				echo strpos($this->presentation[0], "%");
			}
			
			exit;
		}*/
		
		if (strpos($this->presentation[0], "%") === false) {
			
			
			foreach($this->presentation as $value) {
				$fields .= aux::first_comma($id1,", ")."$value";
			
				foreach($this->fields as $k => $v) {
					if (($v['name'] == $value) and ($v['type'] == DATE)) {
						$value = "DATE_FORMAT({$value},'%d/%m/%Y')";
					}
				}
				$fieldsToConcat .= aux::first_comma($id2,",' ', ")."{$value}";
			}
			
		} else {
			
			
			
			$presentation = $this->presentation[0];
			
			$finito = false;
			do {
				$pos = strpos($presentation, "%");
				if ($pos !== false) {
					
					$value = substr($presentation, 0, $pos);
					
					$fieldsToConcat .= aux::first_comma($id2,",")."'{$value}'";
					$presentation = substr($presentation, $pos);
					
					
					ereg("^\%([[:alnum:]]*)", $presentation, $token);
					
					
					
					$fields .= aux::first_comma($id1,", ").$token[1];
					$fieldsToConcat .= aux::first_comma($id2,",")."{$token[1]}";
					
					$presentation = substr($presentation, strlen($token[1])+1);
					
				} else {
					$fieldsToConcat .= aux::first_comma($id2,",")."'{$presentation}'";
					$finito = true;
				}
				
				
				
			} while (!$finito);
			
			
			
			
			
		}
		
		$result['fields'] = $fields;
		$result['fieldsToConcat'] = $fieldsToConcat;
		
		/*if ($this->name == "users") {
			print_r($result); exit;
		}*/
		return $result;
	
	}
	
	
	function getReferenceWithCondition($condition = "true") {


		$presentation = $this->getPresentation();
		$fields = $presentation['fields'];
		$fieldsToConcat = $presentation['fieldsToConcat'];

		if ($this->owner) {

			$query = "SELECT {$this->fields[0]['name']} AS value,
	      	           	  CONCAT({$fieldsToConcat}) AS text 
	      	         FROM {$this->name}
		              WHERE username = '{$_SESSION['user']['username']}' AND {$condition}
		           ORDER BY {$fields}";

		} else {

			$query = "SELECT {$this->fields[0]['name']} AS value,
		     	           	  CONCAT({$fieldsToConcat}) AS text 
	                  FROM {$this->name}
	                 WHERE $condition
	            ORDER BY {$fields}";
		}

		$oid = mysql_query($query);
		if (!$oid) {
			
			#echo $query; exit;
			
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$content = array();
		do {
			$data = mysql_fetch_assoc($oid);
			if ($data) {
				$content[] = $data;
			}
		} while ($data);

		return $content;

	}
	
	function getReferenceByRelation($filter, $method = "") {
		
		#echo "getReferenceByRelation ";
		#echo $filter['relation']->name;
		
		
		
		/*
		$id1 = md5(microtime());
		$id2 = md5(microtime());
		#echo $id1,"<br>$id2";

		$fields = "";
		$fieldsToConcat = "";

		foreach($this->presentation as $value) {
			$fields .= aux::first_comma($id1,", ")."$value";
			
			foreach($this->fields as $k => $v) {
				if (($v['name'] == $value) and ($v['type'] == DATE)) {
					$value = "DATE_FORMAT({$value},'%d/%m/%Y')";
				}
			}
			$fieldsToConcat .= aux::first_comma($id2,",' ', ")."$value";
		}

		#echo $fields;exit; */

		
		$presentation = $this->getPresentation();
		$fields = $presentation['fields'];
		$fieldsToConcat = $presentation['fieldsToConcat'];
		
		switch ($method) {
			case BY_POSITION:
			$args = func_get_args();
			$query = "SELECT {$this->fields[0]['name']} AS value,
		                 	  CONCAT({$fieldsToConcat}) AS text,
		        	         	  '{$this->fields[0]['name']}' AS primarykey 
		               FROM {$this->name}
		           ORDER BY {$args[1]}";

			break;
			case "all":
			$query = "SELECT {$this->fields[0]['name']} AS value,
		                 	  CONCAT({$fieldsToConcat}) AS text,
		        	         	  '{$this->fields[0]['name']}' AS primarykey 
		               FROM {$this->name}
		           ORDER BY {$fields}";
			break;
			default:

		
			
				
				if ($this->owner) {
					
					switch($filter['mode']) {
						case PRESENT:
				
					     $query = "SELECT DISTINCT {$this->name}.{$this->fields[0]['name']} AS value,
		      	    	             	  CONCAT({$fieldsToConcat}) AS text,
		        	         	  '{$this->fields[0]['name']}' AS primarykey 
		                	         FROM {$this->name}
		               	        LEFT JOIN {$filter['relation']->name}
		               	               ON {$filter['relation']->fields[0]['name']} = {$this->name}.{$this->fields[0]['name']}
		                            WHERE username = '{$_SESSION['user']['username']}' 
		                 	          AND {$filter['relation']->name}.{$filter['relation']->fields[0]['name']} IS NOT NULL 
		              	         ORDER BY {$fields}";

				
					    break;
					}

				} else {
					
					

					$query = "SELECT {$this->fields[0]['name']} AS value,
			      	           	  CONCAT({$fieldsToConcat}) AS text,
		        	         	  '{$this->fields[0]['name']}' AS primarykey 
		    	              FROM {$this->name}
		        	      ORDER BY {$fields}";
				}
			
			break;
		}

		$oid = mysql_query($query);
		if (!$oid) {
			
			
			
			
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$content = array();
		do {
			$data = mysql_fetch_assoc($oid);
			if ($data) {
				$content[] = $data;
			}
		} while ($data);

		return $content;
		
	}
	
	function getReference($method = "") {
		
		
		
		/*$id1 = md5(microtime());
		$id2 = md5(microtime());

		$fields = "";
		$fieldsToConcat = "";
		
		foreach($this->presentation as $value) {
			$fields .= aux::first_comma($id1,", ")."$value";
			
			foreach($this->fields as $k => $v) {
				if (($v['name'] == $value) and ($v['type'] == DATE)) {
					$value = "DATE_FORMAT({$value},'%d/%m/%Y')";
				} elseif (($v['name'] == $value) and ($v['type'] == LONGDATE)) {
					$value = "DATE_FORMAT({$value},'%d/%m/%Y %H:%i')";
				}
			}
			$fieldsToConcat .= aux::first_comma($id2,",' ', ")."$value";
		} */
		
		
		$presentation = $this->getPresentation();
		$fields = $presentation['fields'];
		$fieldsToConcat = $presentation['fieldsToConcat'];
		

		$trovato = false;
		
		if (count($this->referredBy) > 0) {
			foreach($this->referredBy as $k => $v) {
				if ($k == $this->name) {
					$trovato = true;
					$reference = $this->referredBy[$k]['foreign key'][0];
					$reference_field = ", {$reference} AS reference ";
				}
			}	
		}
		
		#echo $method;
		
		switch ($method) {
			case BY_POSITION:
				
				$args = func_get_args();
			
				if (($this->owner) and (!$_SESSION['user']['admin'])) {
					$first_case = "AND username = '{$_SESSION['user']['username']}'";
					$second_case = "WHERE username = '{$_SESSION['user']['username']}'";
					
				} else {
					$first_case = "";
					$second_case = "";
				}
				
				if (isset($args[2])) {
					$query = "SELECT {$this->fields[0]['name']} AS value,
		        		         	  CONCAT({$fieldsToConcat}) AS text {$reference_field},
		        	    	     	  '{$this->fields[0]['name']}' AS primarykey
		            	   		FROM {$this->name}
		            	  	   WHERE $args[2] {$first_case}
		           	        ORDER BY {$args[1]}";
				
				} else { 
					
					#echo "{$this->name} {$second_case}";
			
					$query = "SELECT {$this->fields[0]['name']} AS value,
		        	            	 CONCAT({$fieldsToConcat}) AS text {$reference_field},
		        	         	     '{$this->fields[0]['name']}' AS primarykey
		            	        FROM {$this->name}
		            	        	 {$second_case}
		           	        ORDER BY {$args[1]}";
				}
			
				
			
			break;
			
			case "all":
				
				
				
				if (($this->owner) and (!$_SESSION['user']['admin'])) {
					$case = "WHERE username = '{$_SESSION['user']['username']}'";
				} else {
					$case = "";
				}
				
				$query = "SELECT {$this->fields[0]['name']} AS value,
		                     	 CONCAT({$fieldsToConcat}) AS text {$reference_field},
		        	             '{$this->fields[0]['name']}' AS primarykey
		                    FROM {$this->name}
		                         {$case}
		                ORDER BY {$fields}";
			break;
			
			case LIMIT:
				
				
				
				$args = func_get_args();
				
				
				
				$startIndex = $args[1];
				$endIndex = $args[2];
				
				if (count($args) > 3) {
					$condition = $args[3];
				} else {
					$condition = "true";
				}
				
				if ($this->referenceOrder == true) {
					$fields = $this->referenceOrder;
				} else {
					$fields = "text";
				}
				
				if ($this->owner) {
					
					/* The entity is a WITH_OWNER entity */
					
					
					if (in_array(ADMIN, $_SESSION['user']['groups'])) {
						
						/* ADMIN: the amdinistrators have the complete visibility */
						
						
						$query = "
							SELECT {$this->fields[0]['name']} AS value,
		      	    	       	   CONCAT({$fieldsToConcat}) AS text {$reference_field},
		      	    	       	   username AS owner,
		      	    	       	   lastmodified,
		        	         	   '{$this->fields[0]['name']}' AS primarykey
		                	  FROM {$this->name}
		                 	 WHERE {$condition} 
		              	  ORDER BY {$fields} LIMIT {$startIndex}, {$endIndex}";
						
						
					} else {
						/* 
						
							Here it will be checked whether the user is in the SUPERUSER GROUP for this
							specific service
						
						*/
						
						
						$superuser_group = $_SESSION['user']['services'][basename($_SERVER['SCRIPT_FILENAME'])]['superuser_group'];
						
						if (in_array($superuser_group, $_SESSION['user']['groups'])) {
						
							/* SUPERUSER_GROUP : the user has complete visibility */
							
							$query = "SELECT {$this->fields[0]['name']} AS value,
		      	    	       	             CONCAT({$fieldsToConcat}) AS text {$reference_field},
		      	    	       	             username AS owner,
		      	    	       	             lastmodified,
		        	         	             '{$this->fields[0]['name']}' AS primarykey
		                	            FROM {$this->name}
		                 	           WHERE {$condition} 
		              	            ORDER BY {$fields} LIMIT {$startIndex}, {$endIndex}";
							
							
						} else {
							
							/* FILTERED */
							
							$query = "SELECT {$this->fields[0]['name']} AS value,
		      	    	       		         CONCAT({$fieldsToConcat}) AS text {$reference_field},
		      	    	       	    	     username AS owner,
		      	    	       	     	     lastmodified,
		        	         	           	 '{$this->fields[0]['name']}' AS primarykey
		                		        FROM {$this->name}
		                 	           WHERE username = '{$_SESSION['user']['username']}' 
		                     	         AND {$condition}
		              	           	ORDER BY {$fields} LIMIT {$startIndex}, {$endIndex}";
								
						}			
					}

				} else {
					
					
						
					$query = "
						SELECT {$this->fields[0]['name']} AS value,
			      	           CONCAT({$fieldsToConcat}) AS text {$reference_field},
		       	         	   '{$this->fields[0]['name']}' AS primarykey
		    	          FROM {$this->name}
		    	         WHERE {$condition}
	    	          ORDER BY {$fields} LIMIT {$startIndex}, {$endIndex}";						
			
				}
				
				
				
			
			break;
			
			case COUNT:
				
				
				
				if (count($args) > 1) {
					$condition = $args[1];
				} else {
					$condition = "true";
				}
				
				
				if ($this->owner) {
					
					/* The entity is a WITH_OWNER entity */
					
					
					
					if (in_array(ADMIN, $_SESSION['user']['groups'])) {
						
						/* ADMIN: the amdinistrators have the complete visibility */
						
						
						$query = "
							SELECT COUNT(*) as count
		                	  FROM {$this->name}
		                 	 WHERE {$condition}";
						
						
					} else {
						/* 
						
							Here it will be checked whether the user is in the SUPERUSER GROUP for this
							specific service
						
						*/
						
						
						$superuser_group = $_SESSION['user']['services'][basename($_SERVER['SCRIPT_FILENAME'])]['superuser_group'];
						
						if (in_array($superuser_group, $_SESSION['user']['groups'])) {
						
							/* SUPERUSER_GROUP : the user has complete visibility */
							
							$query = "SELECT COUNT(*) as count
		                	            FROM {$this->name}
		                 	           WHERE {$condition}";
							
							
						} else {
							
							/* FILTERED */
							
							$query = "SELECT COUNT(*) as count
		                		        FROM {$this->name}
		                 	           WHERE username = '{$_SESSION['user']['username']}' 
		                     	         AND {$condition}";
								
						}			
					}

				} else {
					
					
						
					$query = "
						SELECT COUNT(*) as count
		    	          FROM {$this->name}
		    	         WHERE {$condition}";						
			
				}
				
				
				
				break;
			
			case NORMAL:
			default:
				
				
				
				if (count($args) > 1) {
					$condition = $args[1];
				} else {
					$condition = "true";
				}
				
				if ($GLOBALS['becontent']->entities[$this->name]->referenceOrder == true) {
					
					#echo "|", $GLOBALS['becontent']->entities[$this->name]->referenceOrder, "|";
					$fields = $this->referenceOrder;
				} else {
					$fields = "text";
				}
				
				if ($this->owner) {
					
					/* The entity is a WITH_OWNER entity */
					
					$fields = "creation";
					
					if (in_array(ADMIN, $_SESSION['user']['groups'])) {
						
						/* ADMIN: the amdinistrators have the complete visibility */
						
						
						$query = "
							SELECT {$this->fields[0]['name']} AS value,
		      	    	       	   CONCAT({$fieldsToConcat}, '') AS text {$reference_field},
		      	    	       	   username AS owner,
		      	    	       	   lastmodified,
		        	         	   '{$this->fields[0]['name']}' AS primarykey
		                	  FROM {$this->name}
		                 	 WHERE {$condition}
		              	  ORDER BY {$fields}";
						
						
					} else {
						/* 
						
							Here it will be checked whether the user is in the SUPERUSER GROUP for this
							specific service
						
						*/
						
						
						$superuser_group = $_SESSION['user']['services'][basename($_SERVER['SCRIPT_FILENAME'])]['superuser_group'];
						
						if (in_array($superuser_group, $_SESSION['user']['groups'])) {
						
							/* SUPERUSER_GROUP : the user has complete visibility */
							
							$query = "SELECT {$this->fields[0]['name']} AS value,
		      	    	       	             CONCAT({$fieldsToConcat}) AS text {$reference_field},
		      	    	       	             username AS owner,
		      	    	       	             lastmodified,
		        	         	             '{$this->fields[0]['name']}' AS primarykey
		                	            FROM {$this->name}
		                 	           WHERE {$condition}
		              	            ORDER BY {$fields}";
							
							
						} else {
							
							/* FILTERED */
							
							$query = "SELECT {$this->fields[0]['name']} AS value,
		      	    	       		         CONCAT({$fieldsToConcat}) AS text {$reference_field},
		      	    	       	    	     username AS owner,
		      	    	       	     	     lastmodified,
		        	         	           	 '{$this->fields[0]['name']}' AS primarykey
		                		        FROM {$this->name}
		                 	           WHERE username = '{$_SESSION['user']['username']}' 
		                     	         AND {$condition}
		              	           	ORDER BY {$fields}";
								
						}			
					}

				} else {
					
				
					$query = "
						SELECT {$this->fields[0]['name']} AS value,
			      	           CONCAT({$fieldsToConcat}) AS text {$reference_field},
		       	         	   '{$this->fields[0]['name']}' AS primarykey
		    	          FROM {$this->name}
		    	         WHERE {$condition}
	    	          ORDER BY {$fields}";	
				}
					
			break;
		}

		#echo $query;

		
		$oid = mysql_query($query);
		if (!$oid) {

			echo "** ", $query; 
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$content = array();
		do {
			$data = mysql_fetch_assoc($oid);
			if ($data) {
				$content[] = $data;
			}
		} while ($data);
		
		if ($method == COUNT) {
			
			/* it returns the total number of rows */
			
			return $content[0]['count'];
		} else {
			
			/* it returns the rows */
			
			return $content;
		}
	}



	function insertItem2() {

		$args = func_get_args();
		$count = count($args);

		$query = "INSERT INTO {$this->name} VALUES(";

		for($i=0;$i<$count;$i++) {
			$query .= "'".func_get_arg($i)."'";
			if ($i < $count - 1) {
				$query .= ",";
			}
		}

		$query .= ")";

		$oid = mysql_query($query);
		if (!$oid) {

			if (mysql_errno() != "1062") {
				
				if (mysql_errno() == "1136") {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_INIT)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}
					
				} else {

					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
					exit;
			}
		}


	}
	
	
	function insertItem() {
		$id = md5(uniqid(time()));
		
		$query = "INSERT INTO {$this->name} VALUES(";
		$args = func_get_args();
		
		if (is_array($args[0])) {
		
			foreach($this->fields as $k => $field) {
				switch($field['type']) {
					case FILE:
						$query .= aux::first_comma("{$id}", ", ")."'{$args[0][$field['name']]}'";
						$query .= aux::first_comma("{$id}", ", ")."'".$args[0][$field['name']."_filename"]."'";
						$query .= aux::first_comma("{$id}", ", ")."'".$args[0][$field['name']."_size"]."'";
						$query .= aux::first_comma("{$id}", ", ")."'".$args[0][$field['name']."_type"]."'";
						
					break;
					default:
						$query .= aux::first_comma("{$id}", ", ")."'{$args[0][$field['name']]}'";
					break;
				}
				
				
			}
			 
		} else {
			
			foreach($args as $k => $field) {
				
				$query .= aux::first_comma("{$id}", ", ")."'{$field}'";
				
			}
			
		}
		
		$query .= ")";
		
		$oid = mysql_query($query);
		if (!$oid) {

			if (mysql_errno() != "1062") {
				
				if (mysql_errno() == "1136") {
					
					
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_INIT)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}
					
				} else {
					
				

					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
					exit;
			}
		}  

	}
	
	function addRssFilter($filter) {
		$this->rssFilter = $filter;
	}
	
	// Inizializza le proprieta per la gestione degli rss
	function addRss($channel,$parametri)
	{		
		$this->channel=new Relation($this,$channel);
		$this->channel->connect();	
			
		$this->rss=true;
		$this->rssPresentation=$GLOBALS['aux']->parsePars($parametri);
		$oid=mysql_query("SELECT modality FROM bc_rss_mod WHERE entity=\"{$this->name}\"");
		if($oid)
			if(mysql_num_rows($oid)==0)
				$GLOBALS['rssMod']->insertItem($this->name,"MOD1");
		
		if($this->owner)
		{
			$this->rssPresentation['pubDate']='creation';
			$this->rssPresentation['author']='username';
		}
		
		$x=0;
		while ($x<count($GLOBALS['becontent']->entities)) {
			if (isset($GLOBALS['becontent']->entities[$x])) {
				if ($GLOBALS['becontent']->entities[$x]->name == $this->name) {
				
					$GLOBALS['becontent']->entities[$x]->rssPresentation=$this->rssPresentation;
					$GLOBALS['becontent']->entities[$x]->rss=$this->rss;
			
				}
			}
			$x++;
	
		}
	}

}


Class ModeratedEntity extends Entity {

	function ModeratedEntity($database, $name, $owner = "") {
		Entity::Entity($database,$name,$owner);

		$this->addField("passed", VARCHAR, 1);
	}

	function addItem_postInsertion() {

		$script = basename($_SERVER['SCRIPT_FILENAME']);
		if (ereg("([[:alnum:]]*)\-manager", $script, $token)) {
			$entityName = $token[1];
		}
		$content_id = mysql_insert_id();

		$oid = mysql_query("SELECT users.username
                            FROM users                      
                      RIGHT JOIN users_groups
                              ON users_groups.username = users.username
                      RIGHT JOIN entities
                              ON entities.priviledged_group = users_groups.id_groups
                             AND entities.priviledged_group = users_groups.id_groups
                           WHERE users.username = '{$_SESSION['user']['username']}'
                             AND entities.name = '$entityName'");


		if (!$oid) {



			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		if (mysql_num_rows($oid) != 0) {

			/*

			the logged user is "priviledged", no need to moderate his/her contents!

			*/


			$entity = $GLOBALS['database']->getEntityByName($entityName);

			$oid = mysql_query("UPDATE {$entityName} SET passed='*' WHERE {$entity->fields[0]['name']}='{$content_id}'");
			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}
		} else {

			/*

			the logged user is not "priviledged", it is necessary to contact all moderators!

			*/



			$oid = mysql_query("SELECT * FROM entities WHERE name='{$entityName}'");
			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}
			$data = mysql_fetch_assoc($oid);

			$author = "{$_SESSION['user']['name']} {$_SESSION['user']['surname']} <{$_SESSION['user']['email']}>";
			$content = $data['content_name'];
			$script = "{$script}?action=validate&page=1&value={$content_id}";

			$oid = mysql_query("SELECT users.name, users.surname, users.email
			                      FROM users 
			                 LEFT JOIN users_groups
			                        ON users_groups.username = users.username
			                     WHERE users_groups.id_groups = {$data['moderator_group']}");

			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}

			do {
				$data = mysql_fetch_array($oid);
				if ($data) {
					$mail = new Template("dtml/mail_moderation_validate.html");
					$mail->setContent("author", $author);
					$mail->setContent("content", $content);
					$mail->setContent("script", $script);

					$mail->setContent("name", $data['name']);
					
					mail($data['email'],"[model-transformation.org] new content to moderate",$mail->get(), "{$_SESSION['user']['email']}");
					
					


				}
			} while ($data);
		}
	}
}



Class Relation extends Entity {
	var
	$entity_1,
	$entity_2;

	function Relation(&$entity_1, &$entity_2, $name = "") {

		$this->entity_1 = $entity_1;
		$this->entity_2 = $entity_2;

		if (!$this->entity_1->name) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_UNKNOWN_ENTITY)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		if ($name != "") {
			$this->Entity($GLOBALS['database'],"{$name}");
		} else {
			$this->Entity($GLOBALS['database'],"{$this->entity_1->name}_{$this->entity_2->name}");
		}

		/*
		
			Relations do not have any primary key.
		
		*/

		$this->noKey();

		if ($this->entity_1->standardKey) {
			$this->addField("id_{$this->entity_1->name}", INT);
		} else {

			$this->addField($this->entity_1->fields[0]['name'], 
			$this->entity_1->fields[0]['type'],
			$this->entity_1->fields[0]['length']);
			
		}

		if ($this->entity_2->standardKey) {
			$this->addField("id_{$this->entity_2->name}", INT);
		} else {
			$this->addField($this->entity_2->fields[0]['name'],
			$this->entity_2->fields[0]['type'],
			$this->entity_2->fields[0]['length']);
		}

		$entity_1->relations[] = $this;
		$entity_2->relations[] = $this;

	}
}

/* **********************************************************************

FORM

********************************************************************** */


Class Form {
	var
		$labels,
		$name,
		/* $mainTable, -- let's discard it, it seems it has been not used */
		$helpers,
		$relations,
		$method,
		$enctype,
		$elements,
		$conditions,
		$entity,
		$withPosition,
		$positions,
		$noDelete,
		$triggered,
		$triggeredForm,
		$triggeredForms,
		$relationManager,
		$templatePath,
		$moderationMode,
		$description,
		$mainFormEntity,		//utilizzato per la gestione Rss
		$filterRelation,
		$relationData,			// used to persist data inserted in N-M relations
		
		$reportTemplate,  		// These are to customize liveReport behaviour
		$reportQuery,
		
		$pager,
		$lastid;		  		// The pager is used to customize the report functionality

	function Form($name, $entity, $method = "GET") {


		/* can the name of the form be given in an automated way,
		using maybe an identified which is generated from the
		timestamp ? */

		$this->name = $name;
		$this->method = $method;

		/* this is used to control the visibility of the "delete" button
		in the form while the EDIT mode */

		$this->noDelete = false;

		/* this is used to denote that the form has a POSITION widget type */

		$this->withPosition = false;

		/* the following denotes that the current form will be
		triggered by some other form, the invoking form is referred
		in triggerForm */

		$this->triggered = false;
		$this->triggeredForm = false;
		$this->triggeredForms = false;
		$this->moderationMode = false;

		/* the following is the DTML template path */

		$this->templatePath = "dtml";

		$this->labels[ADD] = "Aggiungi";
		$this->labels[EDIT] = "Modifica";
		$this->labels[DELETE] = "Rimuovi";
		$this->labels['MSG_SURE'] = "Sei sicuro";
		$this->labels['MSG_UPDATE'] = "The item has been correctly updated!";

		$this->entity = $entity;


		$content_js = "<script language=\"JavaScript\" src=\"js/calendar.js\"></script>\n";
		$content_js .= "<script language=\"JavaScript\" src=\"js/position.js\"></script>\n";
		$content_js .= "<script src=\"js/plugin_colorpicker.js\" type=\"text/JavaScript\"></script>\n";
		$content_js .= "<script language=\"JavaScript\" src=\"js/ajax-decode-2.js\"></script>\n";

		$content_style = "<LINK REL=STYLESHEET HREF=\"css/calendar.css\" TYPE=\"text/css\">\n";
		$content_style .= "<link href=\"css/plugin_colorpicker.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
 	
 		 
		
		$GLOBALS['main']->setContentOnce("javascript","{$content_js}");
		$GLOBALS['main']->setContentOnce("style",$content_style);
 		
		/* RSS enabled entities management */
		
		if ($this->entity->rss) {
			
			$new_form=new Form("Channel-gestion",$this->entity->channel);
			$new_form->mainFormEntity=$this->entity;
			$new_form->addRelationManager("bc_channel",'<img src="img/rss/rss.gif" />');
			$this->triggers($new_form);
			
		}
		
		
		$this->reportTemplate = "dtml/report.html";
		$this->reportQuery = "";
		
		
		$GLOBALS['currentform'] = &$this;

	}

	function triggers(&$form) {

		if (version_compare(phpversion(),"5.0", "<")) {
			$relationName = "relation";
		} else {
			$relationName = "Relation";
		}
		
		if (get_class($form->entity) != $relationName) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_TRIGGERS)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$this->triggeredForm = &$form;
		$this->triggeredForms[] = &$form;

		$form->triggered = true;

	}

	function setModerationMode() {
		$this->moderationMode = true;
	}

	function addHelper($field,$text) {
		$this->helpers[$field] = $text;
	}


	function addValidation($el_1, $el_2, $condition, $message = "") {
		
		
		foreach($this->elements as $k => $v) {
			if ($v['name'] == $el_1) {
				$label_1 = $v['label'];
				$obj_1 = $v;
			}
			
			if ($v['name'] == $el_2) {
				$label_2 = $v['label'];
				$obj_2 = $v;
			}
		}

		$this->conditions[] = array("element_1" => $el_1,
		"element_2" => $el_2,
		"label_1" => $label_1,
		"label_2" => $label_2,
		"obj_1" => $obj_1,
		"obj_2" => $obj_2,
		"condition" => $condition,
		"message" => $message);

	}

	function setFilterByExtension($name, $extension, $message = "") {
		

		foreach($this->elements as $k => $v) {
			if ($v['name'] == $name) {
				$this->elements[$k]['filterByExtension'] = $extension;
				$this->elements[$k]['message'] = $message;
			}
		}
		
	}
	
	
	
	function setSubmitString($name) {

		$this->labels["add"] = $name;
	}
	
	function setLabel($operation, $label) {
		$this->labels[$operation] = $label;
	}

	function addSection($name, $text = "") {

		$this->elements[] = array(
			"type" => "section", 
			"name" => $name,
			"text" => $text
			);
	}
	
	function addDescription($text) {
		$this->description = $text;
	}

	function addHidden($name, $value) { 
		
		$this->elements[] = array("name" => $name,
			"type" => HIDDEN,
			"value" => $value
		);
		
	}
	
	function addText($name, $label, $size = "20", $mandatory = "off", $maxlength = "") {
		
		$this->elements[] = array("name" => $name,
			"type" => "text",
			"label" => $label,
			"size" => $size,
			"mandatory" => $mandatory,
			"maxlength" => $maxlength
		);
		
		
		#$this->elements[] = new Text($name, $label, $size, )
		

	}
	
	function addLink($name,
	$label,
	$size = "20",
	$mandatory = "off",
	$maxlength = "") {

		$this->elements[] = array("name" => $name,
		"type" => "link",
		"label" => $label,
		"size" => $size,
		"mandatory" => $mandatory,
		"maxlength" => $maxlength
		);
		
		

	}

	function addPassword($name,
	$label,
	$size = "20",
	$mandatory = "off",
	$maxlength = "") {

		$this->elements[] = array("name" => $name,
		"type" => "password",
		"label" => $label,
		"size" => $size,
		"mandatory" => $mandatory,
		"maxlength" => $maxlength
		);
		
		$this->method = POST;

	}
	
	function addPosition($name, $label, $controlledField, $size = "8", $mandatory = "off") {

		$this->elements[] = array("name" => $name,
		"controlledField" => $controlledField,
		"type" => "position",
		"label" => $label,
		"size" => $size,
		"mandatory" => $mandatory
		);
		$this->withPosition = true;
		$this->positions[] = count($this->elements) - 1;

	}
	
	
	function addHierarchicalPosition($name, $label, $controlledField, $referenceField, $size = "8") {

		
		foreach($this->elements as $k=>$v) {
			if ($v['name'] == $referenceField) {
				$reference_index = $k;	
			}
		}
		
		
		$this->elements[] = array(
			"name" => $name,
			"controlledField" => $controlledField,
			"type" => "hierarchicalPosition",
			"label" => $label,
			"size" => $size,
			"referenceField" => $referenceField,
			"reference_index" => $reference_index,
			"size" => $size
		);
		
		$this->withPosition = true;
		$this->positions[] = count($this->elements) - 1;
		
	}




	function addColor($name, $label, $preset = 'FFFFFF') {

		$this->elements[] = array("name" => $name,
		"type" => "color",
		"label" => $label,
		"size" => "7",
		"mandatory" => MANDATORY,
		"maxlength" => "7",
		"preset" => $preset
		);

	}

	function addRadio($name,
	$label) {

		$values = func_get_args();

		$this->elements[] = array("name" => $name,
		"type" => "radio",
		"label" => $label,
		"values" => $values
		);

	}

	function addDate($name, $label, $mandatory = "off") {

		$this->elements[] = array("name" => $name,
		"type" => "date",
		"mandatory" => $mandatory,
		"label" => $label
		);
	}
	
	
	function addLongDate($name,$label, $mandatory = "off") {

		$this->elements[] = array("name" => $name,
		"type" => LONGDATE,
		"mandatory" => $mandatory,
		"label" => $label
		);
	}

	function addFile($name,$label,$mandatory = "off") {

		$this->elements[] = array("name" => $name,
			"type" => FILE,
			"label" => $label,
			"mandatory" => $mandatory
		);

		$this->method = "POST";
		$this->enctype = "enctype=\"multipart/form-data\"";
	}
	
	function addFileToFolder($name,$label,$mandatory = "off") {

		$this->elements[] = array("name" => $name,
			"type" => FILE2FOLDER,
			"label" => $label,
			"mandatory" => $mandatory
		);

		$this->method = "POST";
		$this->enctype = "enctype=\"multipart/form-data\"";
	}
	
	function addImage($name,$label,$mandatory = "off") {

		$this->elements[] = array("name" => $name,
			"type" => "image",
			"label" => $label,
			"mandatory" => $mandatory,
			"thumb_size" => "100",
		);

		$this->method = "POST";
		$this->enctype = "enctype=\"multipart/form-data\"";
	}

	function addselect2($name,
	$label) {

		$values = func_get_args();

		if (gettype($values[2]) == "string") {

			if (($values[count($values)-1] == strtolower("yes")) or ($values[count($values)-1] == strtolower("no"))) {
				$mandatory = $values[count($values)-1];
				unset($values[count($values)-1]);
			}

			$this->elements[] = array("name" => $name,
			"type" => "select",
			"label" => $label,
			"values" => $values,
			"mandatory" => $mandatory
			);
		} else {

		}
	}
	
	function addSelect($name, $label, $values, $mandatory = "no") {
		
		/* SYNTAX : */
		
		$this->elements[] = array(
			"name" => $name,
			"type" => "select",
			"label" => $label,
			"values" => $values,
			"mandatory" => $mandatory
		);
	}
	
	function addYear($name, $label, $start = -15, $end = 1) {
		
		$year = date("Y");
		
		$values = "";
		
		for($y=$year+$start; $y<=$year+$end; $y++) {
			if ($y == $year) {
				$values .= aux::first_comma($name,",")."${y}:{$y}:CHECKED"; 
			} else {
				$values .= aux::first_comma($name,",")."{$y}:${y}"; 
			}
		}
		
		$this->addSelect($name, $label, $values);
		
	}

	function addSelectFromReference(&$entity, $label , $mandatory = "no") {

		$this->elements[] = array("name" => "id_".$entity->name,
		"type" => "selectFromReference",
		"label" => $label,
		"entity" => $entity,
		"mandatory" => $mandatory
		);
	}


	function addSelectFromReference2($entity, $name, $label , $mandatory = "no") {

		

		$this->elements[] = array("name" => $name,
		"type" => "selectFromReference",
		"label" => $label,
		"entity" => $entity,
		"entity_name" => $entity->name, 
		"mandatory" => $mandatory
		);
	}
	
	function addSelfReferenceManager($name, $label , $position_field) {


		$this->elements[] = array("name" => $name,
		"type" => "SelfReferenceManager",
		"label" => $label,
		"entity" => $this->entity,
		"position_field" => $position_field
		);
	}

	function addRadioFromReference($entity, $name, $label , $mandatory = "no") {


		$this->elements[] = array("name" => $name,
		"type" => RADIO_FROM_REFERENCE,
		"label" => $label,
		"entity" => $entity,
		"mandatory" => $mandatory
		);
	}

	function restrictReference($name, $condition = "true") {

		$i=0;
		$trovato = false;

		while (($i<count($this->elements)) and (!$trovato)) {

			if ($this->elements[$i]['name'] == $name) {
				$trovato = true;
				$this->elements[$i]['condition'] = $condition;
			}

			$i++;
		}

	}

	function addCheck($label) {

		$values = func_get_args();

		$this->elements[] = array("type" => CHECKBOX,
		"label" => $label,
		"values" => $values
		);

	}

	function addTextarea($name,$label, $rows, $cols, $mandatory = "no") {

		$this->elements[] = array("name" => $name,
		"type" => "textarea",
		"label" => $label,
		"rows" => $rows,
		"cols" => $cols,
		"mandatory" => $mandatory
		);
		
		$this->method = POST;
	}

	function addEditor($name,$label, $rows, $cols, $mandatory = "no") {

		$this->elements[] = array("name" => $name,
		"type" => "editor",
		"label" => $label,
		"rows" => $rows,
		"cols" => $cols,
		"mandatory" => $mandatory
		);


		$this->method = POST;

	}
	function addRelationManager2($name, $label, $orientation = RIGHT) {

		if (get_class($this->entity) != "relation") {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_RELATION_MANAGER)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$this->elements[] = array("name" => $name,
		"label" => $label,
		"type" => "relation manager2",
		"orientation" => $orientation,
		"mandatory" => "no",
		"condition" => true
		);

		$this->relationManager = count($this->elements)-1;

	}

	function addRelationManager($name, $label, $orientation = RIGHT) {

		
		if (version_compare(phpversion(),"5.0", "<")) {
			$relationName = "relation";
		} else {
			$relationName = "Relation";
		}
		
		if (get_class($this->entity) != $relationName) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_RELATION_MANAGER)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		$this->elements[] = array("name" => $name,
		"label" => $label,
		"type" => RELATION_MANAGER,
		"orientation" => $orientation,
		"mandatory" => "no",
		"condition" => true
		);

		$this->relationManager = count($this->elements)-1;

	}
	
	function setMandatory($name) {
		
		foreach($this->elements as $k =>$v) {
			if ($v['name'] == $name) {
				$this->elements[$k]['mandatory'] = "yes";
			}
		}
		
	}

	function filterByRelation($relation, $mode = PRESENT) {

		$this->filterRelation['relation'] = $relation;
		$this->filterRelation['mode'] = $mode;
 		
	}
	
	
	
	function addFilter($name, $condition = true) {
		
		foreach($this->elements as $k => $value) {
			if ($value['name'] == $name) {
				$index = $k;
			}
		}
		
		$this->elements[$index]['condition'] = $condition;
		
	}

	function getElementByName($name) {

		$result = false;
		foreach($this->elements as $value) {
			if ($value['name'] == $name) {
				$result = $value;
			}
		}
		return $result;
	}

	/* Transaction */

	function addItem() {

		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		
		
		switch ($page) {
			case 0:
				/* EMIT FORM */

				$this->addItem_preEmitForm();
				$content = $this->display(ADD,1);
				$this->addItem_postEmitForm();

			break;
			case 1:

				/* INSERTION */

				$this->addItem_preInsertion();

				$entity = $this->entity;

				//ADD ITEM ALTERNATIVO
			
				$temp = $this->addItem_sub();
			
				if	(!isset($temp)) 			
			
					$temp=$entity->addItem();
				
					if (!$temp) {

						if ($entity->reload) {
							$GLOBALS['main']->setContent("message",
							$GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELOAD));
							$content = $this->display(ADD,1);
						} else {
						
							$error = mysql_errno();
							if ($error == 1062) {
								$GLOBALS['main']->setContent("message",
								$GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_DUPLICATE_KEY));
								$content = $this->display(ADD,1,PRELOAD);
							} else {

								echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
								echo "<hr>", $error, mysql_error();
								exit;
							}
						}

				} else {
				
					if ($this->entity->standardKey) {
						$id = $_REQUEST['insertid'];
					} else {
						$id = $_REQUEST["{$this->entity->fields[0]['name']}"];
					}
				
					$this->lastid = $id;

					if ((count($this->triggeredForms) > 0) and ($this->triggeredForms != "")) {
				
						foreach($this->triggeredForms as $k => $form) {
						
							foreach($_REQUEST as $key=>$value) {
	
								if (ereg("{$form->elements[0]['name']}_",$key)) {
	
									switch ($form->elements[0]['orientation']) {
										case RIGHT:
											$query = "INSERT INTO {$form->entity->name} VALUES('{$id}','{$_REQUEST[$key]}')";
											$par[0] = $id;
											$par[1] = $_REQUEST[$key];
											break;
										
										case LEFT:
											$query = "INSERT INTO {$form->entity->name} VALUES('{$_REQUEST[$key]}','{$id}')";
											$par[0] = $_REQUEST[$key];
											$par[1] = $id;
											break;
	
									}
	
									$this->relationData[$form->entity->name][] = array($par[0],$par[1]);
									
									
									$oid = mysql_query($query);
									if (!$oid) {
										echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELATION_INSERT)." (".basename(__FILE__).":".__LINE__.")";
										exit;
									}
								}
							}
						}
					}
	
					$content = $this->display(ADD,1);
					
					if(!isset($temp)) {
						$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage(NOTIFY_ITEM_UPDATED));
					} else {
						$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage(NOTIFY_ITEM_ADDED));
					}
				}
	
				$this->addItem_postInsertion();
				break;
		}



		return $content;
	}

	/**
	 * editItem interaction pattern
	 *
	 * @param unknown_type $noDelete
	 * @return void
	 */

	function setReportTemplate($template) {
		$this->reportTemplate = $template;
	}

	function setReportQuery($query) {
		$this->reportQuery = $query;
	}
	
	function setPager(&$pager) {
		$this->pager = $pager;
	}
	
	
	function editItem($noDelete = false) {

		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}
		
		switch ($page) {
			case 0:
			
				$entity = $this->entity; 
				if (!isset($this->pager)) {
						
						/* the pager is going to instantiate the template object as well */
					$this->pager = new beContentPager();
				}
				
				if (!isset($_REQUEST['mode']) or ($_REQUEST['mode'] != AJAX)) {
					
					/*  
					
						FORM - EDIT ITEM - PAGE 0 
					
						The following is executed as the first step in the editItem() procedure.
						
					*/
					
					$this->editItem_preSelection();

					if (isset($_REQUEST['msgCode'])) {
						$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage($_REQUEST['msgCode']));
					}
			
					$body = new Template("{$this->reportTemplate}");
					
					$body->setContent("page", 1);
					$body->setContent("item", $this->entity->name, "length=\"{$this->pager->length}\"");

					$content = "<div id=\"becontent\">\n\n".$body->get()."\n</div>\n";
					$this->editItem_postSelection();
					
				} else {
				
					/* 	
						22.01.2008
						
						FORM - EDIT ITEM - PAGE 0 - AJAX:
					
						The following is executed by an AJAX request, it is intended to 
						replace the the externa ajax-report.php script, which caused lots
						of loosy coupling with the rest.
						
						It is invoked by the code which is generated by 
						
							FORM - EDIT FORM - PAGE 0 (ie the previous sub-step)
						
					*/
					
					
					/* 
					
						Warning: in the following stripslashes is necessary because of the 
						folloing directive in the PHP.INI file
						
							magic_quotes_sybase = Off
							
						it should not cause problems also in the case is On
						
					*/
					
					$form = unserialize(stripslashes($_REQUEST['form']));
					
					if ($form['update'] != "") {
						
						/* Look for eventual checkboxes (and others) which have clicked */
						
						foreach($this->entity->fields as $k => $v) {
							if (array_key_exists($v['name'], $form)) {
								$fields[] = $this->entity->fields[$k]['name'];
							}
						}
						
						$query = "UPDATE {$this->entity->name} SET ";
						if (is_array($fields)) {
							foreach($fields as $field) {
								$query .= aux::first_comma("UPDATE AJAX", ", ")."{$field} = '{$form[$field]}'";
							}
						}
						
						$query .= " WHERE {$this->entity->fields[0]['name']} = '{$form['value']}'";
						$oid = mysql_query($query); 
						
						
					
					}

					$_REQUEST['pagelength'] = $this->pager->length;
					
					$startIndex = ($_REQUEST['currentpage'] - 1)*$_REQUEST['pagelength']; 
					if ($startIndex < 0) {
						$startIndex = 1;
					}
					$length = $_REQUEST['pagelength'];
					
					
					if ($_REQUEST['currentpage']*$_REQUEST['pagelength'] > $_REQUEST['totallength']) {
						$length = $_REQUEST['pagelength'] - (($_REQUEST['currentpage']*$_REQUEST['pagelength']) - $_REQUEST['totallength']);
						
					}
					$endIndex = $startIndex + $length;
					
					
					
					if ($this->pager->query != "") {	
						
						if (($form['operation'] == "search") and ($form['search'] != "")) {
							#$this->pager->query = aux::refineQuery($this->pager->query, aux::evaluate($this->pager->filter, $form));
							$query = aux::refineQuery($this->pager->query, aux::evaluate($this->pager->filter, $form));
							
												
							$startIndex = ($_REQUEST['currentpage'] - 1)*$_REQUEST['pagelength']; 
							$length = $_REQUEST['pagelength'];

							if ($_REQUEST['currentpage']*$_REQUEST['pagelength'] > $_REQUEST['totallength']) {
								$length = $_REQUEST['pagelength'] - (($_REQUEST['currentpage']*$_REQUEST['pagelength']) - $_REQUEST['totallength']);
							}
							
							$endIndex = $startIndex + $length;
							
							
		
						} else {
						
							$query = aux::getResult($this->pager->getQuery(),PARSE);
							
						}
						
						$oid = mysql_query($query);
						
						$_REQUEST['totallength'] = mysql_num_rows($oid);
						
						if ($endIndex > $_REQUEST['totallength']) {
							$endIndex = $_REQUEST['totallength'];
						}
						
						
						$query .= " LIMIT {$startIndex}, {$length}";
						
						
						$data = aux::getResult($query);
						
						
						
					} else {
						
						if (($form['operation'] == "search") and ($form['search'] != "")) {
							
							$condition = "";
							foreach($this->entity->presentation as $v) {
								$condition .= aux::first_comma("condition", " OR ");
								$condition .= " {$v} LIKE '%{$form['search']}%' ";
							}
							
							if ($this->entity->owner) {
								$condition .= aux::first_comma("condition", " OR ");
								$condition .= " username LIKE '%{$form['search']}%' ";
							}
							
							$condition .= aux::first_comma("condition", " OR ");
							$condition .= " {$this->entity->fields[0]['name']} LIKE '%{$form['search']}%' ";
				
							$data = $entity->getReference(LIMIT, $startIndex, $length, $condition);
							
						} else {
							
							$data = $entity->getReference(LIMIT, $startIndex, $length);
							
						}
							
					}

					$totalPages = ceil($_REQUEST['totallength']/$_REQUEST['pagelength']);
					
					#echo $_REQUEST['totallength'], " ";
					
					
					//if (is_array($data) or (count($data) > 0)) {
					if ($_REQUEST['totallength'] > 0) {
						
						$content['content'] = $this->pager->get($data);
						$content['content'] = ereg_replace("\n", "", $content['content']);
					} else {
						
						$empty = new Template("dtml/empty-report.html");
						$content['content'] = ereg_replace("\n", "", $empty->get());
					}

					
					$content['startIndex'] = $startIndex + 1;
					$content['endIndex'] = $endIndex;
					$content['currentPage'] = $_REQUEST['currentpage'];
					$content['totalPages'] = $totalPages."";
					$content['totallength'] = $_REQUEST['totallength'];
					
					#echo $content['totallength'];exit;
					
					
					echo (aux::AjaxEncode($content));
					exit;
						
				}
			
				
				
				
				
			break;
			case 1:

				/* FORM FEED */
			
				$this->editItem_preFormFeed();

				$oid = mysql_query("SELECT * FROM {$this->entity->name}
			    	                WHERE {$this->entity->fields[0]['name']}='{$_REQUEST['value']}'");

				if (!$oid) {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}
			
				$data = mysql_fetch_assoc($oid);

				if ((count($data) > 0) and ($data != "")) {
					foreach($data as $k => $v) {
						$_REQUEST[$k] = $v;
					}
				}

			

				/* the following is about N-M relations */

				if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {

					foreach($this->triggeredForms as $k => $form) {

						switch($form->elements[0]['orientation']) {
							case RIGHT:
							$query = "SELECT * 
							            FROM {$form->entity->name}
			                		   WHERE {$form->entity->fields[0]['name']}='{$_REQUEST['value']}'";
							break;
						
						case LEFT:
							$query = "SELECT * 
							          FROM {$form->entity->name}
			                   		  WHERE {$form->entity->fields[1]['name']}='{$_REQUEST['value']}'";
							break;
						}

						$oid = mysql_query($query);

						if (!$oid) {
							echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
							exit;
						}

						do {
							
							$data = mysql_fetch_array($oid);

							if ($data) {
								switch($form->elements[0]['orientation']) {
									case RIGHT:
										
										$_REQUEST["{$form->elements[0]['name']}_".aux::encode_name($data[1])] = $data[1];
										#$_REQUEST["{$form->elements[0]['name']}_{$data[1]}"] = $data[1];
										break;
								
									case LEFT:

										$_REQUEST["{$form->elements[0]['name']}_".aux::encode_name($data[0])] = $data[0];
										#$_REQUEST["{$form->elements[0]['name']}_{$data[0]}"] = $data[0]; 
										break;
								}
							}
						} while ($data);
					}
				}

				$this->noDelete = $noDelete;
				$content = $this->display(EDIT,2,PRELOAD);

				$this->editItem_postFormFeed();
			
				break;
			
			case 2:

				/* UPDATE */
			
				foreach($this->elements as $k => $v) {
				
					if ($v['type'] == CHECKBOX) {
						$token = explode(":", $v['values'][1]);
						if (!isset($_REQUEST[$token[1]])) {
							$_REQUEST[$token[1]] = '';
						}
					}
				
				}
			
				$this->editItem_preUpdate();
				$entity = $this->entity;
			
				if (!$entity->editItem()) {

					/* An error occourred */

					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				} else {

					/* Pivotal entity has been succesfully updated */

					if (!isset($_REQUEST['value'])) {
						$_REQUEST['value'] = "";
					}

					$query = "SELECT * FROM {$this->entity->name} WHERE {$this->entity->fields[0]['name']}='{$_REQUEST['value']}'";


					$oid = mysql_query($query);

					if (!$oid) {
						echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
						exit;
					}
					$data = mysql_fetch_assoc($oid);

					if ((count($data) > 0) and ($data != "")) {
						foreach($data as $k => $v) {
						
							$_REQUEST[$k] = $v;
					}
				}

				/* RELATION MANAGER MANAGEMENT BELOW */
				
				if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {
					
					foreach($this->triggeredForms as $k => $form) {

						switch ($form->elements[0]['orientation']) {
							case RIGHT:
							$query = "DELETE FROM {$form->entity->name} WHERE {$form->entity->fields[0]['name']}='{$_REQUEST['value']}'";
							break;
							case LEFT:
							$query = "DELETE FROM {$form->entity->name} WHERE {$form->entity->fields[1]['name']}='{$_REQUEST['value']}'";
							break;
						}

						$oid = mysql_query($query);
						if (!$oid) {
							echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
							exit;
						}

						if (($this->entity->standardKey) and (isset($_REQUEST[$form->entity->entity_1->fields[0]['name']]))) {
							$_REQUEST[$form->entity->fields[0]['name']] = $_REQUEST[$form->entity->entity_1->fields[0]['name']];
						}

						foreach($_REQUEST as $key2=>$value2) {

							if (ereg("{$form->elements[0]['name']}_",$key2)) {

								switch ($form->elements[0]['orientation']) {
									case RIGHT:

									$query = "INSERT INTO {$form->entity->name} VALUES('{$_REQUEST[$form->entity->fields[0]['name']]}','{$_REQUEST[$key2]}')";
									break;
									case LEFT:

									$query = "INSERT INTO {$form->entity->name} VALUES('{$_REQUEST[$key2]}','{$_REQUEST['value']}')";
									break;
								}

								$oid = mysql_query($query);
								if (!$oid) {
									echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELATION_INSERT)." (".basename(__FILE__).":".__LINE__.")";
									exit;
								}
							}
						}
					}
				}


				$this->noDelete = $noDelete;
				$content = $this->display(EDIT,2,PRELOAD);
				
				
				if (!$this->moderationMode) {
					$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage(NOTIFY_ITEM_UPDATED));
				}

			}
			$this->editItem_postUpdate();
			break;
			case 3:

			/* DELETION */

			$this->editItem_preDeletion();

			if ($this->entity->deleteItem()) {
				$msgCode = NOTIFY_ITEM_DELETED;
			} else {
				$msgCode = NOTIFY_ITEM_INTEGRITY_VIOLATION;
			}

			$this->editItem_postDeletion();

			Header("Location: ".basename($_SERVER['SCRIPT_NAME'])."?action=edit&page=0&msgCode={$msgCode}");
			exit;

			break;
		}

		return $content;
	}

	function editItem2($noDelete = false) {

		if (!isset($_REQUEST['page'])) {
			$page = 0;
		} else {
			$page = $_REQUEST['page'];
		}

		
		switch ($page) {
			case 0:

			/* SHOW ITEMS - SELECTION LIST */
            /*
			$this->editItem_preSelection();

			if (isset($_REQUEST['msgCode'])) {
				$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage($_REQUEST['msgCode']));
			}
			*/
            
			/* sono dentro form */
			
			/*
			if (isset($this->filterRelation)) { 
				$data = $this->entity->getReferenceByRelation($this->filterRelation);
			} else {
				$data = $this->entity->getReference();
			}
			
			

			$body = new Template("{$this->templatePath}/report.html");
			$body->setContent("item",$data);


			$content = $body->get();
			$this->editItem_postSelection();

			*/
			
			$this->editItem_preSelection();

			if (isset($_REQUEST['msgCode'])) {
				$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage($_REQUEST['msgCode']));
			}

			/* sono dentro form */
			
			$body = new Template("{$this->reportTemplate}");
			$body->setContent("page", 1);
			$body->setContent("item", $this->entity->name);

			$content = "<div id=\"becontent\">\n\n".$body->get()."\n</div>\n";
			$this->editItem_postSelection();
			
			
			break;
			case 1:

			/* FORM FEED */
			
			$this->editItem_preFormFeed();

			$oid = mysql_query("SELECT * FROM {$this->entity->name}
			                    WHERE {$this->entity->fields[0]['name']}='{$_REQUEST['value']}'");

			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}
			$data = mysql_fetch_assoc($oid);

			if ((count($data) > 0) and ($data != "")) {
				foreach($data as $k => $v) {
					$_REQUEST[$k] = $v;
				}
			}

			

			/* the following is about N-M relations */

			if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {


				foreach($this->triggeredForms as $k => $form) {

					switch($form->elements[0]['orientation']) {
						case RIGHT:
						$query = "SELECT * FROM {$form->entity->name}
			                   WHERE {$form->entity->fields[0]['name']}='{$_REQUEST['value']}'";
						break;
						case LEFT:
						$query = "SELECT * FROM {$form->entity->name}
			                   WHERE {$form->entity->fields[1]['name']}='{$_REQUEST['value']}'";
						break;
					}

					$oid = mysql_query($query);

					if (!$oid) {
						echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
						exit;
					}

					do {
						$data = mysql_fetch_array($oid);

						#print_r($data);
						#echo "<hr>";

						if ($data) {
							switch($form->elements[0]['orientation']) {
								case RIGHT:
								#echo "RIGHT <br>";


								$_REQUEST["{$form->elements[0]['name']}_{$data[1]}"] = $data[1];
								break;
								case LEFT:
								#echo "LEFT <br>";


								$_REQUEST["{$form->elements[0]['name']}_{$data[0]}"] = $data[0];
								break;
							}

							#echo " right REQUEST[{$form->elements[0]['name']}_{$data[1]}] = {$data[1]}<br>";
							#echo " left REQUEST[{$form->elements[0]['name']}_{$data[0]}] = {$data[0]} <br>";

						}
					} while ($data);
				}
			}

			/* here */


			$this->noDelete = $noDelete;
			$content = $this->display(EDIT,2,PRELOAD);

			$this->editItem_postFormFeed();
			break;
			case 2:



			/* UPDATE */
			$this->editItem_preUpdate();

			$entity = $this->entity;

			if (!$entity->editItem()) {

				/* An error occourred */

				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
			} else {

				/* Pivotal entity has been succesfully updated */

				if (!isset($_REQUEST['value'])) {
					$_REQUEST['value'] = "";
				}

				$query = "SELECT * FROM {$this->entity->name} WHERE {$this->entity->fields[0]['name']}='{$_REQUEST['value']}'";


				$oid = mysql_query($query);

				if (!$oid) {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}
				$data = mysql_fetch_assoc($oid);

				if ((count($data) > 0) and ($data != "")) {
					foreach($data as $k => $v) {
						$_REQUEST[$k] = $v;
					}
				}



				if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {
					foreach($this->triggeredForms as $k => $form) {

						#echo "<hr><b>{$form->name}</b> ";
						#echo "{$form->entity->entity_1->fields[0]['name']}: {$_REQUEST[$form->entity->entity_1->fields[0]['name']]}<hr>";
						#print_r($_REQUEST);
						#echo "<hr>";

						switch ($form->elements[0]['orientation']) {
							case RIGHT:
							#$query = "DELETE FROM {$form->entity->name} WHERE {$form->entity->fields[0]['name']}='{$_REQUEST[$form->entity->fields[0]['name']]}'";
							$query = "DELETE FROM {$form->entity->name} WHERE {$form->entity->fields[0]['name']}='{$_REQUEST['value']}'";

							break;
							case LEFT:
							$query = "DELETE FROM {$form->entity->name} WHERE {$form->entity->fields[1]['name']}='{$_REQUEST['value']}'";
							break;
						}



						#echo "$query<hr>";
						$oid = mysql_query($query);
						if (!$oid) {
							echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
							exit;
						}

						if (($this->entity->standardKey) and (isset($_REQUEST[$form->entity->entity_1->fields[0]['name']]))) {
							$_REQUEST[$form->entity->fields[0]['name']] = $_REQUEST[$form->entity->entity_1->fields[0]['name']];
						}

						foreach($_REQUEST as $key2=>$value2) {

							if (ereg("{$form->elements[0]['name']}_",$key2)) {

								switch ($form->elements[0]['orientation']) {
									case RIGHT:

									$query = "INSERT INTO {$form->entity->name} VALUES('{$_REQUEST[$form->entity->fields[0]['name']]}','{$_REQUEST[$key2]}')";
									break;
									case LEFT:

									$query = "INSERT INTO {$form->entity->name} VALUES('{$_REQUEST[$key2]}','{$_REQUEST['value']}')";
									break;
								}

								#echo "<b>Insert:</b> $query<hr>";

								$oid = mysql_query($query);
								if (!$oid) {
									echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_RELATION_INSERT)." (".basename(__FILE__).":".__LINE__.")";
									exit;
								}
							}
						}
					}
				}


				$this->noDelete = $noDelete;
				$content = $this->display(EDIT,2,PRELOAD);
				if (!$this->moderationMode) {
					$GLOBALS['main']->setContent("message",$GLOBALS['message']->getMessage(NOTIFY_ITEM_UPDATED));
				}

			}
			$this->editItem_postUpdate();
			break;
			case 3:

			/* DELETION */

			$this->editItem_preDeletion();

			if ($this->entity->deleteItem()) {
				$msgCode = NOTIFY_ITEM_DELETED;
			} else {
				$msgCode = NOTIFY_ITEM_INTEGRITY_VIOLATION;
			}

			$this->editItem_postDeletion();

			Header("Location: ".basename($_SERVER['SCRIPT_NAME'])."?action=edit&page=0&msgCode={$msgCode}");
			exit;

			break;
		}

		return $content;
	}


	function validateItem() {

		/*

		This method is used by the Moderator, s/he can edit the item and
		accept it, the AAD check is done by auth.inc.php.

		*/

		$this->setModerationMode();


		$script = basename($_SERVER['SCRIPT_FILENAME']);
		if (ereg("([[:alnum:]]*)\-manager", $script, $token)) {
			$entityName = $token[1];
		}

		$entity = $GLOBALS['database']->getEntityByName($entityName);
		$keyName = $entity->fields[0]['name'];

		if (isset($_REQUEST['moderationResult'])) {

			$oid = mysql_query("SELECT {$entityName}.username,
												users.name,
												users.surname,
												users.email 
			                      FROM {$entityName} 
			                 LEFT JOIN users 
			                        ON users.username = {$entityName}.username
			                     WHERE {$entityName}.{$keyName}='{$_REQUEST[$keyName]}'");

			if (!$oid) {
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}

			$data = mysql_fetch_assoc($oid);

			switch ($_REQUEST['moderationResult']) {
				case "ACCEPT":

				$oid = mysql_query("UPDATE {$entityName} SET passed = '' WHERE {$keyName}='{$_REQUEST[$keyName]}'");
				if (!$oid) {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}

				$mail = new Template("dtml/mail_moderation_accept.html");
				$msgCode = MODERATION_ACCEPT;
				break;
				case "REFUSE":

				$oid = mysql_query("DELETE FROM {$entityName} WHERE {$keyName}='{$_REQUEST[$keyName]}'");
				if (!$oid) {
					echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}

				$mail = new Template("dtml/mail_moderation_refuse.html");

				if (isset($_REQUEST['refuse']) and (strip_tags($_REQUEST['refuse']))) {
					$_REQUEST['refuse'] = "\nThe editor motivated his/her decision as follows:\n\n".$_REQUEST['refuse']."\n";
					$_REQUEST['refuse'] = ereg_replace("<br />","\n", $_REQUEST['refuse']);

					$mail->setContent("refuse", strip_tags($_REQUEST['refuse']));
				}
				$msgCode = MODERATION_REFUSE;
				break;
			}

			$mail->setContent("name", "{$data['name']} ({$data['username']})");
			mail($data['email'], "model-transformation.org", $mail->get(), $_SESSION['user']['username']);

			Header("Location: message.php?msgCode={$msgCode}");
			exit;
		}
		$this->addSection("Note for the author");
		$this->addTextarea("refuse","Why refuse?", 10,70);


		$oid = mysql_query("SELECT *
			                   FROM {$entityName} 
			                  WHERE {$entityName}.{$keyName}='{$_REQUEST['value']}' AND {$entityName}.passed='*'");

		if (!$oid) {
			echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC)." (".basename(__FILE__).":".__LINE__.")";
			exit;
		}

		if (mysql_num_rows($oid) == 0) {
			$msgCode = MODERATION_EXPIRED;
			Header("Location: message.php?msgCode={$msgCode}");
			exit;
		}


		return $this->editItem(true);

	}


	function isPositionController($name) {

		$trovato = false;
		$i = 0;
		do {
			if ($this->elements[$i]['controlledField'] == $name) {
				$trovato = true;
			}
			$i++;
		} while ((not($trovato)) or ($i<count($this->elements)));

		return $trovato;
	}

	function getPositionFromController($name) {

		$trovato = false;
		$i = 0;
		do {
			if ((isset($this->elements[$i]['controlledField'])) && ($this->elements[$i]['controlledField'] == $name)) {

				$positionName = $this->elements[$i]['name'];
				$trovato = true;
			}
			$i++;
		} while ((!$trovato) and ($i<count($this->elements)));

		if ($trovato) {

			$trovato = false;
			$i = 0;
			do {
				if ($this->elements[$i]['name'] == $positionName) {
					$positionIndex = $i;
					$trovato = true;
				}
				$i++;
			} while ((!$trovato) and ($i<count($this->elements)));

			return $this->elements[$positionIndex];
		} else {
			return false;
		}

	}

	function update() {

		/* This must be invoked only on N-M relations */

		$relationManager = $this->elements[$this->relationManager];


		#echo "<br>",$this->entity->name; // groups_services
		#echo "<br>e1: ",$this->entity->entity_1->name; // groups
		#echo "<br>e2: ",$this->entity->entity_2->name; // services

		switch($relationManager['orientation']) {
			case LEFT:
			$leftEntity = $this->entity->entity_1;
			$rightEntity = $this->entity->entity_2;
			break;
			case RIGHT:
			$leftEntity = $this->entity->entity_2;
			$rightEntity = $this->entity->entity_1;
			break;
		}

		$prova = $leftEntity->getReference();

		/*
		$data = getResult("SELECT groups.name AS groups_name,
		groups.id AS groups_id,
		services.name AS services_name,
		services.id AS services_id,
		IF ( groups_services.id_groups IS  NULL ,'','*') AS enabled
		FROM groups, services
		LEFT JOIN groups_services
		ON groups_services.id_groups = groups.id
		AND groups_services.id_services = services.id
		ORDER  BY groups.id, services_id");
		*/

		$data = aux::getResult("
			SELECT {$leftEntity->name}.name AS groups_name, 
                     groups.id AS groups_id, 
                          services.name AS services_name, 
                          services.id AS services_id, 
                          IF ( groups_services.id_groups IS  NULL ,'','*') AS enabled
                     FROM groups, services
                LEFT JOIN groups_services 
                       ON groups_services.id_groups = groups.id 
                      AND groups_services.id_services = services.id
                ORDER  BY groups.id, services_id");


		switch($relationManager['orientation']) {
			case LEFT:

			$content .= "\n<!-- BEGIN RELATION MANAGER ORIENT_LEFT -->\n";
			$content .= "<table border=\"0\">\n";

			$content .= "</table>\n";
			$content .= "<!-- END RELATION MANAGER -->\n";

			break;
		}

		return $content;

	}


	function emitJavaScript($operation, $page, $preload) {

		$content = "";
		if (!$this->triggered) { // if it is a main form

			/* javascript validation prefix is generated only if the form is the main
			form and not the triggered one.

			** Rationale: the emitJS function is invoked recursively over the triggered
			form, thus we need to generate the js prefix only for the main form, for
			the triggered form only eventual validation is required. */

			$content .= "<!-- open main form script -->\n";
			$content .= "<script>\n\n";


			if ($operation == EDIT) {
				$content .= "function delete_{$this->name}() {\n";
				$content .= "var form = document.forms['{$this->name}'];\n\n";
				$content .= "  form.page.value=3;\n";
				$content .= "  if (!confirm('".$GLOBALS['message']->getMessage(MSG_JS_SURE)."')) {\n";
				$content .= "     return; \n";
				$content .= "  }\n";
				$content .= "  form.submit();\n";
				$content .= "}\n\n\n";

				if ($this->moderationMode) {

					$content .= "function accept_{$this->name}() {\n";
					$content .= "var form = document.forms['{$this->name}'];\n\n";
					$content .= "  form.moderationResult.value='ACCEPT';\n\n";
					$content .= "  form.submit();\n";
					$content .= "}\n\n\n";

					$content .= "function refuse_{$this->name}() {\n";
					$content .= "var form = document.forms['{$this->name}'];\n\n";
					$content .= "  form.moderationResult.value='REFUSE';\n\n";
					$content .= "  if (!confirm('".$GLOBALS['message']->getMessage(MSG_JS_SURE)."')) {\n";
					$content .= "     return; \n";
					$content .= "  }\n";
					//$content .= "  if (form.refuse.value == '') {\n";

					//$content .= "     alert('".$GLOBALS['message']->getMessage(MSG_JS_MODERATION)."');";
					//$content .= "     return; \n";
					//$content .= "  }\n";


					$content .= "  form.submit();\n";
					$content .= "}\n\n\n";

				}

			}

			$content .= "function submit_{$this->name}() {\n";
			$content .= "var form = document.forms['{$this->name}'];\n\n";
		}

		/* the rest is executed for both the triggering and triggered form */

		foreach($this->elements as $k => $v) {

			if ((isset($v["mandatory"])) && ($v["mandatory"] == strtolower("yes"))) {
				switch ($v["type"]) {
					case "text":
					case "date":
					case "link":
						
						$content .= "  if (form.{$v['name']}.value == '') {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_INSERT,$v)."');\n";

						$content .= "    return;\n";
						$content .= "  }\n";
					
					break;
					
					case LONGDATE:
						
						$content .= "  if (form.{$v['name']}.value == '') {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_INSERT,$v)."');\n";

						$content .= "    return;\n";
						$content .= "  }\n";
						
						$content .= "  if (form.{$v['name']}_time.value == '') {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_INSERT_TIME,$v)."');\n";

						$content .= "    return;\n";
						$content .= "  }\n";
					
					break;
					
					case "password":

					/* The password even if specified mandatory must be entered only in the
					ADD operation, while in the EDIT one if password is empty must be left
					simply unchanged */

						if ($operation == ADD) {
							$content .= "  if (form.{$v['name']}.value == '') {\n";
							$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_INSERT,$v)."');\n";
							$content .= "    return;\n";
							$content .= "  }\n";
						}
						
					break;
					
					case "textarea":
					case "editor":
					case FILE:
					case FILE2FOLDER:
					
						$content .= "  if (form.{$v['name']}.value == '') {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_INSERT,$v)."');\n";
						$content .= "    return;\n";
						$content .= "  }\n";
					
					break;
					
					case "select":
						
						$content .= "  if (form.{$v['name']}.selectedIndex == 0) {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_SELECT,$v)."');\n";
						$content .= "    return;\n";
						$content .= "  }\n";

					break;
					
					case "selectFromReference":
						
						$content .= "  if (form.{$v['name']}.selectedIndex == 0) {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_SELECT,$v)."');\n";
						$content .= "    return;\n";
						$content .= "  }\n";

					break;
					
					case RADIO_FROM_REFERENCE:
						
						$content .="  ischecked = false;\n";
						$content .="  for(i=0;i<form.{$v['name']}.length;i++) {\n";
						$content .="    if (form.{$v['name']}[i].checked == true) {\n";
						$content .="      ischecked = true;\n";
						$content .="	}\n";
						$content .="  }\n";
						$content .="  if (ischecked == false) {\n";
						$content .="    alert('".$GLOBALS['message']->getMessage(MSG_JS_RADIO,$v)."');\n";
						$content .="    return;\n";
						$content .="  }\n";

					break;
					
					case RELATION_MANAGER: 
					
						$content .= "  /* Relation Manager */\n\n";
					
						$content .= "  trovato = false;\n";
						$content .= "  for(i=0;i<form.elements.length;i++) {\n";
						$content .= "  if (!isUndefined(form.elements[i].name)) {\n";
						$content .= "    if (form.elements[i].name.search('{$v['name']}_') == 0) {\n";
						$content .= "      if (form.elements[i].checked) {\n";
						$content .= "        trovato = true;\n";
						$content .= "      }\n";
						$content .= "    }\n";
						$content .= "  }\n";
						#$content .= "   }\n";
						$content .= "  if (trovato == false) {\n";
						$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_RELATIONMANAGER,$v)."');\n";
						$content .= "    return;\n";
						$content .= "  }\n";
					
					break;
				}
			}
			
			if ($v['type'] == "position") { // POSITION ALL

				
				$content .= "  for(var i=0; i<form.{$v['name']}.options.length; i++) {\n";
				$content .= "    j=i+1;\n";
				$content .= "    form.{$v['name']}_all.value = form.{$v['name']}_all.value+form.{$v['name']}.options[i].value+':';\n";
				$content .= "  }\n";
				

			}

			if ($v['type'] == "hierarchicalPosition") { // POSITION ALL

				$content .= "  for(var i=0; i<form.{$v['name']}.options.length; i++) {\n";
				$content .= "    j=i+1;\n";
				$content .= "    form.{$v['name']}_all.value = form.{$v['name']}_all.value+form.{$v['name']}.options[i].value+':';\n";
				$content .= "  }\n";

			}
			
			
			if ($v['type'] == "color") { // COLOR
				
				$content .= "  var color_obj = document.getElementById('plugHEX');\n";
				$content .= "  form.{$v['name']}.value = color_obj.innerHTML;\n";
			
			}
			
			
			if (($v['type'] == FILE2FOLDER) or ($v['type'] == FILE) and (isset($v['filterByExtension']))) {
			
			#if (isset($v['filterByExtension'])) {
				
				$count = strlen($v['filterByExtension']);
				
				$content .= "  if (form.{$v['name']}.value != '') {\n";
				$content .= "    if (form.{$v['name']}.value.match('.{$v['filterByExtension']}') == null) {\n";
				
				if ($v['message'] == "") {
					$content .= "      alert('".$GLOBALS['message']->getMessage(MSG_JS_EXTENSION,$v)."');\n";
				} else {
					$content .= "      alert('".$GLOBALS['message']->getMessage(WARNING,$v).": {$v['message']}');\n";
				}
				$content .= "      return;\n";
				$content .= "    }\n";
				$content .= "  }\n";
				
			}
		}

		if (count($this->conditions)>0) {
			foreach($this->conditions as $k => $v) {
				switch($v['condition']) {
					
					case "equal":
					
						$content .= "  if (form.{$v['element_1']}.value != form.{$v['element_2']}.value) { \n";
						if ($v['message'] == "") {
							$content .= "    alert('Warning: \'{$v['label_1']}\' and \'{$v['label_2']}\' are not equal!');\n";
						} else {
							$content .= "    alert('Warning: {$v['message']}!');\n";
						}
						$content .= "    return;";
						$content .= "  }\n";
					
					break;
					
					case IMPLIES:
						
						if ($operation == EDIT) {
							switch ($v['obj_1']['type']) {
								case "selectFromReference":
								case "select":
									$content .= "  if (form.{$v['element_1']}.selectedIndex != 0) {\n";
							
								break;
								
								case "text":
								case FILE:
								case FILE2FOLDER:
									$content .= "  if ((form.{$v['element_1']}_hidden.value != '')||(form.{$v['element_1']}.value != '')) {\n";
								break;
							
							}
						
					
							switch ($v['obj_2']['type']) {
								case "selectFromReference":
								case "select":
									$content .= "    if (form.{$v['element_2']}.selectedIndex == 0) {\n";
							
								break;
							
								case "text":
								case FILE:
									$content .= "    if (form.{$v['element_2']}.value == '') {\n";
								break;
						
							}
					
							if ($v['message'] == "") {
								$content .= "      alert('".$GLOBALS['message']->getMessage(MSG_JS_IMPLIES,$v)."');\n";
							} else {
								$content .= "      alert('".$GLOBALS['message']->getMessage(WARNING,$v).": {$v['message']}');\n";
							}
							$content .= "      return;";
							$content .= "    }\n";
							$content .= "  }\n";
						
						} else {
						
							switch ($v['obj_1']['type']) {
								case "selectFromReference":
								case "select":
									$content .= "     if (form.{$v['element_1']}.selectedIndex != 0) {\n";
							
								break;
								case "text":
								case FILE:
								case FILE2FOLDER:
									$content .= "     if (form.{$v['element_1']}.value != '') {\n";
								break;
							
						
							}
						
					
							switch ($v['obj_2']['type']) {
								case "selectFromReference":
								case "select":
									$content .= "     if (form.{$v['element_2']}.selectedIndex == 0) {\n";
							
								break;
								case "text":
									$content .= "     if (form.{$v['element_2']}.value == '') {\n";
								break;
						
							}
					
							if ($v['message'] == "") {
								$content .= "    alert('".$GLOBALS['message']->getMessage(MSG_JS_IMPLIES,$v)."');\n";
							} else {
								$content .= "    alert('".$GLOBALS['message']->getMessage(WARNING,$v).": {$v['message']}');\n";
							}
							$content .= "    return;";
							$content .= "    }\n";
							$content .= "  }\n";
						}
					
					break;
					
					
					
					
					case "date le":
					case "date less equal":
						
						$content .= " d1 = form.{$v['element_1']}.value.substring(0,2);";
						$content .= " d2 = form.{$v['element_2']}.value.substring(0,2);";
						
						$content .= " m1 = form.{$v['element_1']}.value.substring(3,5);";
						$content .= " m2 = form.{$v['element_2']}.value.substring(3,5);";
						
						$content .= " y1 = form.{$v['element_1']}.value.substring(6,10);";
						$content .= " y2 = form.{$v['element_2']}.value.substring(6,10);";
						
						$content .= " el_1 = y1+m1+d1;";
						$content .= " el_2 = y2+m2+d2;";
						
						#$content .= "    alert(y1);\n";
					$content .= "  if (el_1 > el_2) { \n";
					if ($v['message'] == "") {
						$content .= "    alert('Warning: \'{$v['label_1']}\' and \'{$v['label_2']}\' are not equal!');\n";
					} else {
						$content .= "    alert('Warning: {$v['message']}!');\n";
					}
					$content .= "    return;";
					$content .= "  }\n";
					break;
				}
			}
		}


		if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {
			foreach($this->triggeredForms as $k => $form) {
				$content .= $form->emitJavaScript($operation, $page, $preload);
			}
		}


		if (!$this->triggered) { // if it is the main form

			/* The submit function is closed only in the case of the main function ?? */

			$content .= "  form.submit();\n";
			$content .= "}\n\n";

			$content .= "</script>\n";
			$content .= "<!-- close main form script -->\n\n ";
		}

		return $content;

	}



	function emitHTML($operation, $page, $preload) {
		
		#global $data, $tree_value, $tree_text;

		/* Preamble */

		$content = "";
		if (!$this->triggered) { // if it is the main form
			$content .= "\n<!-- MAIN FORM START -->\n";
			$content .= "<div id=\"becontent\">\n";
			$content .= "<form name=\"{$this->name}\" method=\"{$this->method}\" {$this->enctype}>\n";
			$content .= "  <input type=\"hidden\" name=\"page\" value=\"{$page}\">\n";

			switch($operation) {
				case ADD:

				/*
				it generates an session_id and a name session_id_name for it dependant from the entity name. These
				are used for form

				<input type=\"hidden\" name=\"{$session_id_name}\" value=\"{$session_id}\">

				and in the sessione

				$_SESSION[$session_id_name] = $session_id;

				Thus, once the data are sent back to the application the following holds

				$_REQUEST[$session_id_name] == $_SESION[$session_id_name].

				We want to distinguish the following cases:

				1. the form is freshly generated
				2. the data are valid
				3. the data are not valid

				*/

				$session_id_name = "S_".md5($this->entity->name);
				$session_id = md5(microtime());

				$_SESSION[$session_id_name] = $session_id;


				$content .= "  <input type=\"hidden\" name=\"{$session_id_name}\" value=\"{$session_id}\">\n";
				$content .= "  <input type=\"hidden\" name=\"action\" value=\"add\">\n";
				break;

				case EDIT:

				/* this is used also for the validation */

				if (!isset($_REQUEST[$this->entity->fields[0]['name']])) {
					$_REQUEST[$this->entity->fields[0]['name']] = "";
				}

				$content .= "  <input type=\"hidden\" name=\"{$this->entity->fields[0]['name']}\" value=\"{$_REQUEST[$this->entity->fields[0]['name']]}\">\n";
				$content .= "  <input type=\"hidden\" name=\"value\" value=\"{$_REQUEST[$this->entity->fields[0]['name']]}\">\n";

				/* Moderation Mode deprecated ? */
				
				if (!$this->moderationMode) {
					$content .= "  <input type=\"hidden\" name=\"action\" value=\"edit\">\n";
				} else {
					$content .= "  <input type=\"hidden\" name=\"action\" value=\"validate\">\n";
				}
				if ($this->entity->owner) {
					$content .= "  <input type=\"hidden\" name=\"creation\" value=\"{$_REQUEST['creation']}\">\n";
					$content .= "  <input type=\"hidden\" name=\"username\" value=\"{$_REQUEST['username']}\">\n";
				}
				break;
			}
			$content .= "  <table border=\"0\">\n";
		}

		/* Emitting widgets */


		foreach($this->elements as $k => $v) {

			
			
			if (($operation == EDIT) and ($v['name'] == $this->entity->fields[0]['name'])) {	
				$disabled = " disabled";
			} else {
				$disabled = "";
			}



			$content .= "    <tr>\n";

			
			
			switch ($v["type"]) {
				case HIDDEN:
					$content.= "<input type=\"hidden\" name=\"{$v['name']}\" value=\"{$v['value']}\" />\n";
					break;
				
				case "text": 				// TEXT
				


				$onChange = "";

				if ($position = $this->getPositionFromController($v['name'])) {

					if ($preload) {
						$onChange = " onChange=\"my_updatePosition_preload('{$this->name}', '{$position['name']}', this, '{$this->entity->fields[0]['name']}');\"";
					} else {
						$onChange = " onChange=\"my_updatePosition('{$this->name}', '{$position['name']}', this);\"";
					}
				}

				if ($v['mandatory']) {
					$mandatory = "";
				} else {
					$mandatory = "";
				}
				if (isset($this->helpers[$v['name']])) {



					$content .= "    <td>{$v["label"]} <a href=\"javascript:showHelper(this,'{$this->helpers[$v['name']]}')\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td>{$v["label"]} {$mandatory}</td>\n";
				}
				if ($preload) {

					if (($this->entity->addslashes) && (isset($_REQUEST[$v['name']]))) {
						$_REQUEST[$v['name']] = stripslashes($_REQUEST[$v['name']]);
					}

					/* HTML ENTITIES DECODE ? */
					
					#$_REQUEST[$v['name']] = html_entity_decode($_REQUEST[$v['name']]);
					
					
					
					
					if ($v['maxlength'] != "") {
						
						if (!isset($_REQUEST[$v['name']])) {
							$_REQUEST[$v['name']] = "";
						}
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$_REQUEST[$v['name']]}\" size=\"{$v['size']}\" {$onChange} {$disabled}></td>\n";
					} else {
						if (!isset($_REQUEST[$v['name']])) {
							$_REQUEST[$v['name']] = '';
						}
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$_REQUEST[$v['name']]}\" size=\"{$v['size']}\" maxlength=\"{$v[maxlength]}\" {$onChange} {$disabled}></td>\n";
					}
				} else {
					if ($v['maxlength'] == "") {
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"$v[size]\" {$onChange} {$disabled}></td>\n";
					} else {
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" maxlength=\"{$v['maxlength']}\" {$onChange} {$disabled}></td>\n";
					}
				}
				break;

				case "link": 				// LINK
				

				

				$onChange = "";

				if ($position = $this->getPositionFromController($v['name'])) {

					if ($preload) {
						$onChange = " onChange=\"my_updatePosition_preload('{$this->name}', '{$position['name']}', this, '{$this->entity->fields[0]['name']}');\"";
					} else {
						$onChange = " onChange=\"my_updatePosition('{$this->name}', '{$position['name']}', this);\"";
					}
				}

				if ($v['mandatory']) {
					$mandatory = "";
				} else {
					$mandatory = "";
				}
				if (isset($this->helpers[$v['name']])) {



					$content .= "    <td>{$v["label"]} <a href=\"javascript:showHelper(this,'{$this->helpers[$v['name']]}')\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td>{$v["label"]} {$mandatory}</td>\n";
				}
				if ($preload) {

					if (($this->entity->addslashes) && (isset($_REQUEST[$v['name']]))) {
						$_REQUEST[$v['name']] = stripslashes($_REQUEST[$v['name']]);
					}

					/* HTML ENTITIES DECODE ? */
					
					#$_REQUEST[$v['name']] = html_entity_decode($_REQUEST[$v['name']]);
					
					if (isset($v['maxlength'])) {
						if (!isset($_REQUEST[$v['name']])) {
							$_REQUEST[$v['name']] = "";
						}
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$_REQUEST[$v['name']]}\" size=\"{$v['size']}\" {$onChange} {$disabled}></td>\n";
					} else {
						if (!isset($_REQUEST[$v['name']])) {
							$_REQUEST[$v['name']] = '';
						}
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$_REQUEST[$v['name']]}\" size=\"{$v['size']}\" maxlength=\"{$v[maxlength]}\" {$onChange} {$disabled}></td>\n";
					}
				} else {
					if ($v['maxlength']) {
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"$v[size]\" {$onChange} {$disabled}></td>\n";
					} else {
						$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" maxlength=\"{$v['maxlength']}\" {$onChange} {$disabled}></td>\n";
					}
				}
				break;
				
				

				case "password":			// PASSWORD

				#$content .= "    <td>{$v["label"]}</td>\n";
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\"  class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td>{$v["label"]}</td>\n";
				}
				if ($v['maxlength']) {
					$content .= "    <td><input type=\"{$v['type']}\" name=\"{$v['name']}\" size=\"{$v['size']}\"></td>\n";
				} else {
					$content .= "    <td><input type=\"{$v['type']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" maxlength=\"{$v['maxlength']}\"></td>\n";
				}

				break;

				case FILE:			// FILE

				if ($preload) {

					if (isset($this->helpers[$v['name']])) {
						$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
					} else {
						$content .= "    <td>{$v["label"]}</td>\n";
					}

					$content .= "    <td><input style=\"float:left;\" type=\"file\" name=\"{$v['name']}\"> <input type=\"hidden\" name=\"{$v['name']}_hidden\" value=\"{$_REQUEST[$v['name']."_filename"]}\" />\n";
					
					
					if ($_REQUEST[$v['name']]) {
						
						
						switch ($_REQUEST[$v['name']."_type"]) {
							case "image/jpeg":
							case "image/gif":
								
								
								
								/* IMAGE */
								
								$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\"><div id=\"{$v['name']}_img\">";
								
								$content .= "<span>".$_REQUEST[$v['name']."_type"]."</span><br />\n<img class=\"left\" src=\"show.php?token=".md5($this->entity->name.$v['name'])."&id={$_REQUEST['value']}&width=188\">\n</div>\n</div>";
								
									$content .= "&nbsp; <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".$GLOBALS['message']->getMessage(MSG_FILE_DELETE);
								
							break;
							
							case "video/x-flv":
							case "application/octet-stream":
								
								/* 
								
									FLASH VIDEO FLV
									
									The extension should be checked since anything can be
									uploaded here.
									
								*/
								
								$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\">\n<div id=\"{$v['name']}_img\">\n";
								
            					
            					$src= "show.php?token=".md5($this->entity->name.$v['name'])."&id={$_REQUEST['value']}";
            					$width = 200;
            					$height = 150;
            					
            					$content .= "<script type=\"text/javascript\">\nAC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0','width','{$width}','height','{$height}','id','FLVPlayer2','src','FLVPlayer_Progressive','flashvars','&MM_ComponentVersion=1&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false','scale','noscale','name','FLVPlayer','salign','lt','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','FLVPlayer_Progressive' );\n</script>\n<noscript>\n<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"{$width}\" height=\"{$height}\" id=\"FLVPlayer2\">\n<param name=\"movie\" value=\"FLVPlayer_Progressive.swf\" />\n<param name=\"salign\" value=\"lt\" />\n<param name=\"scale\" value=\"noscale\" />\n<param name=\"FlashVars\" value=\"&MM_ComponentVersion=1&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\" />\n<embed src=\"FLVPlayer_Progressive.swf\" flashvars=\"&MM_ComponentVersion=1&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\"  scale=\"noscale\" width=\"{$width}\" height=\"{$height}\" name=\"FLVPlayer\" salign=\"LT\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" />\n</object>\n</noscript>\n";

          					
          						
            					
          						
            					$content .= "</div>\n";
            					
							break;
							default:
								
								/* UNKNOWN MIME TYPE */
								
								$content .= " <div class=\"image-show\" id=\"{$v['name']}\" ><input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><a target=\"_blank\" title=\"{$_REQUEST[$v['name']."_filename"]}\" href=\"show.php?token=".md5($this->entity->name.$v['name'])."&id={$_REQUEST['value']}\"><img src=\"img/beContent/show-gray-link.jpg\"></a></div>";
								
							

								$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".$GLOBALS['message']->getMessage(MSG_FILE_DELETE);
							break;
						}
						
						
						$content .= " </td>\n";
						
					} else {
						
						/* EMPTY */
						
						$content .= " <div class=\"image-show\" ><input type=\"text\" class=\"file\" value=\"".$GLOBALS['message']->getMessage(MSG_FILE_NONE)."\" disabled /><img src=\"img/beContent/show-gray-disabled.jpg\"></div> </td>\n";
						#$content .= "(".$GLOBALS['message']->getMessage(MSG_FILE_NONE).") </td>\n";
					}
				} else {
					#$content .= "    <td>{$v["label"]}</td>\n";

					if (isset($this->helpers[$v['name']])) {
						$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
					} else {
						$content .= "    <td>{$v["label"]}</td>\n";
					}

					$content .= "    <td><input type=\"file\" name=\"{$v['name']}\"></td>\n";
				}

				break;

				case FILE2FOLDER:
				
					if ($preload) {

						if (isset($this->helpers[$v['name']])) {
							$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
						} else {
							$content .= "    <td>{$v["label"]}</td>\n";
						}

						$content .= "    <td><input style=\"float:left;\" type=\"file\" name=\"{$v['name']}\"> <input type=\"hidden\" name=\"{$v['name']}_hidden\" value=\"{$_REQUEST[$v['name']."_reference"]}\" /> <input type=\"hidden\" name=\"{$v['name']}_reference\" value=\"{$_REQUEST[$v['name']."_reference"]}\" />\n";
					
					
						if ($_REQUEST[$v['name']."_reference"]) {
						
						
							switch ($_REQUEST[$v['name']."_type"]) {
								case "image/jpeg":
								case "image/gif":
									$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\"><div id=\"{$v['name']}_img\">";
								
									$content .= "<span>".$_REQUEST[$v['name']."_type"]."</span><br />\n<img class=\"left\" src=\"show.php?token=".md5($this->entity->name.$v['name'])."&id={$_REQUEST['value']}&width=188\">\n</div>\n</div>";
								
									$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".$GLOBALS['message']->getMessage(MSG_FILE_DELETE);
								break;

								case "video/x-flv":
								case "application/octet-stream":
							
									/* 
									
										06.01.2008
										
										FLASH VIDEO FLV 
									
										It may be suitable to check for the .flv extension since 
										the MIME may include anything. 
										
									*/
									
									$content .= " <div class=\"image-show\" id=\"{$v['name']}\" >\n<input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><img src=\"img/beContent/show-gray.jpg\" onClick=\"image_show('{$v['name']}')\">";
									$content .= "<input class=\"file_delete\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"><span class=\"delete\">".$GLOBALS['message']->getMessage(MSG_FILE_DELETE)."</span>\n";
									
									
									$content .= "<div id=\"{$v['name']}_img\">";
									
            					
            						$src = "{$GLOBALS['config']['upload_folder']}/{$_REQUEST[$v['name']."_reference"]}";
          
            						$width = 186;
            						$height = 149;
            					
            						
            						$content .= "\n\n<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"{$width}\" height=\"{$height}\" id=\"FLVPlayer\">\n<param name=\"movie\" value=\"FLVPlayer_Progressive.swf\" />\n<param name=\"salign\" value=\"lt\" />\n<param name=\"quality\" value=\"high\" />\n<param name=\"scale\" value=\"scale\" />\n<param name=\"FlashVars\" value=\"&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\" />\n<embed src=\"FLVPlayer_Progressive.swf\" flashvars=\"&skinName=includes/flv/players/player-unov&streamName={$src}&autoPlay=false&autoRewind=false\" quality=\"high\" scale=\"noscale\" width=\"{$width}\" height=\"{$height}\" name=\"FLVPlayer\" salign=\"LT\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />\n</object>\n\n";

            						
            						$content .= "</div>\n";
            						
            					
							break;
							default:
								
								/* UNKNOWN MIME TYPE */
								
								$content .= " <div class=\"image-show\" id=\"{$v['name']}\" ><input type=\"text\" class=\"file\" value=\"".$_REQUEST[$v['name']."_filename"]."\" disabled /><a target=\"_blank\" title=\"{$_REQUEST[$v['name']."_filename"]}\" href=\"show.php?token=".md5($this->entity->name.$v['name'])."&id={$_REQUEST['value']}\"><img src=\"img/beContent/show-gray-link.jpg\"></a></div>";

								$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_delete\" value=\"*\"> ".$GLOBALS['message']->getMessage(MSG_FILE_DELETE);
								
							break;
						}
						
						
						$content .= " </td>\n";
						
					} else {
						
						/* Empty */
						
						$content .= " <div class=\"image-show\" ><input type=\"text\" class=\"file\" value=\"".$GLOBALS['message']->getMessage(MSG_FILE_NONE)."\" disabled /><img src=\"img/beContent/show-gray-disabled.jpg\"></div> </td>\n";
					
					}
				} else {

					if (isset($this->helpers[$v['name']])) {
						$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
					} else {
						$content .= "    <td>{$v["label"]}</td>\n";
					}

					$content .= "    <td><input type=\"file\" name=\"{$v['name']}\"></td>\n";
				}

				break;
				
				case "date":				// DATE
				
				
				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td>{$v["label"]}</td>\n";
				}

				
				
				if ($preload) {
					$date = aux::formatDate($_REQUEST[$v['name']], STANDARD);
					
					
					
					$content .= "    <td><input name=\"{$v['name']}\" value=\"{$date}\"{$disabled}><img width=16 height=16 src=\"img/calendar/calendar.ico\" onclick=\"displayDatePicker('{$v['name']}');\" style=\"padding: 0px 0px 0px 2px;\"></td>\n";
				} else {
					if ($v['mandatory'] == MANDATORY) {
						$today = date("d/m/Y");
					} else {
						$today = "";
					}
					$content .= "    <td><input name=\"{$v['name']}\" value=\"{$today}\"{$disabled}><img width=16 height=16 src=\"img/calendar/calendar.ico\" onclick=\"displayDatePicker('{$v['name']}');\" style=\"padding: 0px 0px 0px 2px;\"></td>\n";
				}
				break;
				
				case LONGDATE:
					
					/* **** */
				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td>{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td>{$v["label"]}</td>\n";
				}

				if ($preload) {

					$date = aux::formatDate($_REQUEST[$v['name']], STANDARD);
					ereg("([0-9][0-9])([0-9][0-9])$", $_REQUEST[$v['name']], $token);
					$time = "{$token[1]}:{$token[2]}";
					
					$content .= "    <td><input name=\"{$v['name']}\" value=\"{$date}\"{$disabled}><img width=16 height=16 src=\"img/calendar/calendar.ico\" onclick=\"displayDatePicker('{$v['name']}');\" style=\"padding: 0px 0px 0px 2px;\"> <input name=\"{$v['name']}_time\" value=\"{$time}\" size=\"3\" {$disabled}> <span style=\"color: silver;\">(HH:mm)</span></td>\n";
				
				} else {
					if ($v['mandatory'] == MANDATORY) {
						$today = date("d/m/Y");
						$now = date("H:i");
					} else {
						$today = "";
						$now = "";
					}
					$content .= "    <td><input name=\"{$v['name']}\" value=\"{$today}\"{$disabled}><img width=16 height=16 src=\"img/calendar/calendar.ico\" onclick=\"displayDatePicker('{$v['name']}');\" style=\"padding: 0px 0px 0px 2px;\"> <input name=\"{$v['name']}_time\" value=\"{$now}\" size=\"3\" {$disabled}> <span style=\"color: silver;\">(HH:mm)</span></td>\n";
				}
				break;

				
				
				case "color":				// COLOR

				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"top\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"top\">{$v["label"]}</td>\n";
				}
				
				if ($preload) {
					
					$content .= "<input type='hidden' name='{$v['name']}' value='{$_REQUEST[$v['name']]}'>\n";
					$content .= "    <td valign=\"top\"><div id=\"plugin\" onmousedown=\"HSVslide('drag','plugin',event)\">
		<div id=\"plugHEX\" onmousedown=\"stop=0; setTimeout('stop=1',100);\">{$_REQUEST[$v['name']]}</div>
 		<div id=\"SV\" onmousedown=\"HSVslide('SVslide','plugin',event)\" title=\"Saturation + Value\">
  			<div id=\"SVslide\" ><br /></div>
		</div>
		<div id=\"H\" onmousedown=\"HSVslide('Hslide','plugin',event)\" title=\"Hue\">
					<div id=\"Hslide\" style=\"TOP: -7px; LEFT: -8px;\"></div>
					<div id=\"Hmodel\"></div>
  			<br/>
  			<br/>
  			<br/>
		</div>
	</div></td>\n";
					$content .= "<script type=\"text/javascript\"> function mkColor(v) {  }
					loadSV(); updateH('{$_REQUEST[$v['name']]}');
					</script>";

				} else {
					
					$content .= "<input type='hidden' name='{$v['name']}' value='{$v['preset']}'>\n";
					$content .= "    <td valign=\"top\"><div id=\"plugin\" onmousedown=\"HSVslide('drag','plugin',event)\">
		<div id=\"plugHEX\" onmousedown=\"stop=0; setTimeout('stop=1',100);\">{$v['preset']}</div>
 		<div id=\"SV\" onmousedown=\"HSVslide('SVslide','plugin',event)\" title=\"Saturation + Value\">
  			<div id=\"SVslide\" ><br /></div>
		</div>
		<div id=\"H\" onmousedown=\"HSVslide('Hslide','plugin',event)\" title=\"Hue\">
					<div id=\"Hslide\" style=\"TOP: -7px; LEFT: -8px;\"></div>
					<div id=\"Hmodel\"></div>
  			<br/>
  			<br/>
  			<br/>
		</div>
	</div></td>\n";
					$content .= "<script type=\"text/javascript\"> function mkColor(v) {  }
					loadSV(); updateH('{$v['preset']}');
					</script>";
				}


				break;

				case "textarea":			// TEXTAREA

				#$content .= "    <td valign=\"TOP\">{$v['label']}</td>\n";
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}
				if ($preload) {
					if ($this->entity->addslashes) {
						if (isset($_REQUEST[$v['name']])) {
							$_REQUEST[$v['name']] = stripslashes($_REQUEST[$v['name']]);
						} else {
							$_REQUEST[$v['name']] = '';
						}
					}
					
					/* HTML ENTITIES DECODE ? */
					
					#$_REQUEST[$v['name']] = html_entity_decode($_REQUEST[$v['name']]);
					
					if (!isset($_REQUEST[$v['name']])) {
						$content .= "    <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\"></textarea></td>\n";
					} else {
						$content .= "    <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\">{$_REQUEST[$v['name']]}</textarea></td>\n";
					}
				} else {
					$content .= "    <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\"></textarea></td>\n";
				}

				break;
				case "editor":			// EDITOR

				#$content .= "    <td valign=\"TOP\">{$v['label']}</td>\n";
				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}

				if ($preload) {
					if ($this->entity->addslashes) {
						$_REQUEST[$v['name']] = stripslashes($_REQUEST[$v['name']]);
					}
					
					/* HTML ENTITIES DECODE ? */
					
					#$_REQUEST[$v['name']] = html_entity_decode($_REQUEST[$v['name']]);
					
					
					$content .= "    <td><textarea class=\"mceEditor\" id=\"{$v['name']}\" name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\">{$_REQUEST[$v['name']]}</textarea></td>\n";
				} else {
					$content .= "    <td><textarea class=\"mceEditor\" id=\"{$v['name']}\" name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\"></textarea></td>\n";
				}
				break;
				case "radio":				// RADIO

				#$content .= "    <td>{$v["label"]}</td>\n";
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}
				$content .= "    <td>";

				if ($preload) {
					for($i=2;$i<count($v['values']);$i++) {
						$value = explode(":",$v[values][$i]);
						if ($value[1] == $_REQUEST[$v['name']]) {
							$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" CHECKED style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
						} else {
							$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
						}
					}
				} else {
					for($i=2;$i<count($v['values']);$i++) {
						$value = explode(":",$v[values][$i]);
						if ($value[2]) {
							$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" CHECKED  style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
						} else {
							$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
						}
					}
				}
				$content .= "    </td>";
				break;

				case CHECKBOX:			// CHECKBOX

				#$content .= "    <td>{$v["label"]}</td>\n";
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}
				$content .= "    <td>";


				for($i=1;$i<count($v['values']);$i++) {
					$value = explode(":",$v[values][$i]);


					

					if ($preload) {
						if ($_REQUEST[$value[1]]) {
							$content .= "<input class='clear' type=\"checkbox\" name=\"{$value[1]}\" value=\"{$value[2]}\" CHECKED> &nbsp;&nbsp; {$value[0]} &nbsp;&nbsp;";
						} else {
							$content .= "<input class='clear' type=\"checkbox\" name=\"{$value[1]}\" value=\"{$value[2]}\"> &nbsp;&nbsp; {$value[0]} &nbsp;&nbsp;";
						}
					} else {
						if ($value[3]) {
							$content .= "<input class='clear' type=\"checkbox\" name=\"{$value[1]}\" value=\"{$value[2]}\" CHECKED> &nbsp;&nbsp; {$value[0]} &nbsp;&nbsp;";
						} else {
							$content .= "<input class='clear' type=\"checkbox\" name=\"{$value[1]}\" value=\"{$value[2]}\"> &nbsp;&nbsp; {$value[0]} &nbsp;&nbsp;";
						}
					}
				}
				$content .= "    </td>";
				break;
				case "select":				// SELECT
				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}

				$content .= "    <td>";

				$content .= "<select class=\"becontent\" name=\"{$v['name']}\">\n";
				$content .= "<option></option>\n";

				if ($preload) {
					
					$values = explode(",", $v['values']);
					foreach($values as $k => $value) {
						
						$items = explode(":", $value);
						
						
						if ($_REQUEST[$v['name']] == $items[1]) {
							$content .= "<option value=\"{$items[1]}\" SELECTED> {$items[0]} </option>\n";
						} else {
							$content .= "<option value=\"{$items[1]}\" > {$items[0]} </option>\n";
						}
						
					}
					
				} else {
					
					$values = explode(",", $v['values']);
					foreach($values as $k => $value) {
						$items = explode(":", $value);
						if ($items[2] == "CHECKED") {
							$content .= "<option value=\"{$items[1]}\" SELECTED> {$items[0]} </option>\n";							
						} else {
							$content .= "<option value=\"{$items[1]}\" > {$items[0]} </option>\n";
						}
						
					}
				}

				$content .= "</select>\n";
				$content .= "    </td>\n";
				break;
				
				case "select-old":				// SELECT

				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}

				#$content .= "    <td>{$v["label"]}</td>\n";
				$content .= "    <td>";

				$content .= "<select class=\"becontent\" name=\"{$v['name']}\">\n";
				$content .= "<option></option>\n";

				if ($preload) {
					for($i=2;$i<count($v['values']);$i++) {
						$value = explode(":",$v[values][$i]);

						if ($_REQUEST[$v['name']] == $value[1]) {
							$content .= "<option value=\"{$value[1]}\" SELECTED> {$value[0]} </option>\n";
						} else {
							$content .= "<option value=\"{$value[1]}\" > {$value[0]} </option>\n";
						}
					}
				} else {
					for($i=2;$i<count($v['values']);$i++) {
						$value = explode(":",$v[values][$i]);

						if ($value[2]) {
							$content .= "<option value=\"{$value[1]}\" SELECTED> {$value[0]} </option>\n";
						} else {
							$content .= "<option value=\"{$value[1]}\" > {$value[0]} </option>\n";
						}
					}
				}

				$content .= "</select>\n";
				$content .= "    </td>\n";
				break;
				
				
				
				case "relation manager-2colonne": // RELATION MANAGER


				
				$content .= "    <td valign=\"TOP\"></td>\n";
				
				switch ($v['orientation']) {
					case RIGHT:
					$mainEntity = $this->entity->entity_1;
					$secondaryEntity = $this->entity->entity_2;

					break;
					case LEFT:
					$mainEntity = &$this->entity->entity_2;
					$secondaryEntity = &$this->entity->entity_1;

					break;
				}
				
				
				//setto i valori necessari in caso di gestione degli Rss
				
				if($this->mainFormEntity->rss) 
				{
					
					$query1="SELECT bc_channel.title FROM bc_channel
								LEFT JOIN channel_entity 
								    ON bc_channel.id=channel_entity.id_bc_channel  
								    	WHERE entity=\"{$this->mainFormEntity->name}\"";
					$listChannel=aux::getResultArray($query1,'title');
					if(!is_array($listChannel))$listChannel=array();
					$cont=count($listChannel);
					
					$query1="SELECT modality FROM bc_rss_mod WHERE entity=\"{$this->mainFormEntity->name}\"";
					$rssMod=aux::getResultArray($query1,'modality');
				}
				

				/* this fetches all the item which should be put into checkboxes */

				$data = $secondaryEntity->getReferenceWithCondition($v['condition']);

				$content .= "<td>\n";

				#print_r($_REQUEST);
				#echo "<hr>";
				
				if ((($this->entity->entity_2->owner) and ($v['orientation'] == RIGHT)) or 
				    (($this->entity->entity_1->owner) and ($v['orientation'] == LEFT))) {
					$your = $GLOBALS['message']->getMessage(FIELDSET);
				} else {
					$your = "";
				}
				
				$id = uniqid(time());

				if ($preload) {

					
					
					$content .= "<fieldset><legend>{$your} {$v["label"]}</legend>\n";
					if ($this->description != "") {
						$content .= "{$this->description}<br/><br/>\n";
					}
					
					$content .= "<table width=\"90%\">";
					
					
					$counter = 0;
					
					if ((count($data) > 0) and ($data != "")) {
						$first=true;
						
						$c=0;
						foreach($data as $key => $value) {

							$counter++;
							
							if (isset($_REQUEST["{$v['name']}_{$value['value']}"])) {
								
								if($this->mainFormEntity->rss) {
									
									if (in_array($value['text'],$listChannel)) {
										switch ($rssMod[0]) {
										case MOD3:														
											$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED> {$value['text']}<br>\n";		
											break;
										case MOD2:	
											$c++;
											if($first) {
														
												$first=false;															
												$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";														
											}																										
											$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";													
											break;
										case MOD1:  													
											$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";	
											if ($first) {
												$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																
												$first = false;
											}							
											break;
										}
									}
									
								} else { 
									
									if (($counter % 2) == 1) {
										$content .= aux::first_comma($id, "</td></tr>");
										$content .= "<tr><td>";
									} else {
										$content .= "</td><td>";
									}
									
									
									$name = "{$v['name']}_".aux::encode_name($value['value']);		
									$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\" CHECKED> {$value['text']}\n";
								
									
								}
							} else {
								
								if($this->mainFormEntity->rss) 
									{
										if (in_array($value['text'],$listChannel))
										{
											switch ($rssMod[0])
											{
												case MOD3:	
													$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";													
													break;
												case MOD2:	
													$c++;
													if($first)
													{
														$first=false;
															
														$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";															
													}																
													$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";
													
													break;
												case MOD1: 
													$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
													
													if ($first) {
														$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																$first = false;
													}
												
													break;
											}
										}
									}else{
										
										if (($counter % 2) == 1) {
											$content .= aux::first_comma($id, "</td></tr>");
											$content .= "<tr><td>";
										} else {
											$content .= "</td><td>";
										}
										
										
										$name = "{$v['name']}_".aux::encode_name($value['value']);	
										$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}\n";
									}
							}
							
						}
					}
					
					$content .= "</td></tr></table>";
					$content .= "</fieldset>\n";

				} else {

					$content .= "<fieldset><legend>{$your}{$v["label"]}</legend>\n";
					
					if ($this->description != "") {
						$content .= "{$this->description}<br/><br/>\n";
					}
					
					$content .= "<table width=\"90%\">\n";
					$content .= "<tr>";
					
					if ((count($data)>0) && ($data != "")) {
						$first=true;
						$c=0;
						foreach($data as $key => $value) {
							if($this->mainFormEntity->rss) 
							{
								if (in_array($value['text'],$listChannel))
								{				
									switch ($rssMod[0])
									{
									case MOD3:	
												$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
											
												break;
									case MOD2:	if($first)
												{
													
													$first=false;
													
												
													$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";		
												
												}
												$c++;	
												
												$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";
												
												break;
									case MOD1: 
												$content .= " <input style=\"display : none;\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
												
												if ($first) {
														$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																$first = false;
													}
												
												break;
									
									}
								}
							}	
							else
							{
								
								if (($counter % 2) == 1) {
									$content .= aux::first_comma($id, "</td></tr>");
									$content .= "<tr><td>";
								} else {
									$content .= "</td><td>";
								}
								
						
								$name = "{$v['name']}_".aux::encode_name($value['value']);	
								$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}\n";
							}
						}
					}
					$content .= "</tr></table>";
					$content .= "</fieldset>\n";
				}
				$content .= "</td>\n";


				break;

				case RELATION_MANAGER: // RELATION MANAGER


				
					$content .= "    <td valign=\"TOP\"></td>\n";

					switch ($v['orientation']) {
						case RIGHT:
							$mainEntity = $this->entity->entity_1;
							$secondaryEntity = $this->entity->entity_2;
							break;

						case LEFT:
							$mainEntity = &$this->entity->entity_2;
							$secondaryEntity = &$this->entity->entity_1;
						break;
					}
				
				
					// RSS
				
					if ($this->mainFormEntity->rss) {
					
						$query1="SELECT bc_channel.title 
							     FROM bc_channel
						 		 LEFT JOIN channel_entity 
								 ON bc_channel.id=channel_entity.id_bc_channel  
								 WHERE entity=\"{$this->mainFormEntity->name}\"";
						
						$listChannel=aux::getResultArray($query1,'title');
						if (!is_array($listChannel)) {
							$listChannel=array();
						}
						
						$cont=count($listChannel);
					
						$query1="SELECT modality 
						         FROM bc_rss_mod 
						         WHERE entity=\"{$this->mainFormEntity->name}\"";
						
						$rssMod=aux::getResultArray($query1,'modality');
					}
				

					/* this fetches all the item which should be put into checkboxes */

					$data = $secondaryEntity->getReferenceWithCondition($v['condition']);

					$content .= "<td>\n";
				
					if ((($this->entity->entity_2->owner) and ($v['orientation'] == RIGHT)) or 
				    	(($this->entity->entity_1->owner) and ($v['orientation'] == LEFT))) {
						
				    	$your = $GLOBALS['message']->getMessage(FIELDSET);
					} else {
					
						$your = "";
					}

					if ($preload) {
						
						$content .= "<fieldset><legend>{$your} {$v["label"]}</legend>\n";
						if ($this->description != "") {
							$content .= "{$this->description}<br/><br/>\n";
						}
					
						if ((count($data) > 0) and ($data != "")) {
							$first=true;
							$c=0;
						
							foreach($data as $key => $value) {

								#if (isset($_REQUEST["{$v['name']}_{$value['value']}"])) {
								if (isset($_REQUEST["{$v['name']}_".aux::encode_name($value['value'])])) {
								
									if($this->mainFormEntity->rss) {
										if (in_array($value['text'],$listChannel)) {
											switch ($rssMod[0]) {
												case MOD3:														
													$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED> {$value['text']}<br>\n";
													break;
													
												case MOD2:	
													$c++;
													if($first) {
														$first=false;											
														$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";														
													}																										
													$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
													break;
													
												case MOD1:  													
													$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";	
													if ($first) {
														$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																$first = false;
													}							
													break;
											}
										}
									} else {
										
										$name = "{$v['name']}_".aux::encode_name($value['value']);	
										$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\" CHECKED> {$value['text']}<br>\n";
										
									}
									
							} else {
								
								if($this->mainFormEntity->rss) 
									{
										if (in_array($value['text'],$listChannel))
										{
											switch ($rssMod[0])
											{
												case MOD3:	
													$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";													
													break;
												case MOD2:	
													$c++;
													if($first)
													{
														$first=false;
															
														$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";															
													}																
													$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";
													
													break;
												case MOD1: 
													$content .= " <input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
													
													if ($first) {
														$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																$first = false;
													}
												
													break;
											}
										}
									}else{
										$name = "{$v['name']}_".aux::encode_name($value['value']);	
										$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
										}
							}
							
						}
					}
					$content .= "</fieldset>\n";

				} else {

					$content .= "<fieldset><legend>{$your}{$v["label"]}</legend>\n";
					if ($this->description != "") {
						$content .= "{$this->description}<br/><br/>\n";
					}
					if ((count($data)>0) && ($data != "")) {
						$first=true;
						$c=0;
						foreach($data as $key => $value) {
							if ($this->mainFormEntity->rss) {
								if (in_array($value['text'],$listChannel)) {				
									switch ($rssMod[0]) {
										case MOD3:	
											$content .= " <input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
											break;
										
										case MOD2: 
											if ($first) {
													
												$first=false;
												$content .= " <input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED> ".$GLOBALS['message']->getMessage(RSS_MODALITY2_MSG)."\n";		
												
											}
											$c++;	
												
											$content .= " <input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\">\n";	
											break;
										
										case MOD1: 
											$content .= " <input style=\"display : none;\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED>\n";
											if ($first) {
												$content .=  $GLOBALS['message']->getMessage(RSS_MODALITY1_MSG);																
												$first = false;
											}
												
											break;
									}
								}
							} else {
								$name = "{$v['name']}_".aux::encode_name($value['value']);
								$content .= "<input class=\"clear\" type=\"checkbox\" name=\"{$name}\" value=\"{$value['value']}\"> {$value['text']}<br>\n";
							}
						}
					}
					$content .= "</fieldset>\n";
				}
				$content .= "</td>\n";


				break;

				case "relation manager2": // RELATION MANAGER

				#$content .= "    <td valign=\"top\">{$v["label"]}</td>\n";

				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td style=\"padding-top: 10px;\" valign=\"TOP\">{$v["label"]}</td>\n";
				}


				switch ($v['orientation']) {
					case RIGHT:
					$mainEntity = $this->entity->entity_1;
					$secondaryEntity = $this->entity->entity_2;

					break;
					case LEFT:
					$mainEntity = &$this->entity->entity_2;
					$secondaryEntity = &$this->entity->entity_1;

					break;
				}

				/* this fetches all the item which should be put into checkboxes */

				$data = $secondaryEntity->getReference();
				
				if($this->mainFormEntity->rss) 
				{
					
					$query1="SELECT bc_channel.title FROM bc_channel
								LEFT JOIN channel_entity 
								    ON bc_channel.id=channel_entity.id_bc_channel  
								    	WHERE entity=\"{$this->mainFormEntity->name}\"";
					$listChannel=aux::getResultArray($query1,'title');
					if(!is_array($listChannel))$listChannel=array();
					$cont=count($listChannel);
					
					$query1="SELECT modality FROM bc_rss_mod WHERE entity=\"{$this->mainFormEntity->name}\"";
					$rssMod=aux::getResultArray($query1,'modality');
				}

				$content .= "<td style=\"padding-top: 10px;\">\n";

				#print_r($_REQUEST);
				#echo "<hr>";

				if ($preload) {

					$content .= "<table>\n";
					if ((count($data) > 0) and ($data != "")) {
						$first=true;
						$c=0;
						foreach($data as $key => $value) {
							
							$content .= "<tr>\n";							
								if (isset($_REQUEST['rss_mod2'])||(isset($_REQUEST["{$v['name']}_{$value['value']}"]))) 
								{							
									if($this->mainFormEntity->rss) 
									{
										if (in_array($value['text'],$listChannel))
										{
											switch ($rssMod[0])
											{
												case MOD3:														
													$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td>{$value['text']}</td>\n";												
													break;
												case MOD2:	
													$c++;
													if($first)
													{
														
														$first=false;
																											
														$content .= "<td><input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\" CHECKED></td><td>Rss</td>\n</tr>\n<tr>";														
													}																										
													$content .= "<td><input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";													
													break;
												case MOD1:  													
													$content .= "<td><input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";												
													break;
											}
										}
									}
									else 
									{
										$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td>{$value['text']}</td>\n";
									}
								} else 
								{
									if($this->mainFormEntity->rss) 
									{
										if (in_array($value['text'],$listChannel))
										{
											switch ($rssMod[0])
											{
												case MOD3:	
													$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";													
													break;
												case MOD2:	
													$c++;
													if($first)
													{
														$first=false;
															
														$content .= "<td><input id=\"0\"class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\"></td><td>Rss</td>\n";														
													}																
													$content .= "<td><input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td></td>\n";
													
													break;
												case MOD1: 
													$content .= "<td><input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";
												
													break;
											}
										}
									}	
									else 
							     	{			
											$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
							      	}
								}																
							$content .= "</tr>\n";							
						}
					}
					$content .= "</table>\n";
				} else {

					$content .= "<table>\n";
					if ((count($data)>0) && ($data != "")) {
						$first=true;
						$c=0;
						foreach($data as $key => $value) {
							
							if($this->mainFormEntity->rss) 
							{
								if (in_array($value['text'],$listChannel))
								{				
									switch ($rssMod[0])
									{
									case MOD3:	$content .= "<tr>\n";
												$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
												$content .= "</tr>\n";
												break;
									case MOD2:	if($first)
												{
													
													$first=false;
													
													$content .= "<tr>\n";
													$content .= "<td><input id=\"0\" class=\"clear\" type=\"checkbox\" name=\"rss_mod2\" value=\"0\" onClick=\"reload({$cont});\"></td><td>Rss</td>\n";
													$content .= "</tr>\n";
												}
												$c++;	
												$content .= "<tr>\n";
												$content .= "<td><input id=\"{$c}\" style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td></td>\n";
												$content .= "</tr>\n";
												break;
									case MOD1:  $content .= "<tr>\n";
												$content .= "<td><input style=\"display : none\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\" CHECKED></td><td></td>\n";
												$content .= "</tr>\n";
												break;
									
									}
								}
							}	
							else
							{			
								$content .= "<tr>\n";
								$content .= "<td><input class=\"clear\" type=\"checkbox\" name=\"{$v['name']}_{$value['value']}\" value=\"{$value['value']}\"></td><td>{$value['text']}</td>\n";
								$content .= "</tr>\n";
							}
							
							
						}
					}
					$content .= "</table>\n";
				}
				$content .= "</td>\n";


				break;
				
				
				
				case "selectFromReference":// SELECTFROMREFERENCE

				
				/* Warning: it should be adapted for the preload option ! */

				if ($v['entity_name'] == $this->entity->name) {
					$selfreference = true;
				} else {
					$selfreference = false;
				}
				
				$trovato = false;
				
				foreach($this->elements as $index => $value) {
					if ($value['referenceField'] == $v['name']) {
						$trovato = true;
						$position_index = $index;
					}
				}
				
			
				
				if (($trovato) and ($selfreference)) {
					/* There is a self-reference foreign key */
					
					
					 
					$v["entity"]->setReferenceOrder($this->elements[$position_index]['name']);
					
				
				}
				
			
				
				if (isset($v['condition'])) {
					$data = $v["entity"]->getReferenceWithCondition($v['condition']);
				} else {
					
					
					
					if ($GLOBALS['becontent']->entities[$v['entity']->name]->referenceOrder != "") {
						
						
						
						$data = $v["entity"]->getReference(BY_POSITION, $GLOBALS['becontent']->entities[$v['entity']->name]->referenceOrder);
					} else {
						
						$data = $v['entity']->getReference();
					}
				}

						
				
				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}
				$content .= "    <td>\n";

				/* OK */
				
				
				
				if ($trovato) {
					
					$content .= "      <select  class=\"becontent\" name=\"{$v['name']}\" id=\"{$v['name']}\" onChange=\"makeRequest('{$v['name']}','{$this->elements[$position_index]['name']}','{$this->elements[$position_index]['controlledField']}','{$this->entity->name}','{$operation}','onChange')\">\n";
					
				} else {
					$content .= "      <select class=\"becontent\" name=\"{$v['name']}\">\n";
				}
				$content .= "      <option></option>\n";


				if ($selfreference) {
					
					
					$GLOBALS['data'] = $data;
					aux::FindChildren(0,0);
					
					for($i=0;$i<count($GLOBALS['tree_text']); $i++) {
						$GLOBALS['data'][$i]['value'] = $GLOBALS['tree_value'][$i];
						$GLOBALS['data'][$i]['text'] = $GLOBALS['tree_text'][$i];
					}
					
					#print_r($data);exit;
					$data = $GLOBALS['data'];
				}

				
				
				for($i=0;$i<count($data);$i++) {
					if ($preload) {
						if ($_REQUEST[$v['name']] == $data[$i]['value']) {
							$content .= "      <option value=\"{$data[$i]["value"]}\" SELECTED> {$data[$i]["text"]} </option>\n";
						} else {
							$content .= "      <option value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} </option>\n";
						}
					} else {
						$content .= "      <option value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} </option>\n";
					}
				}

				$content .= "      </select>\n";
				$content .= "    </td>\n";
				break;
				
				case RADIO_FROM_REFERENCE:

				/* Warning: it should be adapted for the preload option ! */

					unset($data);
					
					if (isset($v['condition'])) {
						$data = $v["entity"]->getReferenceWithCondition($v['condition']);
					} else {
						$data = $v["entity"]->getReference();
					}

					$content .= "<td valign=\"top\">{$v["label"]} ";
					if (isset($this->helpers[$v['name']])) {
						$content .= "<a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> ";
					}  
					
					$content .= "</td>\n";
					$content .= "<td>\n";

					for($i=0;$i<count($data);$i++) {
						
						if ($preload) {
							
							if ($_REQUEST[$v['name']] == $data[$i]['value']) {
								
								
								
								$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" CHECKED> {$data[$i]["text"]} &nbsp;&nbsp;><br/>\n";
							} else {
							
								$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\"> {$data[$i]["text"]} &nbsp;&nbsp;<br/>\n";
							
							
							}
						} else {
							
							if (($v['mandatory'] == "yes") and ($i == 0)) {
								$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" CHECKED> {$data[$i]["text"]} &nbsp;&nbsp;<br/>\n";	
							} else {
								$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} &nbsp;&nbsp;<br/>\n";
							}
						
						}
					}

					$content .= "    <br/></td>\n";
				break;
				
				
				
				

				case "position": 			// POSITION
				
				

				$data = $this->entity->getReference(BY_POSITION,$v['name']);

				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}

				$content .= "    <td>";
				$content .= "<input type=\"hidden\" name=\"{$v['name']}_all\" value=\"\">\n";

				#$content .= "<div><select id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" style=\"min-width: 300px;\">\n";
				$content .= "<div><select class=\"becontent position\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"8\">\n";

				#echo count($data);

				for($i=0;$i<count($data);$i++) {
					if ($preload) {

						/* the EDIT operation is always with RELOAD */

						#echo $_REQUEST[$this->entity->fields[0]['name']];

						if ($_REQUEST[$this->entity->fields[0]['name']] == $data[$i]['value']) {

							$content .= "<option value=\"{$data[$i]["value"]}\" SELECTED> {$data[$i]["text"]} </option>\n";
						} else {
							$content .= "<option value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} </option>\n";
						}
					} else {
						$content .= "<option value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} </option>\n";
					}
				}

				if ($operation == ADD) {

					/*	In the ADD operation one slot more is required
					for the element being added. */

					$content .= "<option value=\"0\">&nbsp;</option>\n";
				}
				$content .= "</select><br />\n";

				$content .= "<img vspace=5 src=\"img/position/button_up-new.jpg\" onClick=\"my_up('{$this->name}','{$v['name']}')\";>";
				$content .= "<img vspace=5 src=\"img/position/button_down-new.jpg\" onClick=\"my_down('{$this->name}','{$v['name']}')\";>";
				$content .= "</div>\n";
				$content .= "    </td>\n";

				break;
				
				case "hierarchicalPosition": 			// HIERARCHICALPOSITION

				$data = $this->entity->getReference(BY_POSITION, $v['name']);
							

				if (isset($this->helpers[$v['name']])) {
					$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
				} else {
					$content .= "    <td valign=\"TOP\">{$v["label"]}</td>\n";
				}

				$content .= "    <td>";
				$content .= "<input type=\"hidden\" name=\"{$v['name']}_all\" value=\"\">\n";

				$content .= "<div><select class=\"becontent\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" class=\"position\">\n";

				

				if ($operation == ADD) {

					/*	In the ADD operation one slot more is required
					for the element being added. */

					$content .= "<option value=\"0\">&nbsp;</option>\n";
				}
				$content .= "</select><br />\n";
					
				$content .= "<script>makeRequest('{$this->elements[$v['reference_index']]['name']}', '{$v['name']}', '{$v['controlledField']}','{$this->entity->name}', '{$operation}','onLoad')</script>\n";
			
				
				$content .= "<div class=\"position-button-up\" onClick=\"my_up('{$this->name}','{$v['name']}');\" ></div>";
				$content .= "<div class=\"position-button-down\" onClick=\"my_down('{$this->name}','{$v['name']}');\" ></div>";
				
				$content .= "</div>\n";
				$content .= "    </td>\n";

				break;
				

				case "section":			// SECTION
				$section = $v['name'];
				$content .= "<td colspan=2 style=\"padding-top: 20px;\"><b>{$section}</b></td>\n";
				break;
			}
			$content .= "  </tr>\n";
		}


		/* here goes the code for the triggered form */


		if ((count($this->triggeredForms)>0) and ($this->triggeredForms != "")) {
			foreach($this->triggeredForms as $k => $form) {
				
				if($form->mainFormEntity->rss)
				{
					$rssVar=$form;
				}
				else{ 
					$content .= $form->emitHTML($operation, $page, $preload);
					
				}
				
			}
			if(isset($rssVar)){
				$content .= $rssVar->emitHTML($operation, $page, $preload);
			}
		}


		/* Closing the Form */

		if (!$this->triggered) { // if it is the main form
			
			$content .= "  </table>\n";
			$content .= "<div class=\"closing\">";

			switch ($operation) {
				case "add":
				$subcontent=$this->emitHTML_post();
				
				if(isset($subcontent)) {
					$content .= $subcontent;
					
					if (!isset($this->labels[EDIT])) {
						$label = $GLOBALS['message']->getMessage(BUTTON_EDIT);	
					} else {
						$label = $this->labels[EDIT];
					}
					
					$content .= "<input type=\"button\" value=\"{$label}\" onClick=\"submit_{$this->name}();\">";
				} else {
					
				
					
					if (!isset($this->labels[ADD])) {
						$label = $GLOBALS['message']->getMessage(BUTTON_ADD);	
					} else {
						$label = $this->labels[ADD];
					}
					
					$content .= "<input type=\"button\" value=\"{$label}\" onClick=\"submit_{$this->name}();\">";
				}
				break;

				case "edit":

				if (!$this->moderationMode) {
					$content .= $this->emitHTML_post();
					#$content .= "<tr><td></td><td><input type=\"button\" value=\"".$GLOBALS['message']->getMessage(BUTTON_EDIT)."\" onClick=\"submit_{$this->name}();\">";
					$content .= "<input type=\"button\" value=\"".$GLOBALS['message']->getMessage(BUTTON_EDIT)."\" onClick=\"submit_{$this->name}();\">";

					if (!$this->noDelete) {

						/*
						In case it does not have to show the "delete" button, it is determinate
						by the NO_DELETE directive in the editItem() method.

						*/

						$this->noDelete = false;
						
						if (isset($this->labels[DELETE])) {
							$label = $GLOBALS['message']->getMessage(BUTTON_EDIT);	
						} else {
							$label = $this->labels[DELETE];
						}
						
						$content .= "<input type=\"button\" value=\"".$GLOBALS['message']->getMessage(BUTTON_DELETE)."\" onClick=\"delete_{$this->name}();\">";
					}

					#$content .= "</td></tr>\n";
				} else {

					#$content .= "<tr><td></td><td>";
					$content .= "<input type=\"hidden\" name=\"moderationResult\" value=\"\">";
					$content .= "<input type=\"button\" value=\"".$GLOBALS['message']->getMessage(BUTTON_ACCEPT)."\" onClick=\"accept_{$this->name}();\">";
					$content .= "<input type=\"button\" value=\"".$GLOBALS['message']->getMessage(BUTTON_REFUSE)."\" onClick=\"refuse_{$this->name}();\">";
					#$content .= "</td></tr>\n";
				}

				break;
			}

			$content .= "</div>\n";
			$content .= "</form>\n";
			$content .= "</div>\n";
			$content .= "<!-- MAIN FORM END -->\n";
		}

		return $content;
	}


	function display($operation,$page,$preload = "") {

		$content = "";
		$content .= $this->emitJavaScript($operation, $page, $preload);
		$content .= $this->emitHTML($operation, $page, $preload);

		return $content;
	}
	
	
	

	/* ADD ITEM CONNECTORS  */


	/**
	 * These functions are invoked as pre and post actions of the stage EMIT FORM
	 * of addItem().
	 * 
	 * They must be implemented in a subclass.
	 * 
	 * @abstract 
	 */
	function addItem_preEmitForm() {
		#echo "addItem_preEmitForm<br>";
	}

	function addItem_postEmitForm() {
		#echo "addItem_postEmitForm<br>";
	}

	/**
	 * These functions are invoked as pre and post actions of the stage INSERTION
	 * of addItem().
	 * 
	 * They must be implemented in a subclass.
	 * 
	 * @abstract 
	 */
	function addItem_sub(){
		#echo "addItem_sub<br>";
		#must return true if is implemented		
	}
	function addItem_preInsertion() {
		#echo "addItem_preInsertion<br>";
	}
	function addItem_postInsertion() {
		#echo "addItem_postInsertion<br>";
	}

	/* EDIT ITEM CONNECTORS */

	/**
	 * These function are invoked as pre and post actions of the SELECTION Stage 
	 * of editItem().
	 * 
	 * They must be eventually implemented in a subclass.
	 *
	 * @abstract 
	 */
	function editItem_preSelection() {
		#echo "editItem_preSelection<br>";
	}
	function editItem_postSelection() {
		#echo "editItem_postSelection<br>";
	}

	/**
	 * These function are invoked as pre and post actions of the FORM FEED Stage 
	 * of editItem().
	 *	  
	 * They must be eventually implemented in a subclass.
    *
	 * @abstract 
	 */
	function editItem_preFormFeed() {
		#echo "editItem_preFormFeed<br>";
	}
	function editItem_postFormFeed() {
		#echo "editItem_postFormFeed<br>";
	}

	/**
	 * These function are invoked as pre and post actions of the UPDATE Stage 
	 * of editItem().
	 *	  
	 * They must be eventually implemented in a subclass.
    *
	 * @abstract 
	 */
	function editItem_preUpdate() {
		#echo "editItem_preUpdate<br>";
	}
	function editItem_postUpdate() {
		#echo "editItem_postUpdate<br>";
	}

	/**
	 * These function are invoked as pre and post actions of the DELETION Stage 
	 * of editItem().
	 *	  
	 * They must be eventually implemented in a subclass.
    *
	 * @abstract 
	 */
	function editItem_preDeletion() {
		#echo "editItem_preDeletion<br>";
	}
	function editItem_postDeletion() {
		#echo "editItem_postDeletion<br>";
	}
	/**
	 * These function are invoked before the button end must return HTML code 
	 * 
	 *	  
	 * They must be eventually implemented in a subclass.
    *
	 * @abstract 
	 */
	
	function emitHTML_post(){
		#echo "emitHtml_post";
	}
}



//Classe usata per la stampa dell'xml
Class FeedRss{
	var 
		$entity,
		$channel,
		$result,
		$nameChannel;
	
	//inizializza le variabili: result incui andrà il codice xml
	//channel che contiene l'entità canale passatagli come parametro
	//inoltra effettua la chiamata addEntity()	
	function FeedRss($channel){
		
		$this->channel=$channel;
		$this->result="";
		$this->addEntity();
		
	}
	
	//utilizzato per inserire il nome canale da creare
	function addChannel($name){
		$this->nameChannel=$name;
	}
	
	//questa funzione ricava l'array entity effettuando il controllo sui nomi
	//delle varie tabelle utilizzando l'array globale beContent 
	function addEntity(){
		
		foreach ($GLOBALS['becontent']->entities as $i=>$value)
		{			
			if(substr_count($value->name,$this->channel->name)!=0)
			{
				if($value->name!=$this->channel->name)
					$entity[]=substr($value->name,0,strlen($value->name)-11);
			}
		}
		foreach ($GLOBALS['becontent']->entities as $i=>$value)
		{
			if (in_array($value->name, $entity))
				$this->entity[]=$value;
		}
		
	}
	
	//genera il codice XML degli item.
	function intermediateCode($data,$entity)
	{ 		
		$ret='';
		if(isset($data))
		{
			$x=0;
			while($x<count($data))
			{	
				$ret.='<item>'."\n";
				foreach ($entity->rssPresentation as $c_rss=>$c_tab)
				{
					switch ($c_rss){
						
						case 'title':$ret.='<title>'.aux::xmlchars($data[$x][$c_tab]).'</title>'."\n";break;
						case 'link':$ret.='<link>'.aux::xmlchars($data[$x][$c_tab]).'</link>'."\n";break;
						case 'description':$ret.='<description>'.aux::xmlchars($data[$x][$c_tab]).'</description>'."\n";break;
						case 'author':$ret.='<author>'.aux::xmlchars($data[$x][$c_tab]).'</author>'."\n";break;  
						case 'category':$ret.='<category>'.aux::xmlchars($data[$x][$c_tab]).'</category>'."\n";break;  
						case 'comments':$ret.='<comments>'.aux::xmlchars($data[$x][$c_tab]).'</comments>'."\n";break;  
						case 'guid':$ret.='<guid>'.aux::xmlchars($data[$x][$c_tab]).'</guid>'."\n";break;  
						case 'pubDate':$ret.='<pubDate>'.aux::xmlchars(aux::formatDate($data[$x][$c_tab]),LETTERS).'</pubDate>'."\n";  
					}			
					
				}
				$ret.='</item>'."\n";
				$x++;
			}
			$this->result.=$ret;
		}
		
	}
	
	// funzione di supporto che innesca intermediate code passandogli i dati relativi per ogni tabella
	function emitItem()
	{
		
		if(isset($this->nameChannel))
		{	
				$oid=mysql_query("SELECT id FROM {$this->channel->name} WHERE title=\"{$this->nameChannel}\"");
				if (!$oid) 
				{	
					
					echo mysql_error();			
			        echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC);
					exit;
				}
				$data = mysql_fetch_assoc($oid);
				
				
				
							
			}
			if(isset($data))
			{
				foreach ($this->entity as $i=>$entity)
				{	
					$query="SELECT * FROM {$entity->name} 
						LEFT JOIN {$entity->name}_{$this->channel->name}
						     ON {$entity->name}_{$this->channel->name}.id_{$entity->name}={$entity->name}.id
						WHERE {$entity->name}_{$this->channel->name}.id_{$this->channel->name}={$data['id']}";
						
				
								
					$buffer=aux::getResult($query);									
					$this->intermediateCode($buffer,$entity);
				}
			}
		
							
				
			
			//print($this->result);
		}
		
	//stampa il codice relativo all'intero file rss  generando i dati per il canale e appoggiandosi
	//al codice intermedio memorizzato precedentemente in result da intermediatecode
	//in più richiama la funzione printRss() per la stampa effettiva della stringa generata
	
	function emitXML2(){
		
		
		
		
		$ret='';
		$ret.='<?xml version="1.0"?>'."\n";
  		$ret.='<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/">'."\n";
  		$ret.='<channel>'."\n";		
		$data=aux::getResult("SELECT * FROM {$this->channel->name} WHERE title=\"{$this->nameChannel}\"");
		$data=$data[0];
        $ret.='<title>'.aux::xmlchars($data['title']).'</title>'."\n";
        $ret.='<link>'.aux::xmlchars($data['link']).'</link>'."\n";
		$ret.='<description>'.aux::xmlchars($data['description']).'</description>'."\n";
		
		if(isset($data['language']))		
			$ret.='<language>'.aux::xmlchars($data['language']).'</language>'."\n";
		
		if(isset($data['copyright']))
			$ret.='<copyright>'.aux::xmlchars($data['copyright']).'</copyright>'."\n";
		
		if(isset($data['managingEditor']))
			$ret.='<managingEditor>'.aux::xmlchars($data['managingEditor']).'</managingEditor>'."\n";
		
		if(isset($data['webMaster']))
			$ret.='<webMaster>'.aux::xmlchars($data['webMaster']).'</webMaster>'."\n";
		
		if(isset($data['pubDate']))
			$ret.='<pubDate>'.aux::xmlchars($data['pubDate']).'</pubDate>'."\n";
		
		if(isset($data['lastBuildDate']))
			$ret.='<lastBuildDate>'.aux::xmlchars($data['lastBuildDate']).'</lastBuildDate>'."\n";
		
		if(isset($data['category']))
			$ret.='<category>'.aux::xmlchars($data['category']).'</category>'."\n";
		
		if(isset($data['docs']))
			$ret.='<docs>'.aux::xmlchars($data['docs']).'</docs>'."\n";	
		
		if(isset($data['cloud']))
			$ret.='<cloud>'.aux::xmlchars($data['cloud']).'</cloud>'."\n";
		
		if(isset($data['ttl']))
			$ret.='<ttl>'.aux::xmlchars($data['ttl']).'</ttl>'."\n";
				
		
		if(isset($data['image_title']) and isset($data['image_link']) and ($data['image_size'] > 0)) {
				
			$ret.='<image>'."\n";
			$ret.='<title>'.aux::xmlchars($data['image_title']).'</title>'."\n";
			$ret.='<url>'.aux::xmlchars("show.php?token=ed3f638bfd40c089629d21d7a502f5bd&id={$data['id']}").'</url>'."\n";
			$ret.='<link>'.aux::xmlchars($data['image_link']).'</link>'."\n";
				
			if (isset($data['image_width'])) {
				$ret.='<width>'.aux::xmlchars($data['image_width']).'</width>'."\n";
			}		
			
			if (isset($data['image_height'])) {
				$ret.='<height>'.aux::xmlchars($data['image_height']).'</height>'."\n";
			}
				
			$ret.='</image>'."\n";
		
		}
					

		if (isset($this->nameChannel)) {	
			$oid=mysql_query("SELECT id FROM {$this->channel->name} WHERE title=\"{$this->nameChannel}\"");
			if (!$oid) {	
					
				echo mysql_error();			
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC);
				exit;
			}
			
			$data = mysql_fetch_assoc($oid);							
		}
		
		if(isset($data)) {
			
			foreach ($this->entity as $i=>$entity) {
				$query="SELECT * FROM {$entity->name} 
					 LEFT JOIN {$entity->name}_{$this->channel->name}
					        ON {$entity->name}_{$this->channel->name}.id_{$entity->name}={$entity->name}.id
						 WHERE {$entity->name}_{$this->channel->name}.id_{$this->channel->name}={$data['id']}";
											
				$buffer=aux::getResult($query);									
				$this->intermediateCode($buffer,$entity);
			}
		}
		
			
		
		
		$ret='';
	  	$ret.='</channel>'."\n";
	 	$ret.='</rss>'."\n";
	 	$this->result.=$ret;
	  	$this->printRss();		
	}
	
	function emitXML(){
		
		$rss = new Template("dtml/rss.xml");
		
		$data = aux::getResult("SELECT * FROM {$this->channel->name} WHERE id=\"{$_REQUEST['id']}\"");
		
		$data = $data[0];
		$channel = $data;
		
		$rss->setContent("title", $data['title']);
		$rss->setContent("link", aux::xmlchars($data['link']));
		$rss->setContent("description",  $data['description']);
		
		if (isset($data['language'])) {		
			$rss->setContent("language", $data['language']);
		} else {
			$rss->setContent("language", "");
		}
  		
		if (isset($data['lastBuildDate'])) {
			$rss->setContent("lastBuildDate", aux::xmlchars($data['lastBuildDate']));
		} else {
			$rss->setContent("lastBuildDate", "");
		}
		
		if (isset($data['copyright'])) {
			$rss->setContent("copyright", aux::xmlchars($data['copyright']));
		} else {
			$rss->setContent("copyright", "");
		}
	
		if (isset($data['pubDate'])) {
			$rss->setContent("pubDate", aux::xmlchars($data['pubDate']));
		} else {
			$rss->setContent("pubDate", "");
		}
		
		if (isset($data['category'])) {
			$rss->setContent("category", aux::xmlchars($data['category']));
		} else {
			$rss->setContent("category", "");
		}
		
		if (isset($data['docs'])) {
			$rss->setContent("docs", aux::xmlchars($data['docs']));
		} else {
			$rss->setContent("docs", "");
		}
		
		if (isset($data['cloud'])) {
			$rss->setContent("cloud", aux::xmlchars($data['cloud']));
		} else {
			$rss->setContent("cloud", "");
		}
		
		if (isset($data['ttl'])) {
			$rss->setContent("ttl", aux::xmlchars($data['ttl']));
		} else {
			$rss->setContent("ttl", "");
		}
		
		if (isset($data['image_title']) and isset($data['image_link']) and ($data['image_size'] > 0)) {
				
			$rss->setContent("image_title", $data['image_title']);
			$rss->setContent("image_url", aux::xmlchars("show.php?token=ed3f638bfd40c089629d21d7a502f5bd&id={$data['id']}"));
			$rss->setContent("image_link", aux::xmlchars($data['image_link']));
			
				
			if (isset($data['image_width'])) {
				$rss->setContent("image_width", aux::xmlchars($data['image_width']));
			} else {
				$rss->setContent("image_width", "");
			}
			if (isset($data['image_height'])) {
				$rss->setContent("image_height", aux::xmlchars($data['image_height']));
			} else {
				$rss->setContent("image_height", "");
			}	
		
		}
		
		$rss->setContent("managingEditor", aux::xmlchars("{$GLOBALS['config']['defaultuser']['email']} ({$GLOBALS['config']['defaultuser']['name']} {$GLOBALS['config']['defaultuser']['surname']})"));
		$rss->setContent("webMaster", aux::xmlchars("{$GLOBALS['config']['defaultuser']['email']} ({$GLOBALS['config']['defaultuser']['name']} {$GLOBALS['config']['defaultuser']['surname']})"));
		
		
		if (isset($this->nameChannel)) {	
			$oid=mysql_query("SELECT id FROM {$this->channel->name} WHERE title=\"{$this->nameChannel}\"");
			if (!$oid) {	
					
				echo mysql_error();			
				echo $GLOBALS['message']->getMessage(MSG_ERROR_DATABASE_GENERIC);
				exit;
			}
			
			$data = mysql_fetch_assoc($oid);							
		}
		
		if (isset($data)) {
			
			foreach ($this->entity as $i=>$entity) {
				
				if (isset($entity->rssPresentation['pubDate'])) {
					
				if ($entity->rssFilter != "") {
					$filter = " AND {$entity->rssFilter} ";
				} else {
					$filter = "";
				}
				
					$query="SELECT DISTINCT
				          	     {$entity->name}.*
				        	  FROM {$entity->name} 
						 LEFT JOIN {$entity->name}_{$this->channel->name}
						        ON {$entity->name}_{$this->channel->name}.id_{$entity->name}={$entity->name}.id
							 WHERE {$entity->name}_{$this->channel->name}.id_{$this->channel->name}={$data['id']}
							       {$filter}
						  ORDER BY {$entity->name}.{$entity->rssPresentation['pubDate']} DESC";
				} else {
					$query="SELECT DISTINCT
				          	     {$entity->name}.*
				        	  FROM {$entity->name} 
						 LEFT JOIN {$entity->name}_{$this->channel->name}
						        ON {$entity->name}_{$this->channel->name}.id_{$entity->name}={$entity->name}.id
							 WHERE {$entity->name}_{$this->channel->name}.id_{$this->channel->name}={$data['id']}
							       {$filter}";
					
				}
						
				
				$buffer=aux::getResult($query);	 
				
				if (count($buffer) > 0) {
					foreach ($buffer as $item) {
						
						if (is_array($entity->rssPresentation)) {
						
							foreach ($entity->rssPresentation as $c_rss=>$c_tab) {
								
								switch($c_rss) {
									case "pubDate":
										$rss->setContent("item_{$c_rss}", aux::formatDate($item[$c_tab], RSS));
									break;
									default:
										$rss->setContent("item_{$c_rss}", $item[$c_tab]);
									break;
								}
							}	 
						
							$rss->setContent("item_link", $channel['link']."?id={$item['id']}");
							if ($entity->owner) {
								$rss->setContent("item_author", aux::xmlchars(aux::formatDate($item[$entity->fields[0]['name']])));
							} 
						}
					}				
				}
			}
		}
		
		Header('Content-type: text/xml; charset=utf-8;');
		$rss->close();
	}	
		
	
	
	//setta il content-type del hearder per l'xml e procede con la stampa di result
	 function printRss(){
	 	header('Content-type: text/xml; charset=utf-8;');
	 	print $this->result;
	 }
	
}


	

Class Comments {
	var 
		$entity,
		$entitykey,
		$moderated = false;
	
	function Comments(&$entity) {
		$this->entity = $entity;
		$GLOBALS['becontent']->comments[$entity->name] = &$this;
		$entity->comments = &$this;
	}
	
	function addComment($id, $add = false) {
		
		if (isset($_SESSION['user'])) {
		
			$addcomment = new Template("dtml/addcomment.html");
			$addcomment->setContent("id", $id);
		
			$addcomment->setContent("button", aux::lingual("Aggiungi Commento", "Add Comment", "Aggiungi Commento"));
			$addcomment->setContent("message", aux::lingual("Attenzione: inserisci un commento!", "Warning: please enter a comment!", "Attenzione: inserisci un commento!"));
		
			if ($add) {
				
				$insertid = mysql_insert_id();
				
				$data = aux::getResult("
					SELECT {$GLOBALS['usersEntity']->name}.email,
						   {$GLOBALS['usersEntity']->name}.name,
						   {$GLOBALS['usersEntity']->name}.surname
					  FROM {$GLOBALS['commentEntity']->name}
				 LEFT JOIN {$GLOBALS['entitiesEntity']->name}
				        ON {$GLOBALS['entitiesEntity']->name}.name = {$GLOBALS['commentEntity']->name}.entityname
				 LEFT JOIN {$GLOBALS['usersGroupsRelation']->name}
				        ON {$GLOBALS['usersGroupsRelation']->name}.id_groups = entities.forum_moderator
				 LEFT JOIN {$GLOBALS['usersEntity']->name}
				        ON {$GLOBALS['usersEntity']->name}.username = {$GLOBALS['usersGroupsRelation']->name}.username				        
					 WHERE id = {$insertid}
					   AND {$GLOBALS['entitiesEntity']->name}.forum_moderator > 0");
				
				if (count($data) > 0) {
					
					foreach ($data as $user) {
						$mail = new Template("dtml/moderazione-commenti.mail");
						$mail->setContent("name", $user['name']);
						$mail->setContent("surname", $user['surname']);
					
						mail($user['email'],"[{$GLOBALS['config']['website']['name']}] nuovo commento",$mail->get(), $_SESSION['user']['email']);
						
						
					}
					
					
					$addcomment->setContent("notify", aux::lingual("Il suo commento è stato inoltrato.", "Your comment has been recived.", "Il suo commento è stato inoltrato."));

				}
			} 
		
		
		} else {
			
			$addcomment = new Template("dtml/addcomment-notlogged.html");
			$addcomment->setContent("notify", aux::lingual("Per aggiungere un commento devi loggarti nel tuo account!", "PLease log to add a comment", "Per aggiungere un commento devi loggarti nel tuo account!"));
		}
		
		return $addcomment->get();
	}
	
	
	function getComments($id) {
		
		$comments = new Template("dtml/comments.html");
		
		$data = aux::getResult("
			SELECT * 
		      FROM comments
		 LEFT JOIN users
		        ON users.username = comments.username
		     WHERE entityname = '{$this->entity->name}'
		       AND itemid = '{$id}'
		       AND comments.active = '*'
		       AND users.active = '*'
		  ORDER BY creation DESC");
		
		if (count($data) > 0) {
			foreach($data as $item) {
				foreach($item as $k => $v) {
					switch($k) {
						case "creation":
							$comments->setContent($k,aux::formatDate($v, EXTENDED));
						break;
						default:
							$comments->setContent($k,$v);
						break;
					}
				}
			}
		} else {
			$comments->setContent("username","");
			$comments->setContent("creation", "");
			$comments->setContent("body", aux::lingual("Non ci sono commenti", "No comments", "Nemo para commentares"));
		}
		
		return $comments->get();
		
	}
	
}


/* 

	The following codeis to avoid Remote SQL Injections.

	08-07-2008: there is a problem, with selectFromReference and primary key different than INT AUTO_INCREMENT.
	** Solution: in order to detect Remote SQL injections accordig to the expected datatypes the check must be
	             included in the transation addItem and editItem because it is possible to check the datatypes 
	             of the involved entity;
	             
	** Workaround: all the non numeric potential keys are escaped;
	
*/



if (basename($_SERVER['SCRIPT_FILENAME']) != "error.php") {

	foreach ($_REQUEST as $k => $v) {
		
		if ($k == "id") {
			if (!ereg("^[[:digit:]]*$", $v)) {
				$_REQUEST[$k] = mysql_escape_string($v);
			}
		} elseif (ereg("\_id$", $k)) {
			if (!ereg("^[[:digit:]]*$", $v)) {
				$_REQUEST[$k] = aux::escape_string($v);; // $_REQUEST[$k] = -1;
			}
		} elseif (ereg("^id\_", $k)) {
			if (!ereg("^[[:digit:]]*$", $v)) {
				$_REQUEST[$k] = aux::escape_string($v); // $_REQUEST[$k] = -1;
			}
		} elseif ($k == "username") {
			$_REQUEST['username'] = mysql_escape_string($v);
		} elseif ($k == "name") {
			$_REQUEST['name'] = mysql_escape_string($v);
		} elseif ($k == "surname") {
			$_REQUEST['surname'] = mysql_escape_string($v);
		} elseif ($k == "email") {
			$_REQUEST['email'] = mysql_escape_string($v);
		} 
	} 
}

/* Configuration Inclusion */

if (file_exists("include/config.inc.php")) {
	require "include/config.inc.php";
	
} else {
	
	require "../include/config.inc.php";
}

$database = new DB($config['database'][$_SERVER['SERVER_NAME']]['host'],
                   $config['database'][$_SERVER['SERVER_NAME']]['database'],
                   $config['database'][$_SERVER['SERVER_NAME']]['username'],
                   $config['database'][$_SERVER['SERVER_NAME']]['password']);

$message = new Message($config['language']);

if (file_exists("include/entities.inc.php")) {
	require "include/entities.inc.php";
} else {
	require "../include/entities.inc.php";
}

$database->init();

if (isset($_REQUEST['action'])) {
	switch($_REQUEST['action']) {
		case "password":
			
			$skin = new Skin("dipartimento");
			$mail = new Skinlet("password.mail");
			
			#echo "QUI";
			
			
			$data = aux::getResult("SELECT * FROM {$usersEntity->name} WHERE email = '{$_REQUEST['email']}'");
			
			if (mysql_affected_rows() == 0) {
				$_REQUEST['id'] = NOTIFICATION_ERROR;
			} else {
			
				$password = substr(md5(time()),0,8);
			
				$oid = mysql_query("UPDATE {$usersEntity->name} 
			            	           SET password = MD5('{$password}') 
			             	        WHERE username='{$data[0]['username']}'");
			
			
				$data[0]['password'] = $password;
		
				foreach ($data[0] as $k => $v) {
					$mail->setContent($k,$v);
				}
				
				aux::mail($data[0]['email'], "Login data", $mail->get(), $GLOBALS['config']['website']['email']);
			
				$_REQUEST['id'] = NOTIFICATION; 
			}
			     
			break;
	}
}




?>

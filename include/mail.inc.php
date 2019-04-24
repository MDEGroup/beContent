<?php


require_once("class.phpmailer.php");

	Class zMail {
  		var 
  			$to,
    		$from,
    		$fromName,
    		$subject,
		    $message,
		    $cc,
		    
		    $file,
		    $file_type,
		    $file_name,
		    
		    $buffer,
		    $buffer_type,
		    $buffer_name;

		function Mail() {

  		}

  		function addFrom($from) {
  			$this->from = $from;
  		}
  		
  		function addFromName($fromName) {
  			$this->fromName = $fromName;
  		}
  		
  		function addTo($to) {
  			$this->to = $to;
  		}
  		
  		function addCC($cc) {
  			$this->cc = $cc;
  		}
  		
  		function addSubject($subject) {
  			$this->subject = $subject;
  		}
  		
  		function addMessage($message) {
    		$this->message = $message;
  		}

	  	function addAttachment($file, $name, $type) {

    		$this->file[] = $file;
    		$this->file_name[] = $name;
    		$this->file_type[] = $type;
  		}

  		function addAttachmentFromString($buffer, $name, $type) {
  			$this->buffer[] = $buffer;
  			$this->buffer_name[] = $name;
  			$this->buffer_type[] = $type;
  		}
  		
  		function send2() {
    		
    		$uid = strtoupper(md5(uniqid(time())));
    		
      		$header = "From: ".$this->from."\nReply-To: ".$this->from."\n";
      		if ($this->cc != "") {
      			$header .= "CC: ".$this->cc."\n";
      		}
      		$header .= "MIME-Version: 1.0\n";
      		$header .= "Content-Type: multipart/mixed; boundary=$uid\n";
      		$header .= "--$uid\n";
      		$header .= "Content-Type: text/plain\n";
      		$header .= "Content-Transfer-Encoding: 8bit\n\n";
      		$header .= $this->message."\n";
      		
      		if (is_array($this->file)) {
	      		foreach($this->file as $k => $v) {
	
					$content = fread(fopen($this->file[$k],"r"),filesize($this->file[$k]));
					$content = chunk_split(base64_encode($content));
	
					$header .="--$uid\n";
					$header .= "Content-Type: ".$this->file_type[$k]."; name=\"".$this->file_name[$k]."\"\n";
					$header .= "Content-Transfer-Encoding: base64\n";
					$header .= "Content-Disposition: attachment; filename=\"".$this->file_name[$k]."\"\n\n";
					$header .= "$content\n";
	      		}
      		}

      		if (is_array($this->buffer)) {
      			foreach($this->buffer as $k => $v) {
	
					$content = chunk_split(base64_encode($v));
	
					$header .="--$uid\n";
					$header .= "Content-Type: ".$this->buffer_type[$k]."; name=\"".$this->buffer_name[$k]."\"\n";
					$header .= "Content-Transfer-Encoding: base64\n";
					$header .= "Content-Disposition: attachment; filename=\"".$this->buffer_name[$k]."\"\n\n";
					$header .= "$content\n";
	
	      		}
      		}
      		
    		   		
    		aux::mail($this->to, $this->subject, $this->message, $header);
    		return true;


  		}
  		
  		function send() {
    		
    		/*$uid = strtoupper(md5(uniqid(time())));
    		
      		$header = "From: ".$this->from."\nReply-To: ".$this->from."\n";
      		if ($this->cc != "") {
      			$header .= "CC: ".$this->cc."\n";
      		}
      		$header .= "MIME-Version: 1.0\n";
      		$header .= "Content-Type: multipart/mixed; boundary=$uid\n";
      		$header .= "--$uid\n";
      		$header .= "Content-Type: text/plain\n";
      		$header .= "Content-Transfer-Encoding: 8bit\n\n";
      		$header .= $this->message."\n";
      		
      		if (is_array($this->file)) {
	      		foreach($this->file as $k => $v) {
	
					$content = fread(fopen($this->file[$k],"r"),filesize($this->file[$k]));
					$content = chunk_split(base64_encode($content));
	
					$header .="--$uid\n";
					$header .= "Content-Type: ".$this->file_type[$k]."; name=\"".$this->file_name[$k]."\"\n";
					$header .= "Content-Transfer-Encoding: base64\n";
					$header .= "Content-Disposition: attachment; filename=\"".$this->file_name[$k]."\"\n\n";
					$header .= "$content\n";
	      		}
      		}

      		if (is_array($this->buffer)) {
      			foreach($this->buffer as $k => $v) {
	
					$content = chunk_split(base64_encode($v));
	
					$header .="--$uid\n";
					$header .= "Content-Type: ".$this->buffer_type[$k]."; name=\"".$this->buffer_name[$k]."\"\n";
					$header .= "Content-Transfer-Encoding: base64\n";
					$header .= "Content-Disposition: attachment; filename=\"".$this->buffer_name[$k]."\"\n\n";
					$header .= "$content\n";
	
	      		}
      		} */
      		
    		   		
    		#aux::mail($this->to, $this->subject, $this->message, $header);
    		
    		$mail = new PHPMailer();
			$mail->SetLanguage("it");

			$mail->IsSMTP();
			$mail->SMTPAuth   = true;                  
			$mail->SMTPSecure = "ssl";                 
			#$mail->Host       = "smtp.univaq.it";      
			$mail->Host       = "192.150.196.71";      
			$mail->Port       = 465;                   
			$mail->Username   = "alfonso.pierantonio@univaq.it";  
			$mail->Password   = "viva1felice";            

			
			$mail->From       = $this->from;
			$mail->FromName   = $this->fromName;
			
			$mail->AddAddress($this->to);
			
			if ($this->cc != "") {
				$mail->AddCC($this->cc);
			}	
			$mail->Subject    = (empty($this->subject)?"Comunicazione dal Dipartimento":$this->subject);	
			$mail->Body       = eregi_replace("[\]",'',$this->message);
			$mail->IsHTML(false);
 
 	#if (!empty($attachment))
 	
# $mail->AddStringAttachment($attachment["data"],addslashes($attachment["filename"]),"base64",$attachment["mimetype"]);
 			if (!$mail->Send()) {
 				echo $mail->ErrorInfo;
 			}

    		
    		return true;


  		}
	}

	
class zMailer extends phpmailer {
    // Set default variables for all new objects
    #var $From     = "@example.com";
    #var $FromName = "Mailer";
    #var $Host     = "smtp1.example.com;smtp2.example.com";
    #var $Mailer   = "smtp";                         // Alternative to IsSMTP()
    #var $WordWrap = 75;

    function zMailer() {
    	
    	$this->SetLanguage("it");
    	$this->IsSMTP();
		$this->SMTPAuth   = true;                  
		$this->SMTPSecure = "ssl";                 
			
		$this->Host       = "192.150.196.71";      
		$this->Port       = 465;                   
		$this->Username   = "alfonso.pierantonio@univaq.it";  
		$this->Password   = "viva1felice";            

		$this->WordWrap = 75;
		
    	
    }
    
    function Send() {
    	if (!parent::Send()) {
 			echo $this->ErrorInfo;
 		}
    }
    
    

}






?>
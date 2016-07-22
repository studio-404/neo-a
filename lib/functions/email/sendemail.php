<?php
namespace lib\functions\email; 

use config\main as c; 

class sendemail{
	public $message; 

	public function send($toname, $to, $subject, $body){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

		$headers .= 'To: '.$toname.' <'.$to.'>' . "\r\n";
		$headers .= 'From: '.c::EMAIL_NAME.' <'.c::EMAIL_USERNAME.'>' . "\r\n";

		if(!mail($to, $subject, $body, $headers)){
			$this->message = false;
		}else{
			$this->message = true;
		}
		return $this->message;
	}
}
?>
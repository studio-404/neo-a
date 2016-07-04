<?php
namespace lib\template;

use config\main as c;
use lib\functions\url\request as request;

class admin{

	function __construct(){
		$this->message = "";
		$this->request = new request();
		$this->username = sprintf(
			"%susername",
			c::SESSION_PREFIX
		);
		$this->getRequests();
	}

	public function module(){
		$out = '<div class="administrator">';
		if($this->checkSession()){
			$out .= $this->logOut(); 
		}else{
			$out .= $this->loginForm(); 
		}
		$out .= '</div>'; 
		return $out;
	}

	private function getRequests(){
		if(
			$this->request->method("POST","username") && 
			$this->request->method("POST","password") 
		){
			if(
				$this->request->method("POST","username")==c::ADMIN_USER && 
				$this->request->method("POST","password")==c::ADMIN_PASS
			){
				$_SESSION[$this->username] = "NeoAdministrator";
			}else{
				$this->message = "Opps Wrond Username Or Password !";
			}
			
		}		
		if($this->request->method("GET","logout")=="true"){
			session_destroy();
			self::redirect(c::WEBSITE."?admin=true");
		}
	}

	private function loginForm(){
		$out = sprintf(
			'
			<font color="red">%s</font>
			<form action="" method="POST">
			<label>Username: </label>
			<input type="text" name="username" value="" />
			<label>Password: </label>
			<input type="text" name="password" value="" />
			<input type="submit" value="LogIn" />
			<a href="%s" class="removePanel">Remove Panel Box</a>
			</form>			
			',
			$this->message,
			c::WEBSITE
		);
		return $out;
	}

	private function logOut(){
		$out = sprintf(
			'Hello %s | <a href="?admin=true&logout=true">LogOut</a>', 
			$_SESSION[$this->username]
		);
		return $out;
	}

	public function checkSession(){
		if(isset($_SESSION[$this->username])){
			return true;
		}
		return false;
	}

	private static function redirect($u){
		echo sprintf(
			'<meta http-equiv="refresh" content="0; url=%s" />',
			$u
		);
		exit();
	}

}
?>
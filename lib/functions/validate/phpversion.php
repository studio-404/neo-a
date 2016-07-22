<?php
namespace lib\functions\validate; 

use config\main as c;

class phpversion{
	public $mpv;
	public function check(){
		$this->mpv = c::MIN_PHP_VERSION;
		if (strnatcmp(phpversion(), $this->mpv) >= 0)
		{
		  return true;
		}
		return false;
	}
}
?>
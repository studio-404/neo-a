<?php
namespace lib\functions\url;

use config\main as c;
use lib\functions\url\currenturl as currenturl;

class slug{

	public $params;

	public function params(){
		$this->params = "";
		$geturl = currenturl::geturl();
		$exp = explode(c::WEBSITE, $geturl);
		$ex = explode("?", $exp[1]);
		if(!empty($ex[0])){
			$this->params = explode("/", $ex[0]);
		}
		return $this->params;
	}
}
?>
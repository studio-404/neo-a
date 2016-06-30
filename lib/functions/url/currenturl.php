<?php
namespace lib\functions\url;

class currenturl{

	public static function geturl(){
		$actual_link = sprintf(
			"http://%s%s",
			$_SERVER["HTTP_HOST"],
			$_SERVER["REQUEST_URI"]
		);
		return $actual_link;
	}

}
?>
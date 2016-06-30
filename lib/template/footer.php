<?php
namespace lib\template;

use config\main as c;

class footer{

	public function html_footer(){
		$out = "</body>\n";
		$out .= "</html>\n";
		return $out;
	}

}
?>
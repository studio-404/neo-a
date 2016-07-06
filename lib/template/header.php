<?php
namespace lib\template;

use config\main as c;
use lib\functions\url\currenturl as currenturl;
use lib\database\connection as connection;
use lib\database\pagedata as pagedata;

class header{

	public $page;

	function __construct(){
		$this->connection = new connection();
		$this->conn = $this->connection->conn();
		$pagedata = new pagedata();
		$this->page = $pagedata->select($this->conn);
	}

	public function html_header(){
		$out = "<!DOCTYPE html>\n";
		$out .= "<html>\n";
		$out .= "<head>\n";
		$out .= sprintf(
			"<meta charset=\"%s\" />\n",
			c::CHARSET
		);
		$out .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
		$out .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
		$out .= sprintf(
			"<title>%s - %s</title>\n",
			$this->page['title'], 
			c::NAME
		);
		$out .= sprintf(
			"<meta property=\"og:title\" content=\"%s\" />\n",
			c::NAME
		);
		$out .= "<meta property=\"og:type\" content=\"website\" />\n";
		$out .= sprintf(
			"<meta property=\"og:url\" content=\"%s\"/>\n",
			currenturl::geturl()
		);
		$out .= sprintf(
			"<meta property=\"og:image\" content=\"%spublic/img/fbshare.png\" />\n",
			C::WEBSITE
		);
		$out .= "<meta property=\"og:image:width\" content=\"600\" />\n";
		$out .= "<meta property=\"og:image:height\" content=\"315\" />\n";
		$out .= sprintf(
			"<meta property=\"og:site_name\" content=\"%s\"/>\n",
			c::NAME
		);
		
		$out .= sprintf(
			"<meta property=\"og:description\" content=\"%s\"/>\n",
			$this->page['meta_desc']
		);
		$out .= sprintf(
			"<meta name=\"description\" content=\"%s\">\n",
			$this->page['meta_desc']
		);
		$out .= sprintf(
			"<meta name=\"keywords\" content=\"%s\">\n",
			$this->page['meta_keys']
		);
		
		$out .= $this->favicon();
		$out .= $this->developer();
		$out .= $this->css();
		$out .= $this->js();
		$out .= "</head>\n";
		$out .= '<body>';
		return $out;
	}

	private function developer(){
		$out = sprintf(
			"<meta name=\"author\" content=\"%s\" />\n",
			c::AUTHER
		);
		$out .= sprintf(
			"<link type=\"text/plain\" rel=\"author\" href=\"%shumans.txt\" />\n",
			c::WEBSITE
		);
		return $out;
	}

	private function favicon(){
		$out = sprintf(
			"<link rel=\"icon\" href=\"%spublic/img/favicon.png\" type=\"image/x-icon\"/>\n",
			c::WEBSITE
		);
		$out .= sprintf(
			"<link rel=\"shortcut icon\" href=\"%spublic/img/favicon.png\" type=\"image/x-icon\"/>\n",
			c::WEBSITE
		);
		return $out;
	}

	private function css(){
		$out = sprintf(
			"<link type=\"text/css\" rel=\"stylesheet\" href=\"%spublic/css/style.css\" />\n",
			c::WEBSITE
		);
		$out .= sprintf(
			"<link type=\"text/css\" rel=\"stylesheet\" href=\"%spublic/css/jquery-ui.css\" />\n",
			c::WEBSITE
		);
		return $out;
	}

	private function js(){
		$out = sprintf(
			"<script src=\"%spublic/js/jquery-1.11.2.min.js\" type=\"text/javascript\"></script>\n", 
			c::WEBSITE
		);
		$out .= sprintf(
			"<script src=\"%spublic/js/jquery-ui.js\" type=\"text/javascript\"></script>\n", 
			c::WEBSITE
		);
		$out .= sprintf(
			"<script src=\"%spublic/js/script.js\" type=\"text/javascript\"></script>\n", 
			c::WEBSITE
		);
		return $out;
	}

}
?>
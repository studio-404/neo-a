<?php
namespace lib\functions\load;

use config\main as c;
use lib\ajax\receive as ajax;
use lib\database\connection as connection;
use lib\database\pagedata as pagedata;
use lib\functions\url as url;
use lib\template\header as head;
use lib\database\navigation as navigation;
use lib\template\footer as footer;

class page{
	public $head;
	public $footer;
	public $conn;
	public $page;

	function __construct(){
		$this->connection = new connection();
		$this->conn = $this->connection->conn();
		$pagedata = new pagedata();
		$this->page = $pagedata->select($this->conn);

		$this->request = new url\request();
		if(
			$this->request->method("POST", "ajax")=="true" || 
			$this->request->method("GET", "ajax")=="true"
		){
			$ajax = new ajax();
			echo $ajax->geta();	
			exit();
		}
	}

	public function bootstap(){
		$c = new c();		
		$this->head = new head();
		$this->navObject = new navigation();
		$this->slug = new url\slug();
		$this->params = $this->slug->params();
		$this->nav = $this->navObject->select($this->conn);		
		$this->cat = $this->navObject->cat($this->conn, $this->params);		
		$this->footer = new footer();
		
		echo $this->head->html_header();
		switch ($this->page['pagetype']) { 
			case 'textpage': 
				@include("website/textpage.php");
				break;

			case 'plugin': 
				$file = "website/".$this->page['slug'].".php";
				if($this->page['slug']=="contact-us"){
					$contact_object = new \lib\database\contact();
					$this->contactinfo = $contact_object->info($this->conn);
				}
				if(file_exists($file)){
					@include($file);
				}else{
					@include("website/homepage.php");
				}
				break;
			case 'projectpage':
				$object = new \lib\database\projects();
				$select_one = $object->select_one($this->conn); 
				$this->projectDesc = array_slice($select_one, 0, 1);
				$this->projectPhotos = array_slice($select_one, 1);
				$rightside = array_slice($select_one, 1);
				@include("website/projectpage.php");
				break;
			default:
				$projects_object = new \lib\database\projects();
				$projects = $projects_object->select($this->conn);
				@include("website/homepage.php");
				break;
		}
		echo $this->footer->html_footer();	
	}
}
?>
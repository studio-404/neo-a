<?php
namespace lib\functions\load;

use config\main as c;
use lib\ajax\receive as ajax;
use lib\database\connection as connection;
use lib\database\pagedata as pagedata;
use lib\database\navigation as navigation;
use lib\database\projects as projects;
use lib\functions\url as url;
use lib\template\header as head;
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
		$this->currentSlug = new url\slug();
		$this->params = $this->currentSlug->params();
		$this->cururl = new url\currenturl();
		$this->currenturl = $this->cururl->geturl();
		$this->receivePost();
		if(
			$this->request->method("POST", "ajax")=="true" || 
			$this->request->method("GET", "ajax")=="true"
		){
			$ajax = new ajax();
			echo $ajax->geta();	
			exit();
		}
		if(
			$this->request->method("GET", "crop")=="true" && 
			$this->request->method("GET", "f") && 
			is_numeric($this->request->method("GET", "w")) && 
			is_numeric($this->request->method("GET", "h"))  
		){
			try{
				$crop = new \lib\functions\image\crop();
				readfile($crop->dojob(
					$this->request->method("GET", "f"), 
					$this->request->method("GET", "w"), 
					$this->request->method("GET", "h"), 
					0
				));
			}catch(exception $e){
				echo "Error ...";
			}
			exit();
		}
	}

	private function receivePost(){
		if($this->request->method("POST","postrequest")=="addcatalogitem"){
			$data[0] = $this->request->method("POST","item_title");
			$data[1] = $this->request->method("POST","item_date");
			$data[2] = $this->request->method("POST","item_description");
			$data[3] = $this->request->method("POST","item_catalogList");
			$projects = new projects();
			$projects->insert_project($this->conn, $data);
		}else if($this->request->method("POST","postrequest")=="projectimagesForm"){
			$data[0] = $this->request->method("POST","proid");
			$projects = new projects();
			$projects->insert_project_photos($this->conn, $data);
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
		
		if(empty($this->params[0])){
			echo $this->head->html_header('Welcome');
			$object = new \lib\database\welcome();
			$select = $object->page($this->conn);
			// echo "Welcome Page Image";
			@include("website/welcome.php");
			echo $this->footer->html_footer();
		}else{
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
				case 'homepage':
					$projects_object = new \lib\database\projects();
					$projects = $projects_object->select($this->conn);
					@include("website/homepage.php");
					break;
				default:
					
					break;
			}
			echo $this->footer->html_footer();	
		}
		
	}
}
?>
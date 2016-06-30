<?php
namespace lib\functions\load;

use config\main as c;
use lib\ajax\receive as ajax;
use lib\database\connection as connection;
use lib\database\pagedata as pagedata;
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
		if($this->request->method("POST", "ajax")=="true"){
			$ajax = new ajax();
			echo $ajax->geta();	
			exit();
		}
	}

	public function bootstap(){
		// $slug = new url\slug();
		// $params = $slug->params();
		
		$this->head = new head();
		$this->footer = new footer();
		
		echo $this->head->html_header();
		switch ($this->page['pagetype']) { 
			case 'textpage': 
				// $about_object = new \lib\database\about();
				// $about = $about_object->select($this->conn);
				@include("website/textpage.php");
				break;

			case 'plugin': 
				$file = "website/".$this->page['slug'].".php";
				if(file_exists($file)){
					@include("website/textpage.php");
				}else{
					@include("website/homepage.php");
				}
				break;

			default:
				@include("website/homepage.php");
				break;
		}
		echo $this->footer->html_footer();	
	}
}
?>
<?php
namespace lib\ajax;

use config\main as c;
use lib\functions\url as url;
use lib\database\connection as connection;

class receive{

	function __construct(){
		$this->connection = new connection();
		$this->conn = $this->connection->conn();
		$this->request = new url\request();
		
	}

	public function geta(){

		if($this->request->method("POST", "load")){
			$out = array();
			switch($this->request->method("POST", "load")){
				case "getAbout":
				// $object = new \lib\database\about();
				// $out = $object->select($this->conn);
				break;
			}			
			echo json_encode($out);
		}	

	}
}
?>
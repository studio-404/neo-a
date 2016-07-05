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
		if(
			$this->request->method("GET","ajax") && 
			$this->request->method("GET","uploadFile")
		)
		{
			$str = file_get_contents("php://input");
			$filename = md5(time()).".jpg";
			$path = c::DIR."/".c::PUBLIC_FOLDER_NAME.'/img/team/'.$filename;
			$outFile = c::WEBSITE."/".c::PUBLIC_FOLDER_NAME.'/img/team/'.$filename;
			file_put_contents($path, $str);
			$size = getimagesize($path);
			$extension = image_type_to_extension($size[2]);
			$out = array();
			if($extension==".jpeg"){
				$out["message"] = "Image Uploaded Successfully !"; 
				$out["image_filename"] = $filename; 
				$out["image_tag"] = "<img src=\"".$outFile."\" width=\"100%\" alt=\"\" />"; 
			}else{
				$out["message"] = "Sorry, we could not upload this file !"; 
				$out["image_filename"] = ""; 
				$out["image_tag"] = "Sorry, we could not upload this file !";
			}
			echo json_encode($out);
		}else if($this->request->method("POST", "ajax")){
			$request = json_decode($this->request->method("POST", "r"), true);
			$out = array();
			switch($request[0]){
				case "updateTheStudio":
				$title = $request[1];
				$content = $request[2];
				$out["message"] = "Wow";
				break;
			}			
			echo json_encode($out);
		}


	}
}
?>
<?php
namespace lib\ajax;

use config\main as c;
use lib\functions\url as url;
use lib\database\connection as connection;
use lib\database\pagedata as pagedata;

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
				@unlink($path);
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
				$content = htmlentities($request[2]);
				$file = $request[3];

				if(!empty($file)){
					$sql = 'UPDATE `pages` SET `sub_title`=:sub_title, `text`=:textx, `picture`=:picture WHERE `id`=2';
					$pre = array(
						":sub_title"=>$title, 
						":textx"=>$content, 
						":picture"=>$file 
					);
				}else{
					$sql = 'UPDATE `pages` SET `sub_title`=:sub_title, `text`=:textx WHERE `id`=2';
					$pre = array(
						":sub_title"=>$title, 
						":textx"=>$content
					);
				}
				$prepare = $this->conn->prepare($sql);
				$prepare->execute($pre);
				if($prepare->rowCount()){
					$out["message"] = "Data updated !";
				}else{
					$out["message"] = "Data is not updated !";
				}
				break;
				case "updateContactInfo":
				$address = $request[1];
				$phone = $request[2];
				$email = $request[3];
				$map = $request[4];
				
				$sql = 'UPDATE `contact` SET `address`=:address, `phone`=:phone, `email`=:email, `map`=:map WHERE `id`=1';
				
				$prepare = $this->conn->prepare($sql);
				$prepare->execute(array(
					":address"=>$address, 
					":phone"=>$phone, 
					":email"=>$email, 
					":map"=>$map 
				));
				if($prepare->rowCount()){
					$out["message"] = "Data updated !";
				}else{
					$out["message"] = "Data is not updated !";
				}
				break;
				case "selectCatalog":
				$fetch = array();
				$sql = 'SELECT `id`,`title`,`slug` FROM `pages` WHERE `slug`!="all" AND `pagetype`="catalog" AND `hidden`!=1 AND `status`!=1 ORDER BY `position` ASC';
				$prepare = $this->conn->prepare($sql);
				$prepare->execute();
				if($prepare->rowCount()){
					$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC);
				}
				$out["catalogList"] = $fetch;
				$out["message"] = "Catalog Item Selected !";
				break;
				case "updateCatalogList":
					$x = 0;
					$o = array();
					$pagedata = new pagedata();
					foreach ($request[1] as $v) {
						if($x==0){
							$o['id'][] = $v[1];
							$x++;
						}else if($x==1){
							$o['title'][] = $v[1];
							$x++;
						}else{
							$o['slug'][] = $v[1];
							$x = 0;
						}
					}
					$y = 0;
					foreach ($o["id"] as $v2) {
						$id = $o["id"][$y];
						$title = $o["title"][$y];
						$slug = $o["slug"][$y];
						if($id=="new"){
							if(!empty($title) && !empty($slug)) :
							$sql = 'INSERT INTO `pages` SET 
							`sub`=1, 
							`meta_title`=:meta_title, 
							`title`=:title, 
							`slug`=:slug,  
							`pagetype`=:pagetype,  
							`position`=:position  
							';
							$prepare = $this->conn->prepare($sql);
							$prepare->execute(array(
								":meta_title"=>$title, 
								":title"=>$title, 
								":slug"=>$slug, 
								":pagetype"=>"catalog",
								":position"=>$pagedata->maxCatalogPosition($this->conn) 
							));
							endif;
						}else{
							$sql = 'UPDATE `pages` SET `title`=:title, `slug`=:slug, `position`=:newposition WHERE `id`=:id';
							$prepare = $this->conn->prepare($sql);
							$newposition = $y + 2;
							$prepare->execute(array(
								":title"=>$title, 
								":slug"=>$slug, 
								":id"=>$id,
								":newposition"=>$newposition
							));
						}
						$y++;
					}
					$out["message"] = "Catalog updated !";
				break;
				case "deleteCatalogItem":
				$id = $request[1];
				$sql = 'SELECT `position` FROM `pages` WHERE `id`=:id';
				$prepare = $this->conn->prepare($sql);
				$prepare->execute(array( 
					":id"=>$id 
				));
				if($prepare->rowCount()){
					$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
					$sql2 = 'UPDATE `pages` SET `status`=1 WHERE `id`=:id';
					$prepare2 = $this->conn->prepare($sql2);
					$prepare2->execute(array( 
						":id"=>$id 
					));	
					$sql3 = 'SELECT `id`,`position` FROM `pages` WHERE `position`>:oldposition AND `pagetype`="catalog" AND `status`!=1';
					$prepare3 = $this->conn->prepare($sql3);
					$prepare3->execute(array( 
						":oldposition"=>$fetch['position']
					));	
					if($prepare3->rowCount()){
						$fetch3 = $prepare3->fetchAll(\PDO::FETCH_ASSOC);
						foreach ($fetch3 as $val3) {
							$sql4 = 'UPDATE `pages` SET `position`=:newposition WHERE `id`=:id';
							$prepare4 = $this->conn->prepare($sql4);
							$newposition = $val3['position']-1;
							$prepare4->execute(array(
								":newposition"=>$newposition,
								":id"=>$val3['id']
							));
						}						
					}
					$out["message"] = "Catalog item Deleted successfuly !";
					$out["status"] = "true";
				}				
				break;
			}			
			echo json_encode($out);
		}


	}
}
?>
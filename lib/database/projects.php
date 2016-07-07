<?php
namespace lib\database;

use lib\functions\url\slug as slug;
use config\main as c;
use lib\functions\url\redirect as redirect;
use lib\functions\url\request as request;

class projects{

	public function __construct(){
		$slug = new slug(); 
		$this->params = $slug->params();
		$this->request = new request();
	}
	
	public function select($conn){
		if($this->request->method("GET","search")){
			$searchKey = $this->request->method("GET","search");
			$searchQuery = ' AND (
				`projects`.`title` LIKE "%'.(string)$searchKey.'" OR 
				`projects`.`title` LIKE "'.(string)$searchKey.'%" OR 
				`projects`.`title` LIKE "%'.(string)$searchKey.'%" 
			)';
		}else{
			$searchQuery = "";
		}
		if(empty($this->params[1]) || $this->params[1]=="all"){
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			(SELECT `photoes`.`photo` FROM `photoes` WHERE `projects`.`id`=`photoes`.`projectid` AND `photoes`.`status`!=1 ORDER BY `position` ASC LIMIT 1) AS p_photo 
			FROM 
			`pages`,`projects`
			WHERE 
			`pages`.`status`!=1 AND 
			`pages`.`pagetype`="catalog" AND 
			`pages`.`id`=`projects`.`pageid` AND 
			`projects`.`status`!=1'.$searchQuery.'
			ORDER BY `projects`.`date` DESC LIMIT 8 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute();
		}else{
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			(SELECT `photoes`.`photo` FROM `photoes` WHERE `projects`.`id`=`photoes`.`projectid` AND `photoes`.`status`!=1 ORDER BY `position` ASC LIMIT 1) AS p_photo 
			FROM 
			`pages`, `projects`
			WHERE 
			`pages`.`slug`=:params AND 
			`pages`.`hidden`!=1 AND 
			`pages`.`status`!=1 AND
			`pages`.`id`=`projects`.`pageid` AND
			`projects`.`status`!=1'.$searchQuery.'  
			ORDER BY `projects`.`date` DESC LIMIT 8 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":params"=>$this->params[1]
			));
		}
		$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function select_one($conn){
		$sql = '
		SELECT 
		`projects`.`id` AS row1, 
		`projects`.`date` AS row2, 
		`projects`.`title` AS row3, 
		`projects`.`text` AS row4,  
		`projects`.`position` AS row5  
		FROM 
		`projects`
		WHERE 
		`projects`.`id`=:id AND 
		`projects`.`status`!=1
		UNION ALL
		SELECT 
		`photoes`.`id` AS ph_id, 
		`photoes`.`projectid` AS ph_projectid, 
		`photoes`.`photo` AS ph_photo, 
		`photoes`.`status` AS ph_status, 
		`photoes`.`position` AS ph_position
		FROM 
		`photoes`
		WHERE 
		`photoes`.`projectid`=:id AND 
		`photoes`.`status`!=1 ORDER BY row5 ASC
		'; 
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":id"=>$this->params[1] 
		));
		$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC); 
		return $fetch; 
	} 

	public function insert_project($conn, $data){
		$pageid = (int)$data[3];
		$date = strtotime($data[1]);
		$title = (string)$data[0];
		$description = (string)$data[2];
		
		$sql = 'INSERT INTO `projects` SET 
		`pageid`=:pageid, 
		`date`=:datex, 
		`title`=:title, 
		`text`=:textx 
		';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":pageid"=>$pageid, 
			":datex"=>$date, 
			":title"=>$title, 
			":textx"=>$description
		));
		if($prepare->rowCount()){
			$lastinsertid = $conn->lastInsertId();
			$target_dir = c::DIR.c::PUBLIC_FOLDER_NAME."/img/projects/";
			$x = 0;
			$p = 1; 
			foreach ($_FILES['item_file']['name'] as $val) {
				$imageFileType = explode(".", $_FILES["item_file"]["name"][$x]);
				$imageFileType = end($imageFileType);
				
				$filenamex = md5($_FILES['item_file']['name'][$x].time()).".".$imageFileType;
				$target_file = $target_dir . $filenamex;
				$check = getimagesize($_FILES["item_file"]["tmp_name"][$x]);

				if($check == false) {
					continue;
				}

				if (file_exists($target_file)) {
					continue;
				}
				
				if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
				   continue;
				}
				
				if(move_uploaded_file($_FILES["item_file"]["tmp_name"][$x], $target_file)) 
				{
					$sql2 = 'INSERT INTO `photoes` SET `projectid`=:projectid, `photo`=:photo, `position`=:position'; 
					$prepare = $conn->prepare($sql2); 
					$prepare->execute(array(
						":projectid"=>$lastinsertid, 
						":photo"=>$filenamex, 
						":position"=>$p 
					)); 
					$p++; 
				}
				$x++;
			}
			redirect::url(c::WEBSITE."view/".$lastinsertid+"?admin=true");
		}
	}

	public function insert_project_photos($conn, $data){
		$pageid = (int)$data[0];
		$target_dir = c::DIR.c::PUBLIC_FOLDER_NAME."/img/projects/";
		$x = 0;
		$sqlMax = 'SELECT MAX(`position`) AS mx FROM `photoes` WHERE `projectid`=:projectid AND `status`!=1';
		$prepareMax = $conn->prepare($sqlMax); 
		$prepareMax->execute(array(
			":projectid"=>$pageid
		));
		$fecthmax = $prepareMax->fetch(\PDO::FETCH_ASSOC);
		$p = $fecthmax['mx'] + 1; 
		foreach ($_FILES['projectimages']['name'] as $val) {
			if(empty($_FILES["projectimages"]["name"][$x])){
				continue;
			}
			$imageFileType = explode(".", $_FILES["projectimages"]["name"][$x]);
			$imageFileType = end($imageFileType);
			
			$filenamex = md5($_FILES['projectimages']['name'][$x].time()).".".$imageFileType;
			$target_file = $target_dir . $filenamex;
			$check = getimagesize($_FILES["projectimages"]["tmp_name"][$x]);

			if($check == false) {
				continue;
			}

			if (file_exists($target_file)) {
				continue;
			}
			
			if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
			   continue;
			}
			
			if(move_uploaded_file($_FILES["projectimages"]["tmp_name"][$x], $target_file)) 
			{
				$sql2 = 'INSERT INTO `photoes` SET `projectid`=:projectid, `photo`=:photo, `position`=:position'; 
				$prepare = $conn->prepare($sql2); 
				$prepare->execute(array(
					":projectid"=>$pageid, 
					":photo"=>$filenamex, 
					":position"=>$p 
				)); 
				$p++; 
			}
			$x++;
		}
	}

}
?>
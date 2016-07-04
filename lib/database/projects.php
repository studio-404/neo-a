<?php
namespace lib\database;

use lib\functions\url\slug as slug;

class projects{

	public function __construct(){
		$slug = new slug(); 
		$this->params = $slug->params();
	}
	
	public function select($conn){
		if(empty($this->params[1]) || $this->params[1]=="all"){
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			(SELECT `photoes`.`photo` FROM `photoes` WHERE `projects`.`id`=`photoes`.`projectid` AND `photoes`.`status`!=1 ORDER BY `id` ASC LIMIT 1) AS p_photo 
			FROM 
			`projects`
			WHERE 
			`projects`.`status`!=1
			ORDER BY `projects`.`date` DESC LIMIT 8 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute();
		}else{
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			(SELECT `photoes`.`photo` FROM `photoes` WHERE `projects`.`id`=`photoes`.`projectid` AND `photoes`.`status`!=1 ORDER BY `id` ASC LIMIT 1) AS p_photo 
			FROM 
			`pages`, `projects`
			WHERE 
			`pages`.`slug`=:params AND 
			`pages`.`hidden`!=1 AND 
			`pages`.`status`!=1 AND
			`pages`.`id`=`projects`.`pageid` AND
			`projects`.`status`!=1 
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
		`projects`.`text` AS row4  
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
		`photoes`.`status` AS ph_status 
		FROM 
		`photoes`
		WHERE 
		`photoes`.`projectid`=:id AND 
		`photoes`.`status`!=1
		'; 
		$prepare = $conn->prepare($sql); 
		$prepare->execute(array(
			":id"=>$this->params[1] 
		));
		$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC); 
		return $fetch; 
	} 

}
?>
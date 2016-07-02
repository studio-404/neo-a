<?php
namespace lib\database;

use lib\functions\url\slug as slug;

class projects{
	
	public function select($conn){
		$slug = new slug(); 
		$params = $slug->params();

		if(empty($params[1]) || $params[1]=="all"){
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			`photoes`.`photo` AS p_photo 
			FROM 
			`projects`, `photoes`
			WHERE 
			`projects`.`status`!=1 AND 
			`projects`.`id`=`photoes`.`projectid` AND 
			`photoes`.`status`!=1 
			ORDER BY `projects`.`date` DESC LIMIT 8 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute();
		}else{
			$sql = 'SELECT 
			`projects`.`id` AS p_id, 
			`projects`.`date` AS p_date, 
			`projects`.`title` AS p_title, 
			`photoes`.`photo` AS p_photo 
			FROM 
			`pages`, `projects`, `photoes`
			WHERE 
			`pages`.`slug`=:params AND 
			`pages`.`hidden`!=1 AND 
			`pages`.`status`!=1 AND
			`pages`.`id`=`projects`.`pageid` AND
			`projects`.`status`!=1 AND 
			`projects`.`id`=`photoes`.`projectid` AND 
			`photoes`.`status`!=1 
			ORDER BY `projects`.`date` DESC LIMIT 8 
			';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":params"=>$params[1]
			));
		}
		$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC);
		return $fetch;
	}

}
?>
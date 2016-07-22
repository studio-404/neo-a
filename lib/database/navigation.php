<?php
namespace lib\database;

use lib\functions\url\slug as slug;

class navigation{
	public function select($conn){
		$sql = 'SELECT * FROM `pages` WHERE `pagetype`!="catalog" AND `pagetype`!="projectpage" AND `hidden`!=1 AND `status`!=1 ORDER BY `position` ASC';
		$prepare = $conn->prepare($sql);
		$prepare->execute();
		$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC);
		return $fetch;
	}

	public function cat($conn, $params){
		$fetch = array();
		if($this->checkSub($conn, $params)): 
			$superid = $this->checkSub($conn, $params); 
			$sql = 'SELECT * FROM `pages` WHERE `sub`=:sub AND `pagetype`="catalog" AND `hidden`!=1 AND `status`!=1 ORDER BY `position` ASC';
			$prepare = $conn->prepare($sql);
			$prepare->execute(array(
				":sub"=>(int)$superid
			));
			if($prepare->rowCount()){
				$fetch = $prepare->fetchAll(\PDO::FETCH_ASSOC);
			}
		endif;
		return $fetch;
	}

	public function checkSub($conn, $params){
		if(empty($params[0])){ $params[0]="projects"; }
		else if($params[0]=="view"){ $params[0]="projects"; }
		$sql = 'SELECT `id` FROM `pages` WHERE `slug`=:slug AND`pagetype`!="catalog" AND `hidden`!=1 AND `status`!=1 ORDER BY `position` ASC';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":slug"=>$params[0]
		));
		if($prepare->rowCount() > 0){
			$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
			return $fetch['id'];
		}
		return false;
	}
}
?>
<?php
namespace lib\database;

use lib\functions\url\slug as slug;

class pagedata{
	
	public function select($conn){
		$slug = new slug(); 
		$params = $slug->params();
		if(empty($params[0])){
			$params[0] = "projects";
		}
		$sql = 'SELECT * FROM `pages` WHERE `slug`=:params AND `hidden`!=1 AND `status`!=1';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":params"=>$params[0]
		));
		$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
		return $fetch;
	}

}
?>
<?php
namespace lib\database;

class getSlug{
	public function select($conn, $pageid){
		$slug = "";
		$sql = 'SELECT `slug` FROM `pages` WHERE `id`=:id';
		$prepare = $conn->prepare($sql);
		$prepare->execute(array(
			":id"=>$pageid
		));
		if($prepare->rowCount()){

			$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
			$slug = $fetch['slug'];
		}
		return $slug;
	}
}
?>
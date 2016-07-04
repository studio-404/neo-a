<?php 
namespace lib\database;


class contact{
	
	public function info($conn){	
		$sql = 'SELECT * FROM `contact` WHERE `id`=1';
		$prepare = $conn->prepare($sql);
		$prepare->execute();
		$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
		return $fetch;
	}

}
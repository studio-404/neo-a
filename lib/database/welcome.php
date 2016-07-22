<?php 
namespace lib\database;

class welcome{
	
	public function page($conn){	
		$sql = 'SELECT * FROM `welcome` WHERE `id`=1';
		$prepare = $conn->prepare($sql);
		$prepare->execute();
		$fetch = $prepare->fetch(\PDO::FETCH_ASSOC);
		return $fetch;
	}

}
<?php
namespace lib\database;

use config\main as c;

class connection{

	public $HANDLER;


	public function conn(){
		try{
			$host = sprintf(
				'mysql:host=%s;dbname=%s;charset=utf8',
				c::DB_HOST,
				c::DB
			); 
			$this->HANDLER = new \PDO($host, c::DB_USER, c::DB_PASS); 
			$this->HANDLER->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
			$this->HANDLER->exec("set names utf8"); 
		}catch(PDOException $e){
			die("Sorry, Database connection problem.."); 
		}
		return $this->HANDLER; 
	}

}
?>
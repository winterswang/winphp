<?php
class IDGenerator
{
	private $_id;
	public $table;
	
	public function __construct($table)
	{
		$this->table = $table;
	}
	
	public static function factory($table){
		return new IDGenerator($table);
	}
	
	public function getID()
	{
		return $this->_id;
	}
	
	public function getNextID()
	{
		return generator::model()->getNextId($this->table);
	}
}
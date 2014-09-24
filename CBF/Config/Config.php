<?php namespace CBF\Config;

class Config{
	
	protected $_values ;
	
	public function __construct($values = false) {
		$this->_values = new \stdClass();
		if($values !== false){
			$this->addValues($values);
		}
		
	}
	
	public function get($name){
		return isset($this->_values[$name]) ? $this->_values[$name] : null;
	}
	
	public function set($name, $value){
		$this->_values[$name] = $value;
	}
	
	
	public function __get($name) {
		return $this->get($name);
	}
	
	public function __set($name, $value) {
		return $this->set($name, $value);
	}
	
	public function addValues($values){
		$this->_values = (object)array_merge((array)$this->_values, (array)$values);
	}
	
	
	
	
}

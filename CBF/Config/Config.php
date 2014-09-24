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
		return isset($this->_values->$name) ? $this->_values->$name : null;
	}
	
	public function set($name, $value){
		$this->_values->$name = $value;
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
	
	protected function _parseKey($key, $value) {
		$parts = explode('.', $key);
		$cnt = count($parts);
		while ($cnt >= 0) {
			$value = array($parts[$cnt] => $value);
			$cnt--;
		}
		return $value;
	}
	
	
	protected function _parseValue($key){
		$parts = explode('.', $key);
		
		$value = $this->_values[$parts[0]];
		foreach($parts as $part){
			$value = $value[$part];
		}
		return $value;
	}
	
	
}

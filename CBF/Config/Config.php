<?php namespace CBF\Config;

use \ArrayAccess;

class Config implements ArrayAccess{
	
	protected $_values = array() ;
	
	public function __construct($values = false) {
		
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
	
	public function __isset($name) {
		return isset($this->_values);
	}
	
	public function __unset($name) {
		unset($this->_values[$name]);
	}


	public function addValues($values){
		$this->_values = array_merge($this->_values, $values);
		
	}
	
	
	//ArrayAccess implementation
	
	public function offsetExists($offset) {
		return isset($this->_values[$offset]);
	}
	
	public function offsetGet($offset) {
		return $this->get($offset);
	}
	
	public function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}
	
	public function offsetUnset($offset) {
		unset($this->_values[$offset]);
	}

	
}

<?php namespace CBF\DataObject;

class DataObject implements \IteratorAggregate, \Countable, \ArrayAccess {

	protected $_values;

	public function __construct(array $data = array()) {
		$this->values = $data;
	}
	
	
	public function get($name){
		return isset($this->_values[$name]) ? $this->_values[$name] : null;
	}
	
	public function set($name, $value){
		$this->_values[$name] = $value;
	}
	
	public function addValues($values){
		$this->_values = array_merge($this->_values, $values);	
	}
	
	public function all(){
		return $this->_values;
	}
	
	public function has($name){
		return isset($this->_values[$name]);
	}
	
	
	public function __get($name) {
		return $this->get($name);
	}
	
	public function __set($name, $value) {
		return $this->set($name, $value);
	}
	
	public function __isset($name) {
		return isset($this->_values[$name]);
	}
	
	public function __unset($name) {
		unset($this->_values[$name]);
	}
	
	
	//interfaces implementation
	public function getIterator() {
		return new \ArrayIterator($this->_values);
	}

	public function count() {
		return count($this->_values);
	}
	
	
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
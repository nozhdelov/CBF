<?php namespace CBF\Container;

use \Closure;

class Binding{
	
	protected $_name;
	
	protected $_type;
	
	protected $_schared;
	
	protected $_arguments = array();
	
	public function __construct($name, $type, $schared){
		$this->_name = $name;
		$this->_type = $type;
		$this->_schared = $schared;
	}
	
	
	public function addArgument($value){
		$this->_arguments[] = $value;
	}
	
	public function setArguments(array $arguments){
		$this->_arguments = $arguments;
	}
	
	
	public function getArguments(){
		return $this->_arguments;
	}
	
	
	public function getName(){
		return $this->_name;
	}
	
	public function setName($name){
		return $this->_name = $name;
	}
	
	public function getType(){
		return $this->_type;
	}
	
	public function setType($type){
		return $this->_type = $type;
	}
	
	public function getShared(){
		return $this->_schared;
	}
	
	public function setShared($shared){
		return $this->_name = $shared;
	}
}
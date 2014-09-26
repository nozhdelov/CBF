<?php namespace CBF\Session;

use CBF\Session\Storage;

class Session {
	
	protected $_storage;
	
	
	public function __construct(CBF\Session\Storage $storage) {
		$this->_storage = $storage;;
	}
	
	
	public function get($name){
		return $this->_storage->get($name);
	}
	
	public function set($name, $value){
		return $this->_storage->set($name, $value);
	}
	
	public function has($name){
		return $this->_storage->has($name);
	}
	
	public function remove($name){
		return $this->_storage->remove($name);
	}
	
	
}
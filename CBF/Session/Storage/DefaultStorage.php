<?php namespace CBF\Session\Storage;


class DefaultStorage implements StorageInterface{
	
	public function __construct(CBF\Config\Config $config){}
	
	public function get($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}
	
	public function set($name, $value) {
		$_SESSION[$name] = $value;
	}
	
	public function has($name) {
		return isset($_SESSION[$name]);
	}
	
	public function remove($name) {
		unset($_SESSION[$name]);
	}
	
	public function init(){
		session_start();
	}
}
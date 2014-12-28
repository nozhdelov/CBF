<?php namespace CBF\Routing;

use \Closure;

class Route {
	
	const CONTROLLER_DELIMITER = '@';
	const MODULE_DELIMITER = '/';

	protected $_path;
	protected $_target;
	protected $_module = 'default';
	protected $_controller = false;
	protected $_action = false;
	protected $_params = array();
	protected $_verbs = array();
	
	public function __construct($path, $target, $verbs = array()){
		$this->_path = $path;
		$this->_verbs = $verbs;
		$this->_target = $target;
		
		if(is_string($this->_target)){
			$parts = explode(self::MODULE_DELIMITER, $this->_target);
			if(count($parts) > 1){
				$this->_module = $parts[0];
				$parts = $parts[1];
			} else {
				$parts = $parts[0];
			}
			$parts = explode(self::CONTROLLER_DELIMITER, $parts);
			$this->_controller = $parts[0];
			$this->_action = isset($parts[1]) ? $parts[1] : 'index';
		}
	}
	
	
	public function getPath(){
		return $this->_path;
	}
	
	public function setPath($path){
		$this->_path = $path;
	}
	
	public function getTarget(){
		return $this->_target;
	}
	
	public function setTarget($target){
		$this->_target = $target;
	}
	
	public function getModule(){
		return $this->_module;
	}
	
	public function setModule($module){
		$this->_module = $module;
	}
	
	public function getController(){
		return $this->_controller;
	}
	
	public function setController($controller){
		$this->_controller = $controller;
	}
	
	public function getAction(){
		return $this->_action;
	}
	
	public function setAction($action){
		$this->_path = $action;
	}
	
	public function getVerbs(){
		return $this->_verbs;
	}
	
	public function setVerbs($verbs){
		$this->_verbs = $verbs;
	}
	
	public function getParams(){
		return $this->_params;
	}
	
	public function setParams($params){
		$this->_params = $params;
	}
	
	public function getPathAsRegex(){
		return preg_replace("/{(\w+)}/", "(.+)", $this->_path);
	}
	
	
	public function run(){
		if($this->_target instanceof Closure){
			return call_user_func_array($this->_target, $this->_params);
		}
		$controllerName = ucfirst($this->getController() . 'Controller');
		$controller = new $controllerName;
		return $controller->callAction($this->getAction() . 'Action', $this->_params);
	}

}
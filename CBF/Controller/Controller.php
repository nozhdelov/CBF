<?php namespace CBF\Controller;

use CBF\View\View;

class Controller {
	
	protected $_layout = null;
	
	public function callAction($actionName, $params){
		$this->_setupLayout();
		$result = call_user_func_array(array($this, $actionName), $params);
		
		if($result instanceof View && $result->isNestable() && $this->_layout instanceof View){
			$this->_layout->nest($result);
			return $this->_layout;
		}
		
		
		return $result;
	}
	
	
	public function __call($name, $arguments) {
		throw new \BadMethodCallException('invalid controller method');
	} 
	
	
	protected function _setupLayout(){}
	
	
	
	
}
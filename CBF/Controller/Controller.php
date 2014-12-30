<?php namespace CBF\Controller;

use CBF\View\View;

class Controller {
	
	protected $_layout = null;
	
	
	public function callAction($actionName, $params){
		
		$result = call_user_func_array(array($this, $actionName), $params);
		
		if($result instanceof View && $result->getIsNestable()){
			$this->_setupLayout();
			if($this->_layout instanceof View){
				$this->_layout->nest($result->getName(), $result);
				$result = $this->_layout;
			}
		}

		return $result;
	}
	
	
	public function __call($name, $arguments) {
		throw new \BadMethodCallException('invalid controller method ' . $name);
	} 
	
	
	protected function _setupLayout(){}
	
	
	
	
}
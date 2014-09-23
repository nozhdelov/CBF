<?php namespace CBF\View;

use CBF\View\Engine\EngineInterface;

class View {

	protected $_templatesDir;
	protected $_tplVars = array();
	protected $_engine;
	protected $_template = false;
	protected $_factory;
	protected $_isNestable = true;

	public function __construct(EngineInterface $engine, Factory $factory, $templatesDir, $template = false, $tplVars = array()) {
		$this->_engine = $engine;
		$this->_factory = $factory;
		$this->_templatesDir = $templatesDir;
		$this->_template = $template;
		$this->_tplVars = $tplVars;
	}

	public function assign($name, $value) {
		$this->_tplVars[$name] = $value;
	}

	public function assignByRef($name, &$value) {
		$this->_tplVars[$name] = &$value;
	}

	public function __get($name) {
		if (isset($this->_tplVars[$name])) {
			return $this->_tplVars[$name];
		} else {
			return null;
		}
	}

	public function __isset($name) {
		return isset($this->_tplVars[$name]);
	}

	public function fetch() {
		$path = $this->_templatesDir . DIRECTORY_SEPARATOR . $this->_template;
		$this->_prepareVars();
		
		if (!file_exists($path)) {
			throw new Exception('invalid template file ' . $path);
		}
		
		return $this->_engine->fetch($path, $this->_tplVars);
	}

	public function display($template) {
		echo $this->fetch($template);
	}
	
	
	public function setTemplate($tpl){
		$this->_template = $tpl;
	}
	
	
	public function getTemplate(){
		return $this->_template;
	}
	
	
	
	public function nest($name, $view, $data){
		if($view instanceof View){
			$this->assign($name, $view);
		} else {
			$this->assign($name, $this->factory->make($view, $data));
		}
		
	}
	
	public function getIsNestable(){
		return $this->_isNestable;
	}
	
	
	public function setIsNestable($isNestable){
		$this->_isNestable = $isNestable;
	}


	
	protected function _prepareVars(){
		foreach($this->_tplVars as $key => $value){
			if($value instanceof View){
				$this->_tplVars[$key] = $value->fetch();
			}
		}
	}

}

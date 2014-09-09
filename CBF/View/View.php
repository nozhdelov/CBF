<?php

class View {

	protected $_templatesDir;
	protected $_tplVars = array();
	protected $_engine;
	

	public function __construct() {
		$this->_templatesDir = 'view/';
	}

	public function assign($name, $value) {
		$this->_tplVars[$name] = $value;
	}

	public function assign_by_ref($name, &$value) {
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

	public function fetch($template) {
		if (!file_exists($path)) {
			throw new Exception('invalid template file ' . $path);
		}
		
		return $this->_engine->fetch();
	}

	public function display($template) {
		echo $this->fetch($template);
	}

}

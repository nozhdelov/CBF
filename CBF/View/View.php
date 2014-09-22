<?php

class View {

	protected $_templatesDir;
	protected $_tplVars = array();
	protected $_engine;
	protected $_template;
	

	public function __construct($engine, $templatesDir) {
		$this->_engine = $engine;
		$this->_templatesDir = $templatesDir;
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
		$path = $this->_templatesDir . DIRECTORY_SEPARATOR . $template;
		if (!file_exists($path)) {
			throw new Exception('invalid template file ' . $path);
		}
		
		return $this->_engine->fetch($path, $this->_tplVars);
	}

	public function display($template) {
		echo $this->fetch($template);
	}

}

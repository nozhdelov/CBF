<?php

namespace CBF\View;

use CBF\View\Engine;
use \stdClass;

class Factory {

	protected $_app;

	public function __construct(\CBF\Application\Application $application) {
		$this->_app = $application;
	}

	public function make($template = false, $data = array()) {
		var_dump($this->_app->getConfig('app'));
		$engine = $this->makeEngine($this->_app->getConfig('app')->view->engine);
		$path = $this->_app->getConfig('path')->view;
		return new View($engine, $this, $path, $template, $data);
	}

	public function makeEngine($engineType) {

		switch ($engineType) {
			case 'php' :
				return new Engine\PHPEngine;
				break;
			default :
				throw new \Exception('invalid view engine type');
		}
	}



}
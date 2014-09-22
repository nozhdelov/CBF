<?php namespace CBF\View;

class Factory{
	
	
	protected $_config;
	
	public function __construct(\CBF\Application\Application $application) {
		$this->_config = $application;
	}
	
	
	public function make($params){
		
	}
	
}
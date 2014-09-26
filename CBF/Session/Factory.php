<?php namespace CBF\Session;

use CBF\Session\Storage;

class Factory{
	
	protected $_app;
	
	public function __construct(CBF\Application\Application $application){
		$this->_app = $application;
	}
	
	
	public function make(){
		return new Session($this->makeStorage());
	}
	
	
	public function makeStorage(){
		$config = $this->_app->getConfig('app');
		switch($config['session']['storage']){
			case 'default' : 
				return new Storage\DefaultStorage($config);
			break;
		
			default :
				return new Storage\DefaultStorage($config);
			break;
		}
	}
	
}

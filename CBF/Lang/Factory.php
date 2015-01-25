<?php namespace CBF\Lang;

use CBF\Lang\Translator;

class Factory{
	
	protected $_app;
	
	public function __construct(\CBF\Application\Application $application){
		$this->_app = $application;
	}
	
	
	public function make(){
		$config = $this->_app->getConfig('app');
		$translator = $this->makeTranslator($config['locale']['engine']);
		return new Lang($translator, $config['locale']['lang']);
	}
	
	
	public function makeTranslator($type){
		switch($type){
			case 'dummy' : 
				
				return new Translator\DummyTranslator();
			break;
		
			default :
				return new Translator\DummyTranslator();
		}
	}
	
}

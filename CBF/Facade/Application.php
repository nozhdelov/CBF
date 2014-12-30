<?php namespace CBF\Facade;

class Application extends Facade{
	
	public static function getFacadedClass() {
		return 'Application';
	}

	public static function make(){
		return self::$_container->make('Application');
	}
}

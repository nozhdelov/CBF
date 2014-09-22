<?php namespace CBF\Facade;

use CBF\Container\Container;

class Facade {

	protected static $_container;
	
	public static function __callStatic($method, $args) {
		$instance = self::$_container->make(static::getFacadedClass());
		return call_user_func_array(array($instance, $method), $args);
	}
	
	
	public static function setContainer(\CBF\Container\Container $app){
		static::$_container = $app;
	}
	
	public static function getContainer(){
		return static::$_container;
	}
	
	public static function getFacadedClass(){
		return '';
	}

}
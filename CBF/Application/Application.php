<?php namespace CBF\Application;

use \CBF\Config\Config;
use \CBF\Container\Container;


class Application extends Container{
	

	protected $_configs;
	protected $_configsPath = '';
	protected $_env = 'production';
	protected $_route = null;
	
	
	public function setEnv($env){
		$this->_env = $env;
	} 
	
	public function setConfigsPath($path){
		$this->_configsPath = $path;
	}
	
	public function loadConfig($name){
		$filePath = $this->_configsPath . $name . '.php';
		$this->_configs[$name] = new Config();
		
		$filePath = $this->_configsPath . $this->_env . '/' . $name . '.php';
		if(@file_exists($filePath)){
			$this->_configs[$name]->addValues(include $filePath);
		} else {
			throw new \Exception('can not load config file  ' . $filePath);
		}
	}
	
	
	public function getConfig($name){
		return isset($this->_configs[$name]) ? $this->_configs[$name] : false;
	}
	
	
	public function setConfig($name, \CBF\Config $config){
		$this->_configs[$name] = $config;
	}


	
	public function detectEnv($envs){
		
		if(isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])){
			$hostName = $_SERVER['HTTP_HOST'];
		} else if(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])){
			$hostName = $_SERVER['SERVER_NAME'];
		} else {
			$hostName = gethostname();
		}
		if(array_key_exists($hostName, $envs)){
			$this->_env = $envs[$hostName];
		}
	}
	
	
	public function setRoute(\CBF\Routing\Route $route){
		$this->_route = $route;
	}
	
	
	public function getRoute(){
		return $this->_route;
	}


	public function getRequest(){
		
	}
	
	
	public function run(){
		
		try { 
			$result = $this->_route->run();
			if(is_object($result) || is_string($result)){
				print $result;
			}		
		} catch(Exception $e) {
			print $e;
		}
	}
	
	
	
	
	
}

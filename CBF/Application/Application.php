<?php namespace CBF\Application;

use CBF\Config\Config;
use CBF\Singleton\Singleton;


class Application extends Singleton{
	
	
	
	
	
	protected $_configs;
	protected $_configsPath = '';
	protected $_env = 'global';
	
	
	
	



	public function __construct(){}
	
	public function setEnv($env){
		$this->_env = $env;
	} 
	
	public function setConfigsPath($path){
		$this->_configsPath = $path;
	}
	
	public function loadConfig($name){
		$filePath = $this->_configsPath . $name . '.php';
		$this->_configs[$name] = new Config();
		$this->_configs[$name]->addValues(include $filePath);
		
		$filePath = $this->_configsPath . $this->_env . '/' . $name . '.php';
		if($this->_env && $this->_env !== 'global' && @file_exists($filePath)){
			$this->_configs[$name]->addValues(include $filePath);
		}
	}
	
	
	public function detectEnv($envs){
		$hostName = gethostname();
		if(array_key_exists($hostName, $envs)){
			$this->_env = $envs[$hostName];
		}
	}
	
	
}

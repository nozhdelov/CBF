<?php namespace CBF\Autoloading;

class Autoloader {

	protected static $_paths = array();
	protected static $_aliases = array();

	const FILE_EXTENSION = '.php';
	const NAMESPACE_SEPARATOR = '\\';

	public static function autoload($className) {
		$fileName = '';
		$namespace = '';
		
		if (false !== ($lastNsPos = strripos($className, self::NAMESPACE_SEPARATOR))) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . self::FILE_EXTENSION;
		foreach (self::$_paths as $path) {
			
			$filePath = $path . DIRECTORY_SEPARATOR . $fileName;
			
			if (@file_exists($filePath)) {
				require_once $filePath;
				return;
			}
		}
		throw new \Exception('AUTOLOADER : Could not load ' . $className);
	}
	
	
	public static function loadAliase($className){
		if(array_key_exists($className, self::$_aliases)){
			class_alias(self::$_aliases[$className], $className, true);
		}
	}
	

	public static function addPath($path) {
		self::$_paths[] = $path;
	}

	public static function getPaths() {
		return self::$_paths;
	}

	public static function register() {
		spl_autoload_register('CBF\Autoloading\Autoloader::autoload');
		spl_autoload_register('CBF\Autoloading\Autoloader::loadAliase', true, true);
	}
	
	
	
	public static function addAliases(array $aliases){
		self::$_aliases = array_merge($aliases, self::$_aliases);
	}
	
	public static function getAliases(){
		return self::$_aliases;
	}
	
	public static function addAliase($alias, $path){
		self::$_aliases[$name] = $path;
	}

}

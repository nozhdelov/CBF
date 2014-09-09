<?php namespace CBF\Autoloading;

class Autoloader {

	private static $_paths = array();

	const FILE_EXTENSION = '.php';
	const NAMESPACE_SEPARATOR = '\\';

	public static function autoload($className) {
		foreach (self::$_paths as $path) {

			$fileName = '';
			$namespace = '';
			if (false !== ($lastNsPos = strripos($className, self::NAMESPACE_SEPARATOR))) {
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName = str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}
			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . self::FILE_EXTENSION;
			$filePath = $path . DIRECTORY_SEPARATOR . $fileName;
			
			if(@file_exists($filePath)){
				require_once $filePath;
			} else {
				throw new \Exception('AUTOLOADER : Could not load ' . $filePath);
			}
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
	}

}

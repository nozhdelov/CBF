<?php

namespace CBF\Routing;

class Router{

	protected static $_routes = array();
	
	protected static $_basePath = '/';
	
	public static function add($path, $target, $verbs = array()){
		if(!is_array($verbs)){
			$verbs = array($verbs);
		}
		self::$_routes[] = new Route($path, $target, $verbs);
	}
	
	
	public static function get($path, $target){
		self::add($path, $target, array('GET'));
	}
	
	public static function post($path, $target){
		self::add($path, $target, array('POST'));
	}
	
	
	public static function matchRequest(){
		$requestUrl = $_SERVER['REQUEST_URI'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		if (($pos = strpos($requestUrl, '?')) !== false) {
			$requestUrl = substr($requestUrl, 0, $pos);
		}
		foreach(self::$_routes as $route){
			if(!in_array($requestMethod, $route->getVerbs())){
				continue;
			}
			$matches = array();
			
			if (! preg_match("@^".  self::$_basePath . $route->getPathAsRegex() . "*$@i", $requestUrl, $matches)) {
				continue;
			}
			
			$params = array();
			$argKeys = array();
			if (preg_match_all("/{(.+)}/", $route->getPath(), $argKeys)) {
				// grab array with matches
				$argKeys = $argKeys[1];
				// loop trough parameter names, store matching value in $params array
				foreach ($argKeys as $key => $name) {
					if (isset($matches[$key + 1])) {
						$params[$name] = $matches[$key + 1];
					}
				}
			}
			var_dump($params);
			var_dump($matches);
			//dispatch
			
			return;
			
		}
		
		return false;
	}

}
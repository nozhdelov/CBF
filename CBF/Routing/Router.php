<?php namespace CBF\Routing;

class Router{

	protected $_routes = array();
	
	protected $_basePath = '/';
	
	public function add($path, $target, $verbs = array()){
		if(!is_array($verbs)){
			$verbs = array($verbs);
		}
		$this->_routes[] = new Route($path, $target, $verbs);
	}
	
	
	public function get($path, $target){
		$this->add($path, $target, array('GET'));
	}
	
	public function post($path, $target){
		$this->add($path, $target, array('POST'));
	}
	
	
	public function matchRequest(){
		$requestUrl = $_SERVER['REQUEST_URI'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		if (($pos = strpos($requestUrl, '?')) !== false) {
			$requestUrl = substr($requestUrl, 0, $pos);
		}
		foreach($this->_routes as $route){
			if(!in_array($requestMethod, $route->getVerbs())){
				continue;
			}
			$matches = array();
			
			if (! preg_match("@^".  $this->_basePath . $route->getPathAsRegex() . "*$@i", $requestUrl, $matches)) {
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
				
				$route->setParams($params);
				
			}
			return $route;
		}
		
		return false;
	}

}
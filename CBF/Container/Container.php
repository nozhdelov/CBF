<?php

namespace CBF\Container;

use Closure;
use ReflectionClass;

class Container {

	protected $_bindings;
	protected $_instances;
	protected $_aliases = array();

	public function __construct() {
		
	}
	
	
	public function bindInstance($instance, $type, $name = false){
		$this->bindShared($type, $name);
		$this->_instances[$type] = $instance;
	}

	public function bind($type, $name = false, $shared = false) {
		
		if ($name) {
			$this->_aliases[$name] = $type;
		} else {
			$name = $type;
		}
		
		$binding = new Binding($name, $type, $shared);
		$this->_bindings[$type] = $binding;


		return $binding;
	}
	
	
	public function bindShared($type, $name = false){
		$this->bind($type, $name, true);
	}

	
	public function make($name, $params = array()) {
		$type = array_key_exists($name, $this->_aliases) ? $this->_aliases[$name] : $name;
		
		if(!isset($this->_bindings[$type])){
			throw new ContainerException('Missing binding for ' . $name);
		}
		
		$binding = $this->_bindings[$type];
	
		if (isset($this->_instances[$type])) {
			return $this->_instances[$type];
		}
		
		$object = $this->_build($binding, $params);
		
		if($binding->getShared()){
			$this->_instances[$type] = $object;
		}
		
		return $object;
		
	}

	protected function _build(Binding $binding, $params = array()) {

		$type = $binding->getType();
		if ($type instanceof Closure) {
			return $type($this, $params);
		}

		$reflection = new ReflectionClass($type);
		if (!$reflection->isInstantiable()) {
			throw new ContainerException('Could not create object of class ' . $type);
		}

		$constructor = $reflection->getConstructor();
		
		if (is_null($constructor)) {
			return new $type;
		}

		$classParams = $constructor->getParameters();

		foreach ($classParams as $key => $value) {
			if (is_numeric($key)) {
				unset($params[$key]);
				$params[$classParams[$key]->name] = $value;
			}
		}

		$dependecies = $this->_getDependencies($params, $binding);
		return $reflection->newInstanceArgs($dependecies);
	}

	protected function _getDependencies($params, Binding $binding) {
		$dependencies = array();
		foreach ($params as $parameter) {
			
			
			$dependency = $parameter->getClass();

			if (is_null($dependency)) {
				$dependencies[] = $this->_resolveValueParam($parameter, $binding);
			} else {
				$dependencies[] = $this->_resolveClassParam($parameter, $binding);
			}
		}
		return (array) $dependencies;
	}

	protected function _resolveValueParam(\ReflectionParameter $parameter, Binding $binding) {
		if ($parameter->isDefaultValueAvailable()) {
			return $parameter->getDefaultValue();
		} else {

			$message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
			throw new BindingResolutionException($message);
		}
	}

	
	protected function _resolveClassParam(\ReflectionParameter $parameter, Binding $binding) {
		try {
			return $this->make($parameter->getClass()->name);
		} catch (BindingResolutionException $e) {
			if ($parameter->isOptional()) {
				return $parameter->getDefaultValue();
			} else {
				throw $e;
			}
		}
	}

}

<?php namespace CBF\Http;

use CBF\DataObject\DataObject;

class Request{
	
	
	const METHOD_HEAD = 'HEAD';
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	
	protected $_get;
	protected $_post;
	protected $_cookie;
	protected $_file;
	protected $_server;
	protected $_headers;
	
	
	public function __construct($get = array(), $post = array(), $cookie = array(), $file = array(), $server = array()) {
		
		$this->_get = new DataObject($get);
		$this->_post = new DataObject($post);
		$this->_cookie = new DataObject($cookie);
		$this->_file = new DataObject($file);
		$this->_server = new DataObject($server);
		$this->_headers = new DataObject();
		
		$this->_parseHeaders();
	}
	
	
	public function getIp(){
		if(isset($this->_headers['Client-Ip'])){
			return $this->_headers->get('Client-Ip');
		} elseif(isset($this->_headers['X-Forwarded-For'])){
			return $this->_headers->get('X-Forwarded-For');
		} else {
			return $this->_server->get('REMOTE_ADDR');
		}
	}
	
	
	public function isSecure(){
		if(isset($this->_server['HTTPS']) && !empty($this->_server['HTTPS']) && $this->_server['HTTPS'] !== 'off'){
			return true;
		} elseif(isset($this->_headers['X-Forwarded-Proto']) && $this->_headers['X-Forwarded-Proto'] === 'https'){
			return true;
		} elseif(isset($this->_headers['X-Forwarded-Ssl']) && $this->_headers['X-Forwarded-Ssl'] === 'on'){
			return true;
		} else {
			return false;
		}
	}
	
	
	
	public function isAjax(){
		return isset($this->_headers['X-Requested-With']) && $this->_headers['X-Requested-With'] === 'XMLHttpRequest';
	}

	
	
	public function get($name = false, $filter = false){
		return ($name !== false) ? $this->_get->get($name, $filter) : $this->_get;
	}
	
	
	public function post($name = false, $filter = false){
		return ($name !== false) ? $this->_post->get($name, $filter) : $this->_post;
	} 
	
	
	public function file($name = false, $filter = false){
		return ($name !== false) ? $this->_file->get($name, $filter) : $this->_file;
	}


	public function cookie($name = false, $filter = false){
		return ($name !== false) ? $this->_cookie->get($name, $filter) : $this->_cookie;
	}
	
	
	public function headers($name = false, $filter = false){
		return ($name !== false) ? $this->_headers->get($name, $filter) : $this->_headers;
	}

	protected function _parseHeaders(){
		
		foreach($this->_server as $name => $value){
			if(strpos($name, 'HTTP_') !== false){
				$nameParts = explode('_', $name);
				$headerParts = array();
				for($i = 1; $i < count($nameParts); $i++){
					$headerParts[] = ucfirst(strtolower($nameParts[$i]));
				}
				$this->_headers->set(implode('_', $headerParts), $value);
			}
		}
	}
	
}
<?php namespace CBF\Http;

use CBF\DataObject\DataObject;

class Reuest{
	
	
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

	
	
	public function get($name = false){
		return ($name !== false) ? $this->_get->get($name) : $this->_get->all();
	}
	
	
	public function post($name = false){
		return ($name !== false) ? $this->_post->get($name) : $this->_post->all();
	} 
	
	
	public function file($name = false){
		return ($name !== false) ? $this->_file->get($name) : $this->_file->all();
	}


	public function cookie($name = false){
		return ($name !== false) ? $this->_cookie->get($name) : $this->_cookie->all();
	}
	
	
	public function headers($name = false){
		return ($name !== false) ? $this->_headers->get($name) : $this->_headers->all();
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
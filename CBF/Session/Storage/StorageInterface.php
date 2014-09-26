<?php namespace CBF\Session\Storage;


interface StorageInterface{
	
	public function set($name, $value);
	public function get($name);
	public function has($name);
	public function remove($name);
	
}
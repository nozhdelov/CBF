<?php namespace CBF\View\Engine;

interface EngineInterface{
	
	public function fetch($path, $data = array());
}

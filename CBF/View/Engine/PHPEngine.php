<?php namespace CBF\View\Engine;

class PHPEngine implements EngineInterface{
	
	public function fetch($path, $data = array()){
		extract($data);
		ob_start();
		include $path;
		return ob_get_clean();
	}
	
}



<?php namespace CBF\View\Engine;

class PHPEngine{
	
	public function fetch($path){
		
		
		ob_start();
		
		include $path;
		return ob_get_clean();
	}
	
}



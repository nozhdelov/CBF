<?php

class BaseController extends Controller{
	
	
	protected $_layout = 'layout';
	
	protected function _setupLayout(){
		$this->_layout = View::make($this->_layout);
	}
	
}
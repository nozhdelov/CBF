<?php namespace CBF\Lang;


class Lang {
	
	protected $_translator = null;
	protected $_lang = 'en';
	
	public function __construct( $translator, $lang){
		$this->_translator = $translator;
		$this->_lang = $lang;
	}
	
	
	public function get($tag){
		return $this->_translator->get($tag, $this->_lang);
	}
	
}

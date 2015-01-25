<?php namespace CBF\Lang\Translator;

class DummyTranslator implements TranslatorInteface{
	public function get($tag, $lang){
		return $tag;
	}
}

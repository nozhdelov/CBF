<?php

namespace CBF\Http;

class URL {
	
	public function toAction($path, $params = array()){
		
		$host = isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		return 'http://' . $host . '/' . $path . '&' . $this->buildQueryString($params);
	}
	
	
	public function buildQueryString($params){
		return http_build_query($params);
	}
	
	
	
	public function redirect($path, $params = array()){
		if(headers_sent()){
			echo '<script>window.location.href = "'. $this->toAction($path, $params) .'"</script>';
		} else {
			header("Location:" . $this->toAction($path, $params));
		}
		
		exit;
	}
	
	
	public static function redirectWithMessage($path, $message, $type, $params = array()){
		Session::set('flashMessage', $message);
		Session::set('flashMessageType', $type);
		$this->redirect($path, $params);
	}

}


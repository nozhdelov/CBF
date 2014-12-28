<?php namespace CBF\Database;

class Factory {

	protected $_app;

	public function __construct(\CBF\Application\Application $application) {
		$this->_app = $application;
	}

	public function make() {
		$config = $this->_app->getConfig('app')['database'];
		$pdo = new \PDO($config['server'] . ':host='. $config['host'] .';dbname=' . $config['dbname'], $config['user'], $config['password']);
		return new Adaptor($pdo);
	}


}
<?php namespace CBF\Database;

class Adaptor{
	
	const FETCH_MODE_ASSOC = 1;
	const FETCH_MODE_OBJECT = 2;
	const FETCH_MODE_ARRAY = 3;
	
	private $_PDO;
	private $_defaultFetchMode = self::FETCH_MODE_OBJECT;
	
	private $_PDOFetchModes = array(
	    self::FETCH_MODE_ASSOC => \PDO::FETCH_ASSOC,
	    self::FETCH_MODE_OBJECT => \PDO::FETCH_OBJ,
	    self::FETCH_MODE_ARRAY => \PDO::FETCH_NUM,
	);
	
	public function __construct(\PDO $pdo) {
		$this->_PDO = $pdo;
	}
	
	public function query($sql){
		return $this->_PDO->query($sql);
	}
	
	
	
	public function fetchByQuery($sql, $mode = false){
		$statement = $this->query($sql);
		$mode = $mode === false ? $this->_PDOFetchModes[$this->_defaultFetchMode] : $this->_PDOFetchModes[$mode];
		$res = $statement->fetchAll($mode);
		if(!is_array($res)){
			$res = array();
		}
		return $res;
	}
	
	public function fetchRowByQuery($sql, $mode = false){
		$statement = $this->query($sql);
		$mode = $mode === false ? $this->_PDOFetchModes[$this->_defaultFetchMode] : $this->_PDOFetchModes[$mode];
		return $statement->fetch($mode);
	}


	public function escape($string){
		return $this->_PDO->quote($string);
	}
	
	
	public function all($table, $mide = false){
		$mode = $mode === false ? $this->_PDOFetchModes[$this->_defaultFetchMode] : $this->_PDOFetchModes[$mode];
		$query = "SELECT * FROM `" . $table . "`";
		return $this->fetchByQuery($query, $mode);
	}
	
	
	public  function find($id, $table, $mode = false){
		$query = "SELECT * FROM `" . $table . "` WHERE `id` = " . intval($id);
		$mode = $mode === false ? $this->_PDOFetchModes[$this->_defaultFetchMode] : $this->_PDOFetchModes[$mode];
		return $this->fetchRowByQuery($query, $mode);
	}
	
	
	public  function insert($data, $table){
		$query = "INSERT INTO `" . $table . "` ( ";
		foreach($data as $field => $value){
			$query .= "`". $field ."`,";
		}
		$query = rtrim($query, ",");
		$query .= " ) VALUES (";
		foreach($data as $field => $value){
			$query .=  $value .",";
		}
		$query = rtrim($query, ",");
		$query .= " ) ";
		
		$this->query($query);
		return $this->lastInsertId();
	}
	
	
	public  function update($expr, $data, $table){
		$query = "UPDATE `" . $table . "` SET ";
		foreach($data as $field => $value){
			$query .= "`". $field ."` = ". $value .",";
		}
		$query = rtrim($query, ",");
		if(is_numeric($expr)){
			$query .= " WHERE `id` = " . intval($expr);
		} else {
			$query .= " WHERE " . $expr ;
		}
		
		return $this->query($query);
	}
	
	
	public  function delete($expr, $table){
		$query = "DELETE FROM `" . $table . "`" ;
		if(is_numeric($expr)){
			$query .= " WHERE `id` = " . intval($expr);
		} else {
			$query .= " WHERE " . $expr ;
		}
		return $this->query($query);
	}
	
	
	public function lastInsertId(){
		return $this->_PDO->lastInsertId();
	}
}
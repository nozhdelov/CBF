<?php namespace CBF\Model;



class Model{
	
	const FILED_TYPE_INT = 'FILED_TYPE_INT';
	const FILED_TYPE_FLOAT = 'FILED_TYPE_FLOAT';
	const FILED_TYPE_DOUBLE = 'FILED_TYPE_DOUBLE';
	const FILED_TYPE_STRING = 'FILED_TYPE_STRING';
	const FILED_TYPE_DB_EXPR = 'FILED_TYPE_DB_EXPR';
	
	protected static $_adaptor;
	protected static $_table = '';
	protected static $_fieldsTypes = array();
	
	public static function setAdaptor(\CBF\Database\Adaptor $adaptor){
		static::$_adaptor = $adaptor;
	}
	
	public static function getAdaptor(){
		return self::$_adaptor;
	}
	
	
	
	public static function filter($data){
		foreach($data as $field => $value){
			if(array_key_exists($field, static::$_fieldsTypes)){
				$data[$field] = static::_filterValue(static::$_fieldsTypes[$filed], $value);
			}
		}
		return $data;
	}
	
	
	public static function all(){
		return static::$_adaptor->all(static::$_table);
	}
	
	
	public static function find($id){
		return static::$_adaptor->find($id, static::$_table);
	}
	
	
	public static function fetchByQuery($query, $mode = false){
		return static::$_adaptor->fetchByQuery($query, $mode);
	}
	
	
	
	public static function fetchRowByQuery($query, $mode = false){
		return static::$_adaptor->fetchRowByQuery($query, $mode);
	}
	
	
	public static function query($query){
		return static::$_adaptor->query($query);
	}


	
	public static function save($data){
		$data = static::filter($data);
		return static::$_adaptor->insert($data, static::$_table);
	}
	
	
	public static function update($expr, $data){
		$data = static::filter($data);
		static::$_adaptor->update($expr, $data, static::$_table);
	}
	
	
	public static function insert($data, $table){
		static::$_adaptor->insert($data, $table);
	}
	
	
	public static function delete($expr){
		static::$_adaptor->delete($expr, static::$_table);
	}
	
	
	public static function escape($value){
		return static::$_adaptor->escape($value);
	} 
	
	
	public static function resultByKey($key, $result){
		if(!is_array($result)){
			return $result;
		}
		$return = array();
		foreach($result as $row){
			$key = is_array($row) ? $row[$key] : $row->{$key};
			$return[$key] = $row;
		}
		return $return;
	}
	
	
	protected static function _filterValue($type, $value){
		switch ($type){
			case self::FILED_TYPE_DB_EXPR : 
				return $value;
			break;
			case self::FILED_TYPE_INT : 
				return (int)$value;
			break;
			case self::FILED_TYPE_FLOAT : 
				return (float)$value;
			break;
			case self::FILED_TYPE_DOUBLE : 
				return (double)$value;
			break;
			case self::FILED_TYPE_STRING : 
				return static::$_adaptor->escape($value);
			break;
			default :
				throw new \InvalidArgumentException('unrecognized data field type');
		}
	}
	
}

?>

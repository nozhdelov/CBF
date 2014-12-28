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
	
	
	public static function fetchByQuery($query, $mode = false){
		return static::$_adaptor->fetchByQuery($query, $mode);
	}


	
	public static function save($data){
		$data = static::filter();
		return static::$_adaptor->insert($data, static::$_table);
	}
	
	
	public static function update($expr, $data){
		$data = static::filter($data);
		static::$_adaptor->update($expr, static::$_fieldsValues);
	}
	
	
	public static function delete($expr){
		static::$_adaptor->delete($expr);
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

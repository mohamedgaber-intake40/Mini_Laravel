<?php
namespace Core\Database;
class Database extends Connection
{
    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (parent::$instance) {
            return self::$instance;
        } else {
            return self::$instance = new Database();
        }
    }

    /**
     * @param $table
     * @param array $params
     * @return int
     */
	public static function insert($table ,Array $params)
	{
		$db = self::getInstance();
        $attributes = "";
		$holders = "";
		$values = "";
		foreach ($params as $key => $value)
		{
			!empty($attributes) ? $attributes.= " , " : null;
//			!empty($values) ? $values.= " , " : null;
			!empty($holders) ? $holders.= " , " : null;
			$attributes .= $key ;
			$holders .= "?" ;
//			$values .= "'".$value."'" ;
		}
		$sql = "insert into $table ($attributes) values ($holders)";
		$result = $db->executeData($sql,$params);
		Connection::close_Connection();
		return $result;
	}

    /**
     * @param $table
     * @param array $params
     * @param array $conditions
     * @param null $class
     * @return array
     */
    public static function select($table, Array $params=[], Array $conditions =[],$class = null)
    {
        $db = self::getInstance();

        $params = ! empty($params) ? implode(",",$params) : "*";
        $values = [];
        $filters = "";
        foreach ($conditions as $key => $value)
        {
            !empty($filters) ? $filters.= " and " : null;
            $filters .= " $key = ?";
            $values[] = $value ;
        }
        $sql = "select $params from $table";

        if (! empty($filters))
        {
            $sql .= " where ";
            $sql .= $filters ;
        }
        $result = $db->executeQuery($sql,$values);
        $data = [];
        if ($result)
        {
            if($class){
                $result->setFetchMode(\PDO::FETCH_CLASS,$class);
            }else{
                $result->setFetchMode(\PDO::FETCH_OBJ);
            }
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
        }

        Connection::close_Connection();
        return $data ;

    }

    public static function whereIn($table,$column, Array $arr=[] ,$class = null)
    {
        $db = self::getInstance();
        $in  = str_repeat('?,', count($arr) - 1) . '?';
        $sql = "select * from $table where $column in ($in) ";
        $result = $db->executeQuery($sql,$arr);
        $data = [];
        if ($result)
        {
            if($class){
                $result->setFetchMode(\PDO::FETCH_CLASS,$class);
            }else{
                $result->setFetchMode(\PDO::FETCH_OBJ);
            }
            while ($row = $result->fetch()) {
                $data[] = $row;
            }
        }
        Connection::close_Connection();
        return $data;
    }

    public static function truncate($table)
    {
        $db = self::getInstance();
        $result = $db->truncateTable($table);
        Connection::close_Connection();
        return $result;
    }

    public static function delete($table,$id,$primary_key)
    {
        $db = self::getInstance();
        $sql = "delete from $table where $primary_key = ?";
        $result = $db->execute($sql,[$id]);
        Connection::close_Connection();;
        return $result;

    }

    public static function update($table,$id,$params,$primary_key)
    {
        $db = self::getInstance();
        $params_string = self::generateParamsString($params);
        $sql = "update $table set $params_string where $primary_key = ?";
        $params [] = $id;
        $result = $db->execute($sql,$params);
        Connection::close_Connection();;
        return $result;
    }

    private static function generateParamsString($params)
    {
        $params_string='';
        foreach ($params as $key => $param)
        {
            $params_string .= empty($params_string) ? "$key = ?" :  " , $key = ?";
        }
        return $params_string;
    }



}

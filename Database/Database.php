<?php
namespace Database;
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
	 * @return false|\PDOStatement $result
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
     * @return array
     */
    public static function select($table, Array $params=[], Array $conditions =[])
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
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
        }

        Connection::close_Connection();
        return $data ;

    }



}

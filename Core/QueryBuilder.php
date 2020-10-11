<?php


namespace Core;


use Core\Database\Connection;
use Core\Database\Database;

class QueryBuilder
{
    private $sql;
    private $db;
    private $table;
    private $class_name;
    private $values;
    private $conditions;
    private $has_conditions_string;

    public function __construct($table,$class_name=null)
    {
        $this->sql = "select * from $table";
        $this->table = $table;
        $this->values = [];
        $this->conditions = [];
        $this->class_name = $class_name;
        $this->has_conditions_string = false;
        $this->db = Database::getInstance();
    }

    public function select($columns)
    {
        $columns = func_get_args();
        $columns_string = implode($columns,',');
        $this->sql = str_replace('*' , $columns_string , $this->sql);
        return $this;
    }

    public function join( $table ,$first_column ,$second_column)
    {
//        str_replace('*',"*".$this->table.",*",$this->sql);
        $this->sql .= " inner join $table on $first_column = $second_column ";
        return $this;
    }

    public function orderBy($column,$direction = 'asc')
    {
        if(!$this->has_conditions_string)
            $this->generateConditionsString();

        $this->sql .= " order by $column $direction" ;
        return $this;
    }

    public function limit($limit)
    {
        $this->sql .= " limit $limit";
        return $this;
    }

    public function where($conditions)
    {
        if(!strpos($this->sql,'where'))
            $this->sql .= ' where';
        else
            $this->sql .= ' and';

        $this->conditions = array_merge($this->conditions,$conditions);
        $this->generateConditionsString();

        return $this;
    }

    private function generateConditionsString()
    {
        $filters = "";
        $flag = false;

        foreach ($this->conditions as $key => $value)
        {
            $filters .= " $key = ?";
            empty($filters) ? $filters.= " and " : null;

            $this->values[] = $value ;
            $flag = true;
        }
        $this->sql .= " $filters";

        $this->has_conditions_string = true;
        $this->conditions = [];


    }

    /**
     * @return BaseModel[]
     */
    public function get()
    {
        if(!$this->has_conditions_string)
            $this->generateConditionsString();

        $result = $this->db->executeQuery($this->sql,$this->values);

        $data = [];

        if($this->class_name){
            $result->setFetchMode(\PDO::FETCH_CLASS,$this->class_name);
        }else{
            $result->setFetchMode(\PDO::FETCH_OBJ);
        }
        while ($row = $result->fetch()) {
            $data[] = $row;
        }
        Connection::close_Connection();
        return  $data ;
    }

    public function toSql()
    {
        $this->generateConditionsString();
        return $this->sql;
    }

    public function first()
    {
        if(!$this->has_conditions_string)
            $this->generateConditionsString();

        $this->limit(1);

        return $this->get()[0];
    }
}

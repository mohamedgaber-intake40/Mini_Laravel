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

    public function __construct($table,$class_name=null)
    {
        $this->sql = "select * from $table";
        $this->table = $table;
        $this->class_name = $class_name;
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
        $this->sql .= " order by $column $direction" ;
        return $this;
    }

    public function limit($limit)
    {
        $this->sql .= " limit $limit";
        return $this;
    }

    /**
     * @return BaseModel[]
     */
    public function get()
    {
        $result = $this->db->executeQuery($this->sql,[]);

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
}

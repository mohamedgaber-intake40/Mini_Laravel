<?php


namespace Core;


use Database\Connection;
use Database\Database;

class QueryBuilder
{
    private $sql;
    private $db;
    private $table;

    public function __construct($table)
    {
        $this->sql = "select * from $table";
        $this->table = $table;
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

    public function get()
    {
        $result = $this->db->executeQuery($this->sql,[]);

        $data = [];

        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = (object) $row;
        }
        Connection::close_Connection();
        return  $data ;
    }
}

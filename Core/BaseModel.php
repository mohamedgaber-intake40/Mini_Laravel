<?php


namespace Core;

use Core\Database\Database;
use Core\Interfaces\Model;

class BaseModel implements Model
{
    protected static $table;
    protected  static $primary_key = 'id';

    /**
     * @return $this[];
     */
    public static function all()
    {
        return Database::select(static::$table,[],[],get_called_class());
    }


    /**
     * @param $id
     * @return $this
     */
    public static function find($id)
    {
        return Database::select(static::$table,[],[static::$primary_key=>$id],get_called_class())[0];
    }

    public static function create($data)
    {
        return Database::insert(static::$table,$data);
    }

    /**
     * @param $conditions
     * @return $this[]
     */
    public static function where($conditions)
    {
        return Database::select(static::$table, [], $conditions,get_called_class());
    }

    public static function query()
    {
        return new QueryBuilder(static::$table,get_called_class());
    }

    public function load($relation, $primary_key , $foreign_key, array $conditions = [], $one = false)
    {

        $relation_data=[];

        if($this->has_attribute($foreign_key)){
            $relation_conditions = [$primary_key => $this->$foreign_key];
            $relation_conditions = array_merge($relation_conditions , $conditions);
            $relation_data = $relation::where($relation_conditions);
        }else{
            $relation_conditions = [$foreign_key => $this->$primary_key];
            $relation_conditions = array_merge($relation_conditions , $conditions);
            $relation_data = $relation::where($relation_conditions);
        }

        $relation = strtolower(explode('\\',$relation)[2]);

        if($one){
            $relation_data = $relation_data[0];
        }else{
            $relation .= 's';
        }

        $this->$relation = $relation_data;
    }
    
    protected function has_attribute($attribute)
    {
        return property_exists(static::class,$attribute);
    }

    public static function truncate()
    {
        return Database::truncate(static::$table);
    }

    public function delete()
    {
        $primary_key = static::$primary_key;
        return Database::delete(static::$table,$this->$primary_key, static::$primary_key );
    }

    public function update($params)
    {
        $primary_key = static::$primary_key;
        return Database::update(static::$table, $this->$primary_key, $params ,static::$primary_key);
    }


}

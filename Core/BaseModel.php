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
     * @param array $columns
     * @return $this[]
     */
    public static function where($conditions,$columns=[])
    {
        return Database::select(static::$table, $columns, $conditions,get_called_class());
    }

    /**
     * @param $column
     * @param $arr
     * @return $this[]
     */
    public static function whereIn($column,$arr)
    {
        return Database::whereIn(static::$table,$column,$arr,get_called_class());
    }

    public static function query()
    {
        return new QueryBuilder(static::$table,get_called_class());
    }

    public function loadRelation($relation, $primary_key , $foreign_key, array $conditions = [], $one = false)
    {
        $relation_data=[];

//        $primary_key = $relation::$primary_key;
        if($this->has_attribute($foreign_key) && $foreign_key != static::$primary_key){
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

    protected function hasOne($relation , $foreign_key)
    {
        $this->loadRelation($relation,static::$primary_key,$foreign_key,[],true);
        $relation = strtolower(explode('\\',$relation)[2]);
        return $this->$relation;
    }

    protected function belongTo($relation , $foreign_key)
    {
        $this->loadRelation($relation,static::$primary_key,$foreign_key,[],true);
        $relation = strtolower(explode('\\',$relation)[2]);
        return $this->$relation;
    }

    /**
     * @param $relation
     * @param $foreign_key
     * @return QueryBuilder
     */
    protected function hasMany($relation , $foreign_key)
    {
        $primary_key = static::$primary_key;
        $this->loadRelation($relation,static::$primary_key,$foreign_key,[]);
        return $relation::query()->where([$foreign_key => $this->$primary_key]);
    }


    protected function belongToMany($pivot_relation , $relation, $pivot_foreign_key, $pivot_foreign_key2)
    {
        $relation_data=[];
        $primary_key = static::$primary_key;

        $data = $pivot_relation::where([$pivot_foreign_key2=> $this->$primary_key],[$pivot_foreign_key]);
        $ids = [];

        foreach ($data as $item)
        {
            $ids [] = $item->$pivot_foreign_key;
        }
        $relation_data = $relation::whereIn($relation::$primary_key,$ids);

        $relation = strtolower(explode('\\',$relation)[2]) . 's';
        $this->$relation = $relation_data;

        return $this->$relation;
    }

    public function load($relations)
    {
        $relations = func_get_args();
        foreach ($relations as $relation)
        {
            $this->$relation();
        }
    }




}

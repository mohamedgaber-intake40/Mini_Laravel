<?php
namespace Core\Database;

//require_once $_SERVER['DOCUMENT_ROOT'] . "/med_survey/Config/database.php";

use PDO;

class Connection
{
    protected static $conn;
    protected static $instance;


	protected function __construct()
    {
        self::$conn = new \PDO(sprintf('mysql:host=%s;dbname=%s',DB_HOST,DB_DATABASE),DB_USERNAME ,DB_PASSWORD  );
        if(DEBUG)
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        } else {
            return self::$instance = new Connection();
        }
    }

    /**
     * @param $query
     * @param $values array
     * @return bool|\PDOStatement
     */
    public static function executeQuery($query, $values)
    {
        try
        {
            $result = self::$conn->prepare($query);
            $result->execute($values);

        }
        catch(\PDOException $e)
        {
            $result = false ;
            echo  $e->getMessage();
            echo "<p>". $query. "</p>";
        }
        return $result;
    }

	/**
	 * @param $query string
	 * @param $params array
	 * @return int
	 */
	public static function executeData($query, $params)
	{
	    $params = array_values($params);
        $num = 0;

        $result = self::execute($query,$params);

	    if($result)
	        $num = self::$conn->lastInsertId();

		return $num;
	}

	protected static function execute($query, $params = [])
    {
        $result = false;
        $params = array_values($params);
        try
        {
            $result = self::$conn->prepare($query);
            if ($result)
            {
                $result = $result->execute($params);
            }

        }
        catch(\PDOException $e)
        {
            echo  $e->getMessage();
        }
        return $result;
    }

    public static function truncateTable($table)
    {
        $query = "truncate $table";
        return  self::execute($query);
    }

    public static function close_Connection()
    {
        self::$conn = null ;
		self::$instance = null ;
    }

}
